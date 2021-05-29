<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\User;
use App\Models\Item;
use Weidner\Goutte\GoutteFacade as GoutteFacade;

class ItemController extends Controller {

	public function index() {
	sleep(1);
	$goutte = GoutteFacade::request('GET', 'https://zabuu.site/user/detail/2935683650');
	$date = array();
	$date['user_name'] = $goutte->filter('.user_name_za')->text();
	$date['answerd_count'] = $goutte->filter('.answered_count')->text();
	$date['favorite_count'] = $goutte->filter('.favorite_count')->text();
	$urls = $goutte->filter('a')->extract('href');
	$unique_urls = array_unique($urls);
	foreach ($unique_urls as $url) {
		if (strpos($url, 'https://zabuu.site/questions/') !== false) {
			$questions[] = $url;
		}
	}
		$items = Item::all();
		return view('item.index', compact('items', 'urls'));
	}

	public function detail($id) {
		$item = Item::find($id);
		if ($item) {
			$reviews = DB::table('users')
				->join('reviews', 'reviews.user_id', '=', 'users.id')
				->where('reviews.item_id', $id)
				->get();
			return view('item.detail', compact('item', 'reviews', 'test'));
		} else {
			return redirect('/');
		}
	}
}
