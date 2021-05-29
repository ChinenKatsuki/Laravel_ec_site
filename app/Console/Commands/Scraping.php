<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade as GoutteFacade;

class Scraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
		$goutte = GoutteFacade::request('GET', 'https://www.amazon.co.jp/gp/s/ref=amb_link_1?ie=UTF8&field-enc-merchantbin=AN1VRQENFRJN5%7CA1RJCHJCQT9WV5&field-launch-date=30x-0x&node=2494234051&pf_rd_m=AN1VRQENFRJN5&pf_rd_s=merchandised-search-left-4&pf_rd_r=6CWTB56SQ1GK6RA30VVV&pf_rd_r=6CWTB56SQ1GK6RA30VVV&pf_rd_t=101&pf_rd_p=f72beb25-a5bc-4658-9aa6-7d92f73c2c8b&pf_rd_p=f72beb25-a5bc-4658-9aa6-7d92f73c2c8b&pf_rd_i=637394');
		$goutte->filter('ul#s-results-list-atf')->each(function ($ul) {
			$ul->filter('li')->each(function ($li) {
				dd($li);
			});
		});
	}
}
