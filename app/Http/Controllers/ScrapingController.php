<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade as GoutteFacade;

class ScrapingController extends Controller {

	public function index() {
		sleep(3);
		$goutte = GoutteFacade::request('GET', 'https://zabuu.site/user/detail/2935683650');
		$date = array();
		$date['user_name'] = $goutte->filter('.user_name_za')->text();
		$str = $goutte->filter('.answered_count')->text();
		$date['answerd_count'] = str_replace('総回答数：&nbsp', '', $str);
		$str = $goutte->filter('.favorite_count')->text();
		$date['favorite_count'] = str_replace('いいねされた数：&nbsp', '', $str);
		$urls = $goutte->filter('a')->extract('href');
		$unique_urls = array_unique($urls);
		foreach ($unique_urls as $url) {
			if (strpos($url, 'https://zabuu.site/questions/') !== false) {
				$questions[] = $url;
			}
		}
		return view('scraping.index', compact('date', 'questions'));
	}
}
