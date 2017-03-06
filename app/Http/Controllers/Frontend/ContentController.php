<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\ContentRepositoryInterface;
use Dutchbridge\Repositories\FaqItemRepositoryInterface;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ContentRepositoryInterface $content,
        FaqItemRepositoryInterface $faqItem
    ) {

        $this->content = $content;
        $this->faqItem = $faqItem;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getItem($slug)
    {
        $content = $this->content->selectOneByShopIdAndSlug($this->shopId, $slug);
        $allContent = $this->content->selectAllActiveByShopId($this->shopId);

        if ($content) {
            return view('frontend.content.item')->with(array('content' => $content, 'allContent' => $allContent));
        }

        abort(404);
    }

    public function getFaq()
    {
        $faqItems = $this->faqItem->selectAllActiveByShopIdAndGroupSlug($this->shopId, 'default');

        if ($faqItems) {
            return view('frontend.content.faq')->with(array('faqItems' => $faqItems));
        }
    }
}
