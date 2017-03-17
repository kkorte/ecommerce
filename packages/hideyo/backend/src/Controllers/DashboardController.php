<?php namespace Hideyo\Backend\Controllers;

use App\Http\Controllers\Controller;
use Dutchbridge\Datatable\OrderDatatable;
use Dutchbridge\Datatable\OrderWholesaleDatatable;
use Hideyo\Backend\Repositories\OrderRepositoryInterface;
use Hideyo\Backend\Repositories\ShopRepositoryInterface;
use Hideyo\Backend\Repositories\UserRepositoryInterface;

use Request;
use Auth;
use Notification;
use Lava;
use Carbon\Carbon;

class DashboardController extends Controller
{


    public function __construct(
        OrderRepositoryInterface $order,
        ShopRepositoryInterface $shop,
        UserRepositoryInterface $user
    ) {
        $this->order = $order;
        $this->shop = $shop;
        $this->user = $user;
    }

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */


    public function index()
    {
        $shop  = \Auth::guard('admin')->user()->shop;
        $now = Carbon::now();

        $revenueThisMonth = $this->order->monthlyRevenue($now->year, $now->month);

        if ($shop->wholesale) {
            if (Request::wantsJson()) {

                $order = $this->order->getModel()->select(
                    [
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'order.id',
                    'order.created_at',
                    'order.generated_custom_order_id',
                    'order.order_status_id',
                    'order.client_id',
                    'order.delivery_order_address_id',
                    'order.bill_order_address_id',
                    'order.price_with_tax']
                )->with(array('orderStatus', 'orderPaymentMethod', 'orderSendingMethod', 'products', 'client', 'orderBillAddress', 'orderDeliveryAddress'))->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)



                ->leftJoin('order_address', 'order.bill_order_address_id', '=', 'order_address.id');
                
                
                $datatables = \Datatables::of($order)

                ->addColumn('created_at', function ($order) {
                    return date('d F H:i', strtotime($order->created_at));
                })

                ->addColumn('status', function ($order) {
                    if ($order->orderStatus) {
                        if ($order->orderStatus->color) {
                            return '<span style="background-color:'.$order->orderStatus->color.'; padding: 10px; line-height:30px; text-align:center; color:white;">'.$order->orderStatus->title.'</span>';
                        }
                        return $order->orderStatus->title;
                    }
                })

                ->addColumn('company', function ($order) {
                    if ($order->client) {
                        return $order->client->company;
                    }
                })

                ->filterColumn('company', function ($query, $keyword) {

                    $query->where(
                        function ($query) use ($keyword) {
                            $query->whereRaw("order_address.company like ?", ["%{$keyword}%"]);
                            ;
                        }
                    );
                })

                ->filterColumn('client', function ($query, $keyword) {

                    $query->where(
                        function ($query) use ($keyword) {
                            $query->whereRaw("order_address.firstname like ?", ["%{$keyword}%"]);
                            $query->orWhereRaw("order_address.lastname like ?", ["%{$keyword}%"]);
                            ;
                        }
                    );
                })
                ->addColumn('client', function ($order) {
                    if ($order->client) {
                        if ($order->orderBillAddress) {
                            return '<a href="/admin/client/'.$order->client_id.'/order">'.$order->orderBillAddress->firstname.' '.$order->orderBillAddress->lastname.' ('.$order->client->orders->count() .')</a>';
                        }
                    }
                })
                ->addColumn('products', function ($order) {
                    if ($order->products) {
                        return $order->products->count();
                    }
                })
                ->addColumn('price_with_tax', function ($order) {
                    $money = '&euro; '.$order->getPriceWithTaxNumberFormat();
                    return $money;
                })


                ->addColumn('paymentMethod', function ($order) {
                    if ($order->orderPaymentMethod) {
                        return $order->orderPaymentMethod->title;
                    }
                })
                ->addColumn('sendingMethod', function ($order) {
                    if ($order->orderSendingMethod) {
                        return $order->orderSendingMethod->title;
                    }
                })
                ->addColumn('action', function ($order) {
                    $delete = \Form::deleteajax('/admin/order/'. $order->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                    $download = '<a href="/admin/order/'.$order->id.'/download" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>Download</a>  ';
                    $label = "";
                    if($order->orderLabel()->count()) {
                        $label = '<a href="/admin/order/'.$order->id.'/download-label" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>Label</a>  ';
                    }      
             
                    $link = '<a href="/admin/order/'.$order->id.'" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Show</a>  '.$download.' '.$label;
                




                    return $link;
                });

                return $datatables->make(true);

            } else {
                return view('admin.dashboard.index-wholesale')->with(array('revenueThisMonth' => $revenueThisMonth, 'order' => $this->order->selectAll()));
            }
        } else {
            if (Request::wantsJson()) {


                $order = $this->order->getModel()->select(
                    [
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'order.id',
                    'order.created_at',
                    'order.generated_custom_order_id',
                    'order.order_status_id',
                    'order.client_id',
                    'order.delivery_order_address_id',
                    'order.bill_order_address_id',
                    'order.price_with_tax']
                )->with(array('orderStatus', 'orderPaymentMethod', 'orderSendingMethod', 'products', 'client', 'orderBillAddress', 'orderDeliveryAddress'))->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)



                ->leftJoin('order_address', 'order.bill_order_address_id', '=', 'order_address.id');
                
                
                $datatables = \Datatables::of($order)

                ->addColumn('generated_custom_order_id', function ($order) {
                    return $order->generated_custom_order_id;
                })

                ->addColumn('created_at', function ($order) {
                    return date('d F H:i', strtotime($order->created_at));
                })

                ->addColumn('status', function ($order) {
                    if ($order->orderStatus) {
                        if ($order->orderStatus->color) {
                            return '<a href="/admin/order/'.$order->id.'" style="text-decoration:none;"><span style="background-color:'.$order->orderStatus->color.'; padding: 10px; line-height:30px; text-align:center; color:white;">'.$order->orderStatus->title.'</span></a>';
                        }
                        return $order->orderStatus->title;
                    }
                })

                ->filterColumn('client', function ($query, $keyword) {

                    $query->where(
                        function ($query) use ($keyword) {
                            $query->whereRaw("order_address.firstname like ?", ["%{$keyword}%"]);
                            $query->orWhereRaw("order_address.lastname like ?", ["%{$keyword}%"]);
                            ;
                        }
                    );
                })



                ->addColumn('client', function ($order) {
                    if ($order->client) {
                        if ($order->orderBillAddress) {
                            return '<a href="/admin/client/'.$order->client_id.'/order">'.$order->orderBillAddress->firstname.' '.$order->orderBillAddress->lastname.' ('.$order->client->orders->count() .')</a>';
                        }
                    }
                })
                ->addColumn('products', function ($order) {
                    if ($order->products) {
                        return $order->products->count();
                    }
                })
                ->addColumn('price_with_tax', function ($order) {
                    $money = '&euro; '.$order->getPriceWithTaxNumberFormat();
                    return $money;
                })


                ->addColumn('paymentMethod', function ($order) {
                    if ($order->orderPaymentMethod) {
                        return $order->orderPaymentMethod->title;
                    }
                })
                ->addColumn('sendingMethod', function ($order) {
                    if ($order->orderSendingMethod) {
                        return $order->orderSendingMethod->title;
                    }
                })
                ->addColumn('action', function ($order) {
                    $delete = \Form::deleteajax('/admin/order/'. $order->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                    $download = '<a href="/admin/order/'.$order->id.'/download" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>Download</a>  ';
                
                    $label = "";
                    if($order->orderLabel()->count()) {
                        $label = '<a href="/admin/order/'.$order->id.'/download-label" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>Label</a>  ';
                    }      
             
                    
                    $link = '<a href="/admin/order/'.$order->id.'" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Show</a>  '.$download.' '.$label;
                
                    return $link;
                });

                return $datatables->make(true);



            } else {
                return view('admin.dashboard.index')->with(array('revenueThisMonth' => $revenueThisMonth, 'order' => $this->order->selectAll()));
            }
        }
    }

    public function showStats()
    {
        $revenueYears = $this->order->yearsRevenue();

        $revenueChartYears= "";
        if ($revenueYears) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Year')
                     ->addNumberColumn('total');

            foreach ($revenueYears as $year) {
     
                $finances->addRow([$year->year, $year->price_with_tax]);
            }
  
            $revenueChartYears = Lava::ColumnChart('Years', $finances, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }


        $monthlyRevenueYears = $this->order->monthlyRevenueYears();

        $monthlyRevenue = $this->order->monthlyRevenue($monthlyRevenueYears->last()->year);

        $isMobile = $this->order->browserDetectOrdersInformation($monthlyRevenueYears->last()->year);

        $revenueChartMobile = "";
        if ($isMobile) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Month')
                     ->addNumberColumn('Desktop')
                     ->addNumberColumn('Tablet')
                     ->addNumberColumn('Mobile');

            foreach ($isMobile as $month) {
                $finances->addRow([$month->dm, $month->desktop, $month->tablet, $month->mobile]);
            }
  
            $revenueChartMobile = Lava::ColumnChart('BrowserDetect', $finances, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }



        $revenueChart = "";
        if ($monthlyRevenue) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Month')
                     ->addNumberColumn('Euro\'s');
            foreach ($monthlyRevenue as $month) {
                $finances->addRow([$month->dm, $month->price_with_tax]);
            }
  
            $revenueChart = Lava::ColumnChart('Finances', $finances, [
                'vAxis' => ['format' => 'currency'],
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }



        $revenueAverageChart = "";
        if ($monthlyRevenue) {
            $financesAverage = Lava::DataTable();

            $financesAverage->addStringColumn('Month')
                     ->addNumberColumn('Euro\'s');
            foreach ($monthlyRevenue as $month) {
                $financesAverage->addRow([$month->dm, $month->price_with_tax / $month->total_orders]);
            }
  
            $revenueAverageChart = Lava::ColumnChart('FinancesAverage', $financesAverage, [
                'vAxis' => ['format' => 'currency'],
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }




        $revenueChartTotal = "";
        if ($monthlyRevenue) {
            $totals = Lava::DataTable();

            $totals->addStringColumn('Month')
            ->addNumberColumn('orders');
            foreach ($monthlyRevenue as $month) {
                $totals->addRow([$month->dm, $month->total_orders]);
            }
  
            $revenueChartTotal = Lava::ColumnChart('totalOrders', $totals, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }

        $revenueChartPaymentMethod = "";


        $paymentMethods = $this->order->paymentMethodOrdersInformation($monthlyRevenueYears->last()->year);


        if ($paymentMethods) {
            $finances = Lava::DataTable();
            $newRows = array();
            foreach ($paymentMethods as $paymentMethod) {
                $newRows[$paymentMethod->dm][$paymentMethod->paymenttitle] = $paymentMethod->count;

            }

            $finances->addStringColumn('Title')
                     ->addNumberColumn('total');

            foreach ($newRows as $month => $row) {

                foreach($row as $key => $count) {         
                    $finances->addRow([$key, $count]);
                }           
            }
  
            $revenueChartPaymentMethod = Lava::ColumnChart('PaymentMethodDetect', $finances, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.stats')->with(
            array(
                'selectedYears' => $monthlyRevenueYears->last(), 
                'years' => $monthlyRevenueYears, 
                'revenueChartYears' => $revenueChartYears,
                'revenueChartMobile' => $revenueChartMobile, 
                'revenueAverageChart' => $revenueAverageChart,
                'revenueChart' => $revenueChart,
                'revenueChartTotal' => $revenueChartTotal,
                'revenueChartPaymentMethod' => $revenueChartPaymentMethod
            )
        );
    }




    public function getStatsPaymentMethodByYear($year)
    {
        $monthlyRevenueYears = $this->order->monthlyRevenueYears();


        $paymentMethods = $this->order->paymentMethodOrdersInformation($year);


        if ($paymentMethods) {
            $finances = Lava::DataTable();
            $newRows = array();
            foreach ($paymentMethods as $paymentMethod) {
                $newRows[$paymentMethod->dm][$paymentMethod->paymenttitle] = $paymentMethod->count;

            }

            $finances->addStringColumn('Title')
                     ->addNumberColumn('total');

            foreach ($newRows as $month => $row) {

                foreach($row as $key => $count) {         
                    $finances->addRow([$key, $count]);
                }           
            }
  
            $revenueChartPaymentMethod = Lava::ColumnChart('PaymentMethodDetect', $finances, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.ajax-payment-method-by-year')->with(array('selectedYear' => $year, 'years' => $monthlyRevenueYears, 'revenueChartPaymentMethod' => $revenueChartPaymentMethod));
    }


    public function getStatsRevenueByYear($year)
    {
        $monthlyRevenueYears = $this->order->monthlyRevenueYears();

        $monthlyRevenue = $this->order->monthlyRevenue($year);

        $revenueChart = "";
        if ($monthlyRevenue) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Month')
                     ->addNumberColumn('Euro\'s');
            foreach ($monthlyRevenue as $month) {
                $finances->addRow([$month->dm, $month->price_with_tax]);
            }
  
            $revenueChart = Lava::ColumnChart('Finances', $finances, [
                'titleTextStyle' => [
                
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.ajax-revenue-by-year')->with(array('selectedYear' => $year, 'years' => $monthlyRevenueYears, 'revenueChart' => $revenueChart));
    }


    public function getStatsOrderAverageByYear($year)
    {
        $monthlyRevenueYears = $this->order->monthlyRevenueYears();

        $monthlyRevenue = $this->order->monthlyRevenue($year);

        $revenueChart = "";
        if ($monthlyRevenue) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Month')
                     ->addNumberColumn('Euro\'s');
            foreach ($monthlyRevenue as $month) {
                $finances->addRow([$month->dm, $month->price_with_tax / $month->total_orders]);
            }
  
            $revenueChart = Lava::ColumnChart('FinancesAverage', $finances, [
                'titleTextStyle' => [
                
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.ajax-order-average-by-year')->with(array('selectedYear' => $year, 'years' => $monthlyRevenueYears, 'revenueAverageChart' => $revenueChart));
    }




    public function getStatsTotalsByYear($year)
    {
        $monthlyRevenueYears = $this->order->monthlyRevenueYears();

        $monthlyRevenue = $this->order->monthlyRevenue($year);

        $revenueChartTotal = "";
        if ($monthlyRevenue) {
            $totals = Lava::DataTable();

            $totals->addStringColumn('Month')
                     ->addNumberColumn('orders');
            foreach ($monthlyRevenue as $month) {
                $totals->addRow([$month->dm, $month->total_orders]);
            }
  
            $revenueChartTotal = Lava::ColumnChart('totalOrders', $totals, [
               
                'titleTextStyle' => [
                   
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.ajax-total-by-year')->with(array('selectedYear' => $year, 'years' => $monthlyRevenueYears, 'revenueChart' => $revenueChartTotal));
    }



    public function getStatsBrowserByYear($year)
    {
        $monthlyRevenueYears = $this->order->monthlyRevenueYears();

        $isMobile = $this->order->browserDetectOrdersInformation($year);


        $revenueChart = "";
        if ($isMobile) {
            $finances = Lava::DataTable();

            $finances->addStringColumn('Month')
                     ->addNumberColumn('Desktop')
                     ->addNumberColumn('Tablet')
                     ->addNumberColumn('Mobile');
            foreach ($isMobile as $month) {
                $finances->addRow([$month->dm, $month->desktop, $month->tablet, $month->mobile]);
            }
  
            $revenueChart = Lava::ColumnChart('BrowserDetect', $finances, [
                'titleTextStyle' => [
                
                    'fontSize' => 14
                ]
            ]);
        }

        return view('admin.dashboard.ajax-browser-by-year')->with(array('selectedYear' => $year, 'years' => $monthlyRevenueYears, 'revenueChart' => $revenueChart));
    }






    public function getShowOrder($orderId)
    {
        $order = $this->order->find($orderId);

        if (Auth::user()) {
            $id = Auth::id();
        }

        $shop = $this->shop->find($order->shop_id);

        $result  = $this->user->updateShopProfileById($shop, $id);
        Notification::success('The shop changed.');
        return \Redirect::route('order.show', array('id' => $orderId));
    }
}
