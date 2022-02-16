<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

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
     * @return int
     */
    public function handle()
    {
        $sitemap = App::make("sitemap");

        //add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');

        //get all posts from db
        $products = DB::table('products')->orderBy('created_at', 'desc')->get();
        $accessories = DB::table('accessories')->orderBy('created_at', 'desc')->get();
        $blogs = DB::table('blogs')->orderBy('created_at', 'desc')->get();
        $sitemap->add(route('client.product.index'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('client.accessory.index'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('client.blog.index'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('client.contact'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('login'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('login'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('register'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('client.cart.index'), Carbon::now(), 0.8, 'daily');
        $sitemap->add(route('password.request'), Carbon::now(), 0.8, 'daily');
        //add every post to the sitemap
        foreach ($products as $product) {
            $sitemap->add(route('client.product.detail', $product->slug), $product->updated_at, 0.8, 'daily');
        }

        foreach ($accessories as $accessory) {
            $sitemap->add(route('client.accessory.detail', $accessory->slug), $accessory->updated_at, 0.8, 'daily');
        }

        foreach ($blogs as $blog) {
            $sitemap->add(route('client.accessory.detail', $blog->slug), $accessory->updated_at, 0.8, 'daily');
        }

        //generate your sitemap (format, filename)
        $sitemap->store('xml', 'sitemap');
    }
}