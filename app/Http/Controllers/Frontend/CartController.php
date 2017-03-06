<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Dutchbridge\Services\Cart;
use Dutchbridge\Repositories\SendingMethodRepositoryInterface;
use Dutchbridge\Repositories\PaymentMethodRepositoryInterface;
use Dutchbridge\Repositories\SendingPaymentMethodRelatedRepositoryInterface;
use Dutchbridge\Repositories\OrderStatusEmailTemplateRepository;
use Dutchbridge\Repositories\ClientRepositoryInterface;
use Dutchbridge\Repositories\ClientAddressRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;
use Dutchbridge\Repositories\OrderRepositoryInterface;
use Dutchbridge\Repositories\CouponRepositoryInterface;
use Dutchbridge\Repositories\ShopRepositoryInterface;
use Dutchbridge\Repositories\ProductTagGroupRepositoryInterface;
use Dutchbridge\Repositories\OrderPaymentLogRepositoryInterface;
use Auth;
use Validator;
use Notification;
use Mail;
use App\ProductAttribute;
use Mollie_API_Client;
use Mollie_API_Object_Method;
use Illuminate\Http\Request;
use BrowserDetect;
use App\Events\OrderChangeStatus;
use Event;
use GoogleTagManager;

class CartController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Cart Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your shopping cart.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        Cart $cart,
        SendingMethodRepositoryInterface $sendingMethod,
        ProductRepositoryInterface $product,
        ClientRepositoryInterface $client,
        ClientAddressRepositoryInterface $clientAddress,
        PaymentMethodRepositoryInterface $paymentMethod,
        ShopRepositoryInterface $shop,
        OrderStatusEmailTemplateRepository $orderStatusEmailTemplate,
        OrderRepositoryInterface $order,
        CouponRepositoryInterface $coupon,
        SendingPaymentMethodRelatedRepositoryInterface $sendingPaymentMethodRelated,
        ProductTagGroupRepositoryInterface $productTagGroup,
        OrderPaymentLogRepositoryInterface $orderPaymentLog
    ) {

        $this->cart             = $cart->getInstance();
        $this->shop             = $shop;
        $this->sendingMethod    = $sendingMethod;
        $this->product          = $product;
        $this->client           = $client;
        $this->clientAddress    = $clientAddress;
        $this->paymentMethod    = $paymentMethod;
        $this->orderStatusEmailTemplate = $orderStatusEmailTemplate;
        $this->order            = $order;
        $this->coupon           = $coupon;
        $this->sendingPaymentMethodRelated = $sendingPaymentMethodRelated;
        $this->productTagGroup  = $productTagGroup;
        $this->orderPaymentLog  = $orderPaymentLog;
        $this->shopId           = config()->get('app.shop_id');
        $request->session()->forget('category_id');        
    }


    public function getIndex()
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId($this->shopId);
        if ($sendingMethodsList->first()) {
            $paymentMethodsList = $sendingMethodsList->first()->relatedPaymentMethods;
        } else {
            $paymentMethodsList = $this->paymentMethod->selectAllActiveByShopId($this->shopId);
        }

        $summary = $this->cart->summary();

        if ($summary) {
            if (empty($summary->totals()['sending_method']) and $sendingMethodsList->first()) {
                self::updateSendingMethod($sendingMethodsList->first()->id);
            }

            if (empty($summary->totals()['payment_method']) and $paymentMethodsList->first()) {
                self::updatePaymentMethod($paymentMethodsList->first()->id);
            }
        } else {
            $this->cart->destroyInstance($this->cart);
        }

        $summary = $this->cart->summary();

        $products = "";
        $totals = "";

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
            $paymentMethodsList = $summary->paymentMethods();
        }

        $user = Auth::guard('web')->user();

        $shop = $this->shop->find($this->shopId);

        if ($shop->wholesale and Auth::guard('web')->guest()) {
            return redirect()->to('account/login');
        }

        $populairProducts = $this->productTagGroup->selectAllByTagAndShopId($this->shopId, 'empty-cart');

        if (BrowserDetect::isMobile()) {
            return view('frontend.cart.index-mobile')->with(array('populairProducts' => $populairProducts, 'user' => $user, 'products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
        } else {
            return view('frontend.cart.index')->with(array('populairProducts' => $populairProducts, 'user' => $user, 'products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
        }
    }

    public function checkout(Request $request)
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId($this->shopId);
        $paymentMethodsList = $this->paymentMethod->selectAllActiveByShopId($this->shopId);

        $products = $this->cart->products();
        $summary = $this->cart->summary();
        $product = "";
        $totals = "";

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
            $paymentMethodsList = $summary->paymentMethods();

            if ($totals['sending_method_id'] == 0) {
                Notification::container('foundation')->error('Selecteer een verzendwijze');
                return redirect()->to('winkelwagen');
            }

            if ($totals['payment_method_id'] == 0) {
                Notification::container('foundation')->error('Selecteer een betaalwijze');
                return redirect()->to('winkelwagen');
            }
        } else {
            return redirect()->to('winkelwagen');
        }

        $dataLayerProduct = array();

        if ($products) {
            foreach ($products as $product) {
                $dataLayerProduct[] = array(
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'category' => $product['product_category_slug'],
                    'price' => $product['price_details']['orginal_price_inc_tax_number_format'],
                    'quantity' => $product['cart']['count']
                );
            }
        }


        $shop = $this->shop->find($this->shopId);

        if ($shop->wholesale) {
            $clientType = 'wholesale';
        } else {
            $clientType = 'consumer';
        }

        $dataLayer = array(
            'event' => 'checkoutConfirmed',
            'clientType' => $clientType,
            'ecommerce' => array(
                'checkout' => array(
                    'actionField' => array(
                        'step' => 'confirm_page',
                        'option' =>  $totals['payment_method']['title'],
                        'revenue' => $totals['sub_total_inc_tax_number_format'],
                        'shipping' => $totals['sending_method_cost_inc_tax']
                    ),
                    'products' => [$dataLayerProduct]
                )
            )
        );

        if ($shop->wholesale and Auth::guard('web')->guest()) {
            return redirect()->to('account/login');
        }


        if (Auth::guard('web')->guest()) {
            $noAccountUser = $request->session()->get('noAccountUser');
            if ($noAccountUser) {
                if (!isset($noAccountUser['delivery'])) {
                    $noAccountUser['delivery'] = $noAccountUser;
                    $request->session()->put('noAccountUser', $noAccountUser);
                }
                return view('frontend.cart.checkout-no-account')->with(array('dataLayer' => $dataLayer, 'noAccountUser' =>  $noAccountUser, 'products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
            } else {
                return view('frontend.cart.login')->with(array('dataLayer' => $dataLayer, 'products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
            }
        } else {
            $user = Auth::guard('web')->user();

            if (!$user->clientDeliveryAddress()->count()) {
                $this->client->setBillOrDeliveryAddress($this->shopId, $user->id, $user->clientBillAddress->id, 'delivery');
                return redirect()->to('cart/checkout');
            }
            return view('frontend.cart.checkout')->with(array('dataLayer' => $dataLayer, 'user' =>  $user, 'products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
        }
    }

    public function postCheckoutLogin(Request $request)
    {

        // create the validation rules ------------------------
        $rules = array(
            'email'            => 'required|email',     // required and must be unique in the ducks table
            'password'         => 'required'
            );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            // get the error messages from the validator
            foreach ($validator->errors()->all() as $error) {
                Notification::container('foundation')->error($error);
            }

            // redirect our user back to the form with the errors from the validator
            return redirect()->to('cart/checkout')
            ->withErrors(true, 'login')->withInput();
        } else {
            $userdata = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'confirmed' => 1,
                'active' => 1,
                'shop_id' => $this->shopId
                );


            /* Try to authenticate the credentials */
            if (Auth::guard('web')->attempt($userdata)) {
                $auth = Auth::guard('web');
                $this->client->updateLastlogin($auth->user()->id);
                // we are now logged in, go to admin
                return redirect()->to('cart/checkout');
            } else {
                if ($this->client->oldPasswordCheck($userdata)) {
                    if (Auth::guard('web')->attempt($userdata)) {
                        $auth = Auth::guard('web');
                        $this->client->updateLastlogin($auth->user()->id);
                        return redirect()->to('cart/checkout');
                    } else {
                        Notification::container('foundation')->error('Gegevens zijn niet correct');
                        return redirect()->to('cart/checkout')->withErrors(true, 'login')->withInput();
                    }
                }
                Notification::container('foundation')->error('Gegevens zijn niet correct');
                return redirect()->to('cart/checkout')->withErrors(true, 'login')->withInput();
            }
        }
    }

    public function postCheckoutRegister(Request $request)
    {
        $userdata = $request->all();

        $rules = array(
            'email'                 => 'required|email',     // required and must be unique in the ducks table
            'password'              => 'required',
            'firstname'     => 'required',
            'lastname'      => 'required',
            'zipcode'       => 'required|max:8',
            'housenumber'   => 'required',
            'housenumber_suffix'   => 'max:4',
            'street'                => 'required',
            'city'                  => 'required',
            'country'               => 'required'
            );

        if (!$userdata['password']) {
            unset($rules['email']);
            unset($rules['password']);
        }

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            // get the error messages from the validator
            foreach ($validator->errors()->all() as $error) {
                Notification::container('foundation')->error($error);
            }
            // redirect our user back to the form with the errors from the validator
            return redirect()->to('cart/checkout')
            ->withErrors(true, 'register')->withInput();
        } else {
            if ($userdata['password']) {
                $registerAttempt = $this->client->validateRegister($userdata, $this->shopId);

                if ($registerAttempt) {
                    $register = $this->client->register($userdata, $this->shopId);
                } else {
                    $client = $this->client->findByEmail($userdata['email'], $this->shopId);

                    if ($client->account_created) {
                        Notification::container('foundation')->error('Je hebt al een account. Login aan de linkerkant of vraag een nieuw wachtwoord aan.');
                        return redirect()->to('cart/checkout')->withInput()->withErrors('Dit emailadres is al in gebruik. Je kan links inloggen.', 'register');
                    } else {
                        $register = $this->client->createAccount($userdata, $this->shopId);
                    }
                }

                if ($register) {
                    $data = $register;
                    Mail::send('frontend.email.register-mail', array('password' => $userdata['password'], 'user' => $data->toArray(), 'billAddress' => $data->clientBillAddress->toArray()), function ($message) use ($data) {
                        $message->to($data['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Je bent geregistreerd.');
                    });


                    $userdata = array(
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                    'confirmed' => 1,
                    'active' => 1

                    );

                    Auth::guard('web')->attempt($userdata);

                    $auth = Auth::guard('web');
                    if ($auth->check()) {
                        $this->client->updateLastlogin($auth->user()->id);
                    }
                    
                    return redirect()->to('cart/checkout')->withErrors('Je bent geregistreerd. Er is een bevestigingsmail gestuurd.', 'login');
                } else {
                    Notification::container('foundation')->error('Je hebt al een account');
                    return redirect()->to('cart/checkout')->withErrors(true, 'register')->withInput();
                }
            } else {
                unset($userdata['password']);
                $registerAttempt = $this->client->validateRegisterNoAccount($userdata, $this->shopId);

                if ($registerAttempt) {
                    $register = $this->client->register($userdata, $this->shopId);
                    $userdata['client_id'] = $register->id;
                } else {
                    $client = $this->client->findByEmail($userdata['email'], $this->shopId);
                    if ($client) {
                        $userdata['client_id'] = $client->id;
                    }
                }

                $request->session()->put('noAccountUser', $userdata);
                return redirect()->to('cart/checkout');
            }
        }
    }

    public function postComplete(Request $request)
    {
        $shop = $this->shop->find($this->shopId);
        if (!$shop->wholesale) {
            $noAccountUser = $request->session()->get('noAccountUser');
        } else {
            $noAccountUser = false;
        }

        if (Auth::guard('web')->guest() and !$noAccountUser) {
            return redirect()->to('cart/checkout');
        } else {
            $summary = $this->cart->summary();
            if (!$summary) {
                return redirect()->to('cart/checkout');
            }

            $totals = $summary->totals();
            $commentsField = $request->get('comments');

            $data = array(
                'user_id' => null,
                'price_with_tax' => $totals['total_inc_tax'],
                'price_without_tax' => $totals['total_ex_tax'],
                'products' => $summary->products(),
                'comments' => $commentsField,
                'browser_detect' => serialize(BrowserDetect::toArray())
            );

            if ($totals['sending_method']) {
                $data['sending_method'] = $totals['sending_method']['id'];
                $data['sending_method_cost_inc_tax'] = $totals['sending_method_cost_inc_tax'];
                $data['sending_method_cost_ex_tax'] = $totals['sending_method_cost_ex_tax'];
            }

            if ($totals['payment_method']) {
                $data['payment_method'] = $totals['payment_method']['id'];
                $data['payment_method_cost_inc_tax'] = $totals['payment_method_cost_inc_tax'];
                $data['payment_method_cost_ex_tax'] = $totals['payment_method_cost_ex_tax'];
            }


            if ($totals['present']) {
                $data['present_gender'] = $totals['present']['gender'];
                $data['present_occassion'] = $totals['present']['occassion'];
                $data['present_message'] = $totals['present']['message'];
                $data['present'] = $totals['present'];
            }



            if ($totals['coupon']) {
                $data['coupon_title'] = $totals['coupon']['title'];
                if ($totals['coupon']->couponGroup) {
                    $data['coupon_group_title'] = $totals['coupon']->couponGroup->title;
                }
                $data['coupon_code'] = $totals['coupon_code'];
                $data['coupon_id'] = $totals['coupon_id'];
                $data['coupon_value'] = $totals['coupon']['value'];
                $data['coupon_type'] = $totals['coupon']['type'];
                $data['coupon_discount_way'] = $totals['coupon']['discount_way'];
                $data['total_discount'] = $totals['discount'];
            } elseif ($totals['discount']) {
                $data['total_discount'] = $totals['discount'];
            }


            if (Auth::guard('web')->check()) {
                $data['user_id'] = Auth::guard('web')->user()->id;
            } else {
                $data['user_id'] = $noAccountUser['client_id'];
            }

            $orderInsertAttempt = $this->order->createByUserAndShop($data, $this->shopId, $noAccountUser);



            if ($orderInsertAttempt->count()) {
                if ($orderInsertAttempt->OrderPaymentMethod->paymentMethod->order_confirmed_order_status_id) {
                    $orderStatus = $this->order->updateStatus($orderInsertAttempt->id, $orderInsertAttempt->OrderPaymentMethod->paymentMethod->order_confirmed_order_status_id);
                
                    if ($orderInsertAttempt->OrderPaymentMethod->paymentMethod->order_confirmed_order_status_id) {
                        Event::fire(new OrderChangeStatus($orderStatus));
                    }
                }

                $paymentMethodId = $orderInsertAttempt->OrderPaymentMethod->payment_method_id;
                $sendingMethodId = $orderInsertAttempt->OrderSendingMethod->sending_method_id;
                $request->session()->put('orderData', $orderInsertAttempt);

                if ($orderInsertAttempt->OrderPaymentMethod->paymentMethod->payment_external) {
                    return redirect()->to('cart/payment');
                } else {
                    $orderTemplate = $this->sendingPaymentMethodRelated->selectOneByShopIdAndPaymentMethodIdAndSendingMethodId($this->shopId, $paymentMethodId, $sendingMethodId);

                    if ($orderTemplate and $orderTemplate->payment_confirmed_text) {
                        $body = $this->replaceTags($orderTemplate->payment_confirmed_text, $orderInsertAttempt);
                    } else {
                        $body = 'payment_confirmed_text not set';
                    }
                    $this->cart->destroyInstance($this->cart);
                    $shop = $this->shop->find($this->shopId);
                    if (!$shop->wholesale) {
                        $noAccountUser = $request->session()->get('noAccountUser');
                    }
                    return \view('frontend.cart.complete')->with(array('body' => $body));
                }
            } else {
                return redirect()->to('cart/checkout');
            }
        }
    }

    public function getPayment(Request $request)
    {

        $orderData = $request->session()->get('orderData');

        if ($orderData) {
            $paymentMethodId = $orderData->OrderPaymentMethod->payment_method_id;
            $sendingMethodId = $orderData->OrderSendingMethod->sending_method_id;

            $mollie = new Mollie_API_Client;

            if ($orderData->OrderPaymentMethod->paymentMethod->mollie_api_key) {
                $mollie->setApiKey($orderData->OrderPaymentMethod->paymentMethod->mollie_api_key);
            } else {
                $mollie->setApiKey("test_CSieArLBZJS4mkjse7KJGthYSzCspR");
            }

            /*
             * Determine the url parts to these example files.
             */
            $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
            $hostname = $_SERVER['HTTP_HOST'];
            $path     = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);
            if (!empty($orderData->OrderPaymentMethod->paymentMethod->mollie_external_payment_way)) {
                $constant = constant("Mollie_API_Object_Method::".strtoupper($orderData->OrderPaymentMethod->paymentMethod->mollie_external_payment_way));
            } else {
                Notification::container('foundation')->error('Neem contact op met ons. Betaalmethode is niet goed geconfigureerd. Onze excuses');
                return redirect()->to('cart/checkout');
            }

            $toPay = $orderData->price_with_tax;

            if ($toPay <= 0.35) {
                $orderTemplate = $this->sendingPaymentMethodRelated->selectOneByShopIdAndPaymentMethodIdAndSendingMethodId($this->shopId, $paymentMethodId, $sendingMethodId);

                if ($orderTemplate and $orderTemplate->payment_confirmed_text) {
                    $body = $this->replaceTags($orderTemplate->payment_confirmed_text, $orderData);
                } else {
                    $body = 'payment_confirmed_text not set';
                }
                $this->cart->destroyInstance($this->cart);
                $request->session()->flush('noAccountUser');
                return \view('frontend.cart.complete')->with(array('body' => $body));
            }

            $payment = $mollie->payments->create(array(
            "amount"       => str_replace(',', '', $orderData->price_with_tax),
            "method"       => $constant,
            "description"  => "Betaling van order ".$orderData->generated_custom_order_id,
            "redirectUrl"  => "{$protocol}://{$hostname}/cart/return-payment/{$orderData->id}",
            "webhookUrl"   => "{$protocol}://{$hostname}/cart/callback/{$orderData->id}",
            'billingEmail' => $orderData->client->email,
            "metadata"     => array(
                "order_id" => $orderData->generated_custom_order_id,
                ),
            "issuer"       => !empty($_POST["issuer"]) ? $_POST["issuer"] : null,
            "locale"       => "nl"
            ));
        
            if (isset($payment->id)) {
                $this->order->updateMolliePaymentId($orderData->id, $payment->id);
                $request->session()->put('paymentId', $payment->id);
            } else {
                Notification::container('foundation')->error('Neem contact op met ons. Betaalmethode is niet goed geconfigureerd. Onze excuses');
                return redirect()->to('cart/checkout');
            }

            return redirect()->to($payment->getPaymentUrl());
        } else {
            return redirect()->to('cart/checkout');
        }
    }

    public function postPaymentExternalCallback(Request $request, $orderId)
    {
        $paymentId = $request->get('id');

        $order = $this->order->find($orderId);

        if ($order) {
            $paymentId = $request->get('id');

            $mollie = new Mollie_API_Client;
            if ($order->OrderPaymentMethod->paymentMethod->mollie_api_key) {
                $mollie->setApiKey($order->OrderPaymentMethod->paymentMethod->mollie_api_key);
            } else {
                $mollie->setApiKey("test_CSieArLBZJS4mkjse7KJGthYSzCspR");
            }

            $payment = $mollie->payments->get($paymentId);
            
            $dataLog = array(
                'orderId' => $order->id,
                'type' => 'mollie',
                'log' =>  serialize(
                    array(
                        'id' => $payment->id,
                        'status' => $payment->status,
                        'amount' => $payment->amount,
                        'description' => $payment->description,
                        'paid_datetime' => $payment->paidDatetime
                    )
                )
            );

            $this->orderPaymentLog->createByUser($dataLog, $order->id);


            if ($payment->isPaid()) {
                if ($order->OrderPaymentMethod->paymentMethod->payment_completed_order_status_id) {
                    $orderStatus = $this->order->updateStatus($order->id, $order->OrderPaymentMethod->paymentMethod->payment_completed_order_status_id);
                    if ($order->OrderPaymentMethod->paymentMethod->payment_completed_order_status_id) {
                        Event::fire(new OrderChangeStatus($orderStatus));
                    }
                }
            } else {
                if ($order->OrderPaymentMethod->paymentMethod->payment_failed_order_status_id) {
                    $orderStatus = $this->order->updateStatus($order->id, $order->OrderPaymentMethod->paymentMethod->payment_failed_order_status_id);
                    if ($order->OrderPaymentMethod->paymentMethod->payment_failed_order_status_id) {
                        Event::fire(new OrderChangeStatus($orderStatus));
                    }
                }
            }


            return response()->make('OK', 200);
        }

         return response()->make('FALSE', 200);
    }


    public function getReturnPayment(Request $request, $orderId)
    {

        $orderData = $request->session()->get('orderData');

        if ($orderData and $orderData->id == $orderId) {
            $paymentId = $request->session()->get('paymentId');

            $mollie = new Mollie_API_Client;
            if ($orderData->OrderPaymentMethod->paymentMethod->mollie_api_key) {
                $mollie->setApiKey($orderData->OrderPaymentMethod->paymentMethod->mollie_api_key);
            } else {
                $mollie->setApiKey("test_CSieArLBZJS4mkjse7KJGthYSzCspR");
            }


            $payment = $mollie->payments->get($paymentId);
            
            $dataLog = array(
                'orderId' => $orderData['id'],
                'type' => 'mollie',
                'log' =>  serialize(
                    array(
                        'id' => $payment->id,
                        'status' => $payment->status,
                        'amount' => $payment->amount,
                        'description' => $payment->description,
                        'paid_datetime' => $payment->paidDatetime
                    )
                )
            );

            $this->orderPaymentLog->createByUser($dataLog, $orderData['id']);

            if ($payment->isPaid() OR $payment->isOpen()) {
                $productsDataLayer = array();
                if ($orderData->products()) {
                    foreach ($orderData->products as $product) {
                        if ($product->product_id) {
                            $productsDataLayer[] = array(
                                'id' => $product->id,
                                'name' => $product->title,
                                'category' => $product->product->productCategory->title,
                                'price' => $product->getOriginalTotalPriceWithTaxNumberFormat(),
                                'quantity' => $product->amount
                             );
                        }
                    }
                }

                GoogleTagManager::set(array(
                    'event' => 'paymentConfirmed',
                    'ecommerce' => [
                        'purchase' => [
                            'actionField' => [
                                'id' => $orderData->generated_custom_order_id,
                                'revenue' => $orderData->getPriceWithTaxNumberFormat(),
                                'tax' => $orderData->taxTotal()
                            ],
                            'products' => $productsDataLayer
                        ]
                    ]
                ));

                if (isset($payment->status) and ($payment->status == 'paid' OR $payment->status == 'open')) {
                    $this->cart->destroyInstance($this->cart);
                    $request->session()->flush('noAccountUser');
                    $paymentMethodId = $orderData->OrderPaymentMethod->payment_method_id;
                    $sendingMethodId = $orderData->OrderSendingMethod->sending_method_id;
                    $orderTemplate = $this->sendingPaymentMethodRelated->selectOneByShopIdAndPaymentMethodIdAndSendingMethodId($this->shopId, $paymentMethodId, $sendingMethodId);
                    
                    if ($orderTemplate and $orderTemplate->payment_confirmed_text) {
                        $body = $this->replaceTags($orderTemplate->payment_confirmed_text, $orderData);
                    } else {
                        $body = 'payment_confirmed_text not set';
                    }
                    return \view('frontend.cart.complete')->with(array('body' => $body));
                } else {
                    Notification::container('foundation')->error('De betaling is niet gelukt. Probeer het nogmaals.');
                    return redirect()->to('cart/checkout');
                }
            } else {
                Notification::container('foundation')->error('De betaling is niet gelukt. Probeer het nogmaals.');
                return redirect()->to('cart/checkout');
            }
        } else {
            Notification::container('foundation')->error('De betaling is niet gelukt. Probeer het nogmaals.');
            return redirect()->to('cart/checkout');
        }
    }

    public function replaceTags($content, $order)
    {
        $replace = array(
            'orderId' => $order->generated_custom_order_id,
            'orderCreated' => $order->created_at,
            'orderTotalPriceWithTax' => $order->getPriceWithTaxNumberFormat(),
            'orderTotalPriceWithoutTax' => $order->getPriceWithoutTaxNumberFormat(),
            'clientEmail' => $order->client->email,
            'clientFirstname' => $order->orderBillAddress->firstname,
            'clientLastname' => $order->orderBillAddress->lastname,
            'clientCompany' => $order->orderBillAddress->company,
            'clientDeliveryFirstname' => $order->orderDeliveryAddress->firstname,
            'clientDeliveryLastname' => $order->orderDeliveryAddress->lastname,
            'clientDeliveryStreet' => $order->orderDeliveryAddress->street,
            'clientDeliveryHousenumber' => $order->orderDeliveryAddress->housenumber,
            'clientDeliveryHousenumberSuffix' => $order->orderDeliveryAddress->housenumber_suffix,
            'clientDeliveryZipcode' => $order->orderDeliveryAddress->zipcode,
            'clientDeliveryCity' => $order->orderDeliveryAddress->city,
            'clientDeliveryCountry' => $order->orderDeliveryAddress->country,
            'clientDeliveryCompany' => $order->orderDeliveryAddress->company
        );

        foreach ($replace as $key => $val) {
            $content = str_replace("[" . $key . "]", $val, $content);
        }
        $content = nl2br($content);
        return $content;
    }

    public function getPresent()
    {
        $user = Auth::guard('web')->user();

        $summary = $this->cart->summary();

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
            $paymentMethodsList = $summary->paymentMethods();
        }

        return view('frontend.cart.present')->with(array('totals' => $totals));
    }

    public function postPresent(Request $request)
    {
        $this->cart->addPresent($request->all());
        return redirect()->to('/winkelwagen')
        ->withErrors(true, 'login')->withInput();
    }

    public function getDeletePresent()
    {
        $this->cart->deletePresent();
            return response()->json(true);
    }

    public function getTotalReload()
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId($this->shopId);
        if ($sendingMethodsList->first()) {
            $paymentMethodsList = $sendingMethodsList->first()->relatedPaymentMethods;
        } else {
            $paymentMethodsList = $this->paymentMethod->selectAllActiveByShopId($this->shopId);
        }

        $summary = $this->cart->summary();

        $products = "";
        $totals = "";

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
            $paymentMethodsList = $summary->paymentMethods();
        }

        $user = Auth::guard('web')->user();

        return view('frontend.cart._totals')->with(array('user' => $user, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList, 'sending_method' => $summary->sendingMethod(), 'products' => $products,  'totals' => $totals));
    }

    public function getTotalReloadMobile()
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId($this->shopId);
        if ($sendingMethodsList->first()) {
            $paymentMethodsList = $sendingMethodsList->first()->relatedPaymentMethods;
        } else {
            $paymentMethodsList = $this->paymentMethod->selectAllActiveByShopId($this->shopId);
        }

        $summary = $this->cart->summary();

        $products = "";
        $totals = "";

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
            $paymentMethodsList = $summary->paymentMethods();
        }

        $user = Auth::guard('web')->user();

        return view('frontend.cart._totals-mobile')->with(array('user' => $user, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList, 'sending_method' => $summary->sendingMethod(), 'products' => $products,  'totals' => $totals));
    }

    public function getDialog()
    {
        $summary = $this->cart->summary();
        $products = "";
        $configurators = "";
        $totals = "";

        if ($summary) {
            $totals = $summary->totals();
            $products = $summary->products();
        }

        return view('frontend.cart.dialog')->with(array('products' => $products,  'totals' => $totals));
    }

    public function postProduct(Request $request, $productId, $productCombinationId = false)
    {
        $product = $this->product->selectOneByShopIdAndId($this->shopId, $productId, $productCombinationId);

        $productCombination = false;
        if ($productCombinationId) {
            $productCombination = ProductAttribute::where('id', '=', $productCombinationId)->first();
        } elseif ($product->attributes()->count()) {
            return response()->json(false);
        }

        if ($product->id) {
            $productArray = $product->toArray();
            $productArray['product_amount_series'] = false;
            $productArray['product_category_slug'] = $product->productCategory->slug;
            $productArray['price_details'] = $product->getPriceDetails();
            if ($request->get('product_amount_series')) {
                $productArray['product_amount_series'] = true;
                $productArray['product_amount_series_range'] = $product->amountSeries()->where('active', '=', '1')->first()->range();
            }
            if ($productCombination) {
                $productArray['product_combination_title'] = array();
                foreach ($productCombination->combinations as $combination) {
                    $productArray['product_combination_title'][$combination->attribute->attributeGroup->title] = $combination->attribute->value;
                }

                $productArray['product_combination_id'] = $productCombination->id;
                if ($productCombination->price) {
                    $productArray['price_details'] = $productCombination->getPriceDetails();
                }

                if ($productCombination->reference_code) {
                    $productArray['reference_code'] = $productCombination->reference_code;
                }
            }

            $result = $this->cart->add($productArray, $request->get('amount'));
            $summary = $this->cart->summary();
            $result['summary'] = $summary->totals();
        }


        return response()->json($result);
    }

    public function deleteProduct($productId)
    {
        $explode = explode('-', $productId);

        $product = $this->product->selectOneByShopIdAndId($this->shopId, $explode[0]);



        if (isset($explode[1])) {
            $productAttributeId = $explode[1];
            $productCombination = ProductAttribute::where('id', '=', $productAttributeId)->first();

            if ($productCombination) {
                $result = $this->cart->removeProductAttribute($product, $productCombination->id);
            }
        } elseif ($product->id) {
            $result = $this->cart->remove($product);
        }
        
        $summary = $this->cart->summary();

        if (!$this->cart->products()) {
            $this->cart->destroyInstance($this->cart);
        }

        if ($summary) {
            return response()->json(array('productTags' => array('id' => $product->id, 'name' => $product->title), 'result' => $result, 'totals' => $summary->totals(), 'producttotal' => count($this->cart->products())));
        } else {
            return response()->json(array('productTags' => array('id' => $product->id, 'name' => $product->title), 'result' => $result, 'totals' => false, 'producttotal' => 0));
        }
    }

    public function updateAmountProduct($productId, $amount)
    {
        $explode = explode('-', $productId);

        $product = $this->product->selectOneByShopIdAndId($this->shopId, $explode[0]);

        $productCombination = false;
        if (isset($explode[1])) {
            $productAttributeId = $explode[1];
            $productCombination = ProductAttribute::where('id', '=', $productAttributeId)->first();
        }

        if ($product->id) {
            $productArray = $product->toArray();
            $productArray['product_amount_series'] = false;
            $productArray['product_category_slug'] = $product->productCategory->slug;
            $productArray['price_details'] = $product->getPriceDetails();

            if ($productCombination) {
                $productArray['id'] = $productArray['id'].'-'.$productCombination->id;
                $productArray['product_id'] = $product->id;
                $productArray['amount'] = $productCombination->amount;
                $productArray['product_combination_title'] = array();
                foreach ($productCombination->combinations as $combination) {
                    $productArray['product_combination_title'][$combination->attribute->attributeGroup->title] = $combination->attribute->value;
                }


                $productArray['product_combination_id'] = $productCombination->id;
      

                if ($productCombination->price) {
                    $productArray['price_details'] = $productCombination->getPriceDetails();
                }


                if ($productCombination->reference_code) {
                    $productArray['reference_code'] = $productCombination->reference_code;
                }
            }

            if ($product->amountSeries()->where('active', '=', '1')->count()) {
                $productArray['product_amount_series'] = true;
                $productArray['product_amount_series_range'] = $product->amountSeries()->where('active', '=', '1')->first()->range();
            }

            $this->cart->updateAmount($productArray, $amount);
        }

        $summary = $this->cart->summary();
        if ($summary) {
            $amountNa = view('frontend.cart.amount-na')->with(array('totals' => $summary->totals(), 'product' => $productArray))->render();
            return response()->json(array('amountNa' => $amountNa, 'productTags' => array('id' => $product->id, 'name' => $product->title), 'product' => $summary->getProduct($productId), 'totals' => $summary->totals()));
        } else {
            return response()->json(array('product' =>false, 'totals' => false));
        }
    }

    public function updateSendingMethod($sendingMethodId)
    {
        $sendingMethod = $this->sendingMethod->selectOneByShopIdAndId($this->shopId, $sendingMethodId);
        $sendingMethodArray = array();
        if (isset($sendingMethod->id)) {
            $sendingMethodArray = $sendingMethod->toArray();
            $sendingMethodArray['price_details'] = $sendingMethod->getPriceDetails();
            $sendingMethodArray['wholesale'] = $sendingMethod->shop->wholesale;
            $sendingMethodArray['related_payment_methods_list'] = $sendingMethod->relatedPaymentMethods->lists('title', 'id');
        }

        $this->cart->updateSendingMethod($sendingMethodArray);
        $summary = $this->cart->summary();

        if (empty($summary->totals()['payment_method']) and $sendingMethod->relatedPaymentMethods->first()->id) {
            self::updatePaymentMethod($sendingMethod->relatedPaymentMethods->first()->id);
        }


        return response()->json(array('sending_method' => $summary->sendingMethod(), 'totals' => $summary->totals()));
    }

    public function updatePaymentMethod($paymentMethodId)
    {
        $paymentMethod = $this->paymentMethod->selectOneByShopIdAndId($this->shopId, $paymentMethodId);

        $paymentMethodArray = array();
        if (isset($paymentMethod->id)) {
            $paymentMethodArray = $paymentMethod->toArray();
            $paymentMethodArray['price_details'] = $paymentMethod->getPriceDetails();
            $paymentMethodArray['wholesale'] = $paymentMethod->shop->wholesale;
        }

        $this->cart->updatePaymentMethod($paymentMethodArray);
        $summary = $this->cart->summary();

        return response()->json(array('payment_method' => $summary->paymentMethod(), 'totals' => $summary->totals()));
    }


    public function updateCouponCode($couponCode)
    {
        $request->session()->forget('orderData');

        $coupon = $this->coupon->selectOneByShopIdAndCode($this->shopId, $couponCode);

        $result = $this->cart->setCoupon($coupon, $couponCode);

        $summary = $this->cart->summary();
        return response()->json(true);
        // $totalContent =  \view('frontend.cart._totals')->with(array('totals' => $summary->totals(), 'products' => $summary->products()))->render();
        // if ($summary) {
        //     return response()->json(array('total_content' => $totalContent, 'totals' => $summary->totals(), 'products' => $summary->products()));
        // } else {
        //     return response()->json(array('product' =>false, 'totals' => false));
        // }
    }

    public function getEditAddress($type)
    {
        $summary = $this->cart->summary();
        if (Auth::guard('web')->guest()) {
            $noAccountUser = $request->session()->get('noAccountUser');
            if ($noAccountUser) {
                if ($type == 'delivery') {
                    $address = $noAccountUser['delivery'];
                } else {
                    $address = $noAccountUser;
                }

                return view('frontend.cart.edit-address-no-account')->with(array('type' => $type, 'noAccountUser' =>  $noAccountUser, 'totals' => $summary->totals(), 'products' => $summary->products(), 'clientAddress' => $address));
            }
        } else {
            $user = Auth::guard('web')->user();
            return view('frontend.cart.edit-address')->with(array('type' => $type, 'user' => $user,  'totals' => $summary->totals(), 'products' => $summary->products()));
        }
    }

    public function postEditAddress(Request $request, $type)
    {

        $userdata = $request->all();

        // create the validation rules ------------------------
        $rules = array(
            'firstname'     => 'required',
            'lastname'      => 'required',
            'zipcode'       => 'required|max:8',
            'housenumber'   => 'required',
            'housenumber_suffix'   => 'max:4',
            'street'        => 'required',
            'city'          => 'required',
            'country'       => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // get the error messages from the validator
            foreach ($validator->errors()->all() as $error) {
                Notification::container('foundation')->error($error);
            }

            // redirect our user back to the form with the errors from the validator
            return redirect()->to('cart/edit-address/'.$type)
            ->with(array('type' => $type))->withInput();
        } else {
            if (Auth::guard('web')->guest()) {
                $noAccountUser = $request->session()->get('noAccountUser');
                if ($noAccountUser) {
                    if ($type == 'bill') {
                        $noAccountUser = array_merge($noAccountUser, $request->all());
                    } elseif ($type == 'delivery') {
                        $noAccountUser['delivery'] = array_merge($noAccountUser['delivery'], $request->all());
                    }

                    $request->session()->put('noAccountUser', $noAccountUser);
                }
            } else {
                $user = Auth::guard('web')->user();

                if ($type == 'bill') {
                    $id = $user->clientBillAddress->id;

                    if ($user->clientDeliveryAddress->id == $user->clientBillAddress->id) {
                        $clientAddress = $this->clientAddress->createByClient($userdata, $user->id);
                        $this->client->setBillOrDeliveryAddress($this->shopId, $user->id, $clientAddress->id, $type);
                    } else {
                        $clientAddress = $this->client->editAddress($this->shopId, $user->id, $id, $userdata);
                    }
                } elseif ($type == 'delivery') {
                    $id = $user->clientDeliveryAddress->id;

                    if ($user->clientDeliveryAddress->id == $user->clientBillAddress->id) {
                        $clientAddress = $this->clientAddress->createByClient($userdata, $user->id);
                        $this->client->setBillOrDeliveryAddress($this->shopId, $user->id, $clientAddress->id, $type);
                    } else {
                        $clientAddress = $this->client->editAddress($this->shopId, $user->id, $id, $userdata);
                    }
                }
            }

            return redirect()->to('cart/checkout');
        }
    }
}
