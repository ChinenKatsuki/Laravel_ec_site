<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Validation\Rule;
use App\Http\Requests\ItemAddRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\CsvUploadRequest;
use SplFileObject;
use Validator;

class ItemController extends Controller {

	public function index() {
		$items = Item::all();
		return view('admin.index', compact('items'));
	}

	public function detail($id) {
		$item = Item::find($id);
		if ($item) {
			return view('admin.detail', compact('item'));
		} else {
			return redirect()->route('admin.item')->with('error', '商品が存在しません');
		}
	}

	public function create(Request $request) {
		return view('admin.create');
	}

	public function add(ItemAddRequest $request) {
		$item = new Item;
		if ($request->image) {
			$image_name = $request->image->store('public/item_images');
			$item->image_name = basename($image_name);
		}
		$item->name = $request->name;
		$item->explain = $request->explain;
		$item->price = $request->price;
		$item->stock = $request->stock;
		$item->save();
		return redirect()->route('admin.item')->with('success', '商品を追加しました');
	}

	public function edit(Request $request, $id) {
		$item = Item::find($id);
		if ($item) {
			return view('admin.edit', compact('item'));
		} else {
			return redirect()->route('admin.item')->with('error', '商品が存在しません');
		}
	}

	public function update(ItemUpdateRequest $request) {
		$item = Item::find($request->id);
		if ($request->image) {
			$image_name = $item->image_name;
			Storage::delete('public/item_images/' . $image_name);
			$item->image_name = null;
			$image_name = $request->image->store('public/item_images');
			$item->image_name = basename($image_name);
		}
		$item->name = $request->name;
		$item->explain = $request->explain;
		$item->stock = $request->stock;
		$item->save();
		return redirect()->route('admin.item')->with('success', '編集しました');
	}

	public function csvExport() {
		$items = Item::all();
		$title = ['ID', '商品名', '商品説明', '値段', '在庫'];
		$response = new StreamedResponse (function() use ($items, $title) {
			$stream = fopen('php://output', 'w');
			stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
			fputcsv($stream, $title);
			foreach ($items as $item) {
				$csv = [
					$item->id,
					$item->name,
					$item->explain,
					$item->price,
					$item->stock,
				];
				fputcsv($stream, $csv);
			}
			fclose($stream);
		});
		$response->headers->set('Content-Type', 'application/octet-stream');
		$response->headers->set('Content-Disposition', 'attachment; filename="item.csv"');
		return $response;
	}

	public function csvUpload (CsvUploadRequest $request) {
		$uploaded_file = $request->file('csv_file');
		$file_path = $request->file('csv_file')->path($uploaded_file);
		$file = new SplFileObject($file_path);
		$file->setFlags(SplFileObject::READ_CSV);
		$row_count = 1;
		foreach ($file as $row) {
			if ($row_count > 1) {
				$validator = Validator::make($row, [
					'0' => 'nullable|numeric',
					'1' => 'required|max:30',
					'2' => 'required',
					'3' => 'required|integer|min:1|max:10000000',
					'4' => 'required|integer|min:0|max:10000',
				])->validate();
				$id = $row[0];
				$name = $row[1];
				$explain = $row[2];
				$price = $row[3];
				$stock = $row[4];
				$item = Item::where('id', $id)->where('name', $name)->first();
				if ($item) {
					$item->explain = $explain;
					$item->price = $price;
					$item->stock = $stock;
					$item->save();
				}
				if (!$item) {
					$item = Item::where('name', $name)->first();
					if ($item) {
						return redirect()->route('admin.item')->with('error', '既に登録されている商品名は登録できません');
					} else {
						$item_new = new Item;
						$item_new->name = $name;
						$item_new->explain = $explain;
						$item_new->price = $price;
						$item_new->stock = $stock;
						$item_new->save();
					}
				}
			}
			$row_count++;
		}
		return redirect()->route('admin.item')->with('success', 'csvファイルをアップロードしました');
	}
}

