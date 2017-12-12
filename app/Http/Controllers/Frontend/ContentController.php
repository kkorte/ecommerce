<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Hideyo\Repositories\ContentRepositoryInterface;
use Hideyo\Repositories\ContentCategoryRepositoryInterface;
use Hideyo\Repositories\FaqItemRepositoryInterface;

class ContentController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Content Controller
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ContentRepositoryInterface $content,
        ContentCategoryRepositoryInterface $category,
        FaqItemRepositoryInterface $faqItem
    ) { 
        $this->content = $content;
        $this->category = $category;
        $this->faqItem = $faqItem;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getItem($slug)
    {
        $content = $this->content->selectOneByShopIdAndSlug(config()->get('app.shop_id'), $slug);

        if ($content) {
            if ($content->slug != $slug) {
                return redirect()->route('text', array('slug' => $content->slug));
            }

            return view('frontend.text.index')->with(array('content' => $content));
        }

        abort(404);
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getOverview($slug)
    {
        $category = $this->category->selectOneByShopIdAndSlug(config()->get('app.shop_id'), $slug);
        if ($category) {
              return view('frontend.text.overview')->with(array('category' => $category));
        }

        abort(404);
    }


    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getFaq()
    {
        $faqItems = $this->faqItem->selectAllActiveByShopId(config()->get('app.shop_id'));

        if ($faqItems) {
            return view('frontend.text.faq')->with(array('faqItems' => $faqItems));
        }

        abort(404);
    }
}
