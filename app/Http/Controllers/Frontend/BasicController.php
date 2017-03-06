<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Mail;
use Validator;
use Notification;
use Illuminate\Http\Request;
use BrowserDetect;
use Hideyo\Repositories\ContentRepositoryInterface;
use Hideyo\Repositories\ProductTagGroupRepositoryInterface;
use Hideyo\Repositories\ShopRepositoryInterface;
use GoogleTagManager;

class BasicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, ProductTagGroupRepositoryInterface $productTagGroup, ShopRepositoryInterface $shop, ContentRepositoryInterface $content)
    {
        $this->request = $request;
        $this->content = $content;
        $this->shop = $shop;
        $this->productTagGroup = $productTagGroup;
        $this->shopId = config()->get('app.shop_id');
    }

    public function index()
    {
        if (BrowserDetect::isMobile()) {
            return view('frontend.basic.index-mobile')->with(array());
        } else {
            $populairProducts = $this->productTagGroup->selectAllByTagAndShopId($this->shopId, 'home-populair');

            return view('frontend.basic.index')->with(array('populairProducts' => $populairProducts));
        }
    }

    public function getContact()
    {
        $allContent = $this->content->selectAllActiveByShopId($this->shopId);
        GoogleTagManager::set('pageType', 'contact');
        return view('frontend.basic.contact')->with(array('allContent' => $allContent));
    }

    public function postContact()
    {
        $shop = $this->shop->find($this->shopId);
        if ($shop->wholesale) {
            $email = "verkoop@foodelicious.nl";
        } else {
            $email = "hspecker@foodelicious.nl";
        }

        // create the validation rules ------------------------
        $rules = array(
            'email'            => 'required'
        );

        $input = $this->request->all();

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                \Notification::container('foundation')->error($error);
            }

            GoogleTagManager::flash('formResponse', 'failed');

            return redirect()->to('contact')->withInput();
        } else {
            Mail::send('frontend.email.contact', ['data' => $input], function ($m) use ($input, $email) {

                $m->from($email, 'Foodelicious');
                $m->replyTo($input['email'], $input['name']);
                $m->to($email)->subject(': contactformulier is ingevuld door '.$input['name']);
            });
  
            \Notification::container('foundation')->success('Uw bericht is ontvangen. Wij nemen snel met u contact op.');
            GoogleTagManager::flash('formResponse', 'success');
            return redirect()->back();
        }
        return view('frontend.basic.contact');
    }
}
