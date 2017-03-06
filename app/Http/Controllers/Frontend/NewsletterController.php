<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dutchbridge\Repositories\ShopRepositoryInterface;

class NewsletterController extends Controller
{
    public function __construct(\Mailchimp $mailchimp, ShopRepositoryInterface $shop)
    {
        $this->mailchimp = $mailchimp;
        $this->shop = $shop;
    }

    public function postAdd(Request $request)
    {

        $shop = $this->shop->find(config()->get('app.shop_id'));
        if ($shop->wholesale) {
            $listId = Config::get('mailchimp.wholesaleId');
        } else {
            $listId = Config::get('mailchimp.consumerId');
        }
        $error = false;
        try {
            $this->mailchimp
                ->lists
                ->subscribe(
                    $listId,
                    ['email' => $request->get('email')]
                );
        } catch (\Mailchimp_List_AlreadySubscribed $e) {
            $error = true;
        } catch (\Mailchimp_Error $e) {
            $error = true;
        }

        return view('frontend.newsletter.dialog')->with(
            array('error' => $error)
        );
    }
}
