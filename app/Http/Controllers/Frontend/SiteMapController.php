<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App;
use App\Product;
use URL;
use DB;
use Carbon\Carbon;
use Dutchbridge\Repositories\ProductCategoryRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;

class SitemapController extends Controller
{

    public function __construct(
        ProductCategoryRepositoryInterface $productCategory,
        ProductRepositoryInterface $product
    ) {
        $this->productCategory = $productCategory;
        $this->product = $product;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getIndex()
    {
        $sitemap = App::make("sitemap");

        $sitemap->addSitemap(route('sitemap.product-categories'), Carbon::now());
        $sitemap->addSitemap(route('sitemap.product'), Carbon::now());

        return $sitemap->render('sitemapindex');
    }


    public function getProductCategories()
    {
        $sitemap = App::make("sitemap");
        $posts = $this->productCategory->selectAllByShopId($this->shopId);
      
        foreach ($posts as $post) {
            if ($post->active and $post->products()->count()) {
                $sitemap->add(route('product-category', $post->slug), Carbon::now(), '1.0', 'daily');
            }
        }

        return $sitemap->render('xml');
    }

    public function getProducts()
    {     
        $sitemap = App::make("sitemap");
        $posts = $this->product->selectAllByShopId($this->shopId);
  
        foreach ($posts as $post) {
            $sitemap->add(route('product.item', array('categorySlug' => $post->slug, 'productId' => $post->id, 'productSlug' => $post->slug)), Carbon::now(), '1.0', 'daily');
        }

        return $sitemap->render('xml');
    }

    public function getProductFeedOverview()
    {
        $sitemap = App::make("sitemap");
        $posts = $this->productCategory->selectAllByShopId($this->shopId);

        foreach ($posts as $post) {
            if ($post->active and $post->products()->count()) {
                $sitemap->add(route('sitemap.productfeed.category', array('productCategoryId' => $post->id, 'productCategorySlug' => $post->slug)), Carbon::now(), '1.0', 'daily');
            }
        }

        return $sitemap->render('xml');
    }

    public function getProductFeedAll()
    {
        $posts = $this->product->selectAllByShopIdFrontend($this->shopId);

        $xml =  view('frontend.basic.productfeed')->with(array('products' => $posts));

        return response()->make($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function getProductFeedByCategory($categoryId, $categorySlug)
    {
        $posts = $this->product->selectAllByShopIdAndProductCategoryId($this->shopId, $categoryId);

        $xml =  view('frontend.basic.productfeed')->with(array('products' => $posts));

        return response()->make($xml, '200')->header('Content-Type', 'text/xml');
    }
}
