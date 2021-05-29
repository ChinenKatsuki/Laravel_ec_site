<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\EmailChange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;

class UserController extends Controller {

	public function index() {
		$auth = Auth::user();
		return view('user.index', compact('auth'));
	}

	public function editName() {
		$auth = Auth::user();
		return view('user.editName', compact('auth'));
	}

	public function updateName(Request $request) {
		$request->validate([
			'user_name' => 'required|max:30',
			'old_password' => 'required'
		]);
		$password = Auth::user()->password;
		$pass_check = Hash::check($request->old_password, $password);
		if ($pass_check) {
			$user = User::find(Auth::id());
			$user->name = $request->user_name;
			$user->save();
			return redirect()->route('user.index')->with('success', '名前を編集しました');
		} else {
			return redirect()->route('user.edit.name')->with('error', 'パスワードが正しくありません');
		}
	}

	public function editEmail() {
		$auth = Auth::user();
		return view('user.editEmail', compact('auth'));
	}

	public function sendEmail(Request $request) {
		EmailChange::where('email', $request->email)->delete();
		$request->validate([
			'email' => 'required|email|unique:users|max:100',
			'old_password' => 'required'
		]);
		$email = $request->email;
		$password = Auth::user()->password;
		$pass_check = Hash::check($request->old_password, $password);
		if ($pass_check) {
			$to = ['email' => $email];
			Mail::to($to)->send(new SendMail());
			return redirect()->route('user.index')->with('success', 'パスワードリセットメールを送信しました。30分経ってもメールが届かない場合は、入力されたメールアドレスが間違っているか、迷惑メールフォルダに入っている可能性がありますので確認してください。');
		} else {
			return redirect()->route('user.edit.email')->with('error', 'パスワードが正しくありません');
		}
	}

	public function updateEmail(Request $request, $email, $token) {
		$email_change = EmailChange::where('email', $email)->where('token', $token)->first();
		$token_limit = date('Y-m-d H:i:s', time() - 1800);
		$user = User::find(Auth::id());
		if ($email_change && $email_change->created_at > $token_limit) {
			DB::transaction(function() use ($user, $email, $email_change, $token) {
				$user->email = $email;
				$user->save();
				EmailChange::where('email', $email)->where('token', $token)->delete();
			});
			return redirect()->route('user.index')->with('success', 'メールアドレスを変更しました');
		} else {
			return redirect()->route('user.index')->with('error', 'メールアドレスを変更できませんでした。');
		}
	}

	public function editPassword() {
		$auth = Auth::user();
		return view('user.editPassword', compact('auth'));
	}

	public function updatePassword(Request $request) {
		$password = Auth::user()->password;
		$request->validate([
			'old_password' => 'required',
			'password' => 'required|confirmed|min:6|max:30',
			'password_confirmation' => 'required|min:6|max:30'
		]);
		$pass_check = Hash::check($request->old_password, $password);
		if ($pass_check) {
			$user = User::find(Auth::id());
			$user->password = Hash::make($request->password);
			$user->save();
			return redirect()->route('user.index')->with('success', 'パスワードの変更をしました');
		} else {
			return redirect()->route('user.edit.password')->with('error', 'パスワードが正しくありません');
		}
	}
}
