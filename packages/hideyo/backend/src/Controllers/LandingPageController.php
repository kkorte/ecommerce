<?php namespace App\Http\Controllers\Admin;

/**
 * CouponController
 *
 * This is the controller of the landingPages of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\LandingPageRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;

use \Request;
use \Notification;
use \Redirect;
use \Response;

class LandingPageController extends Controller
{
    public function __construct(
        LandingPageRepositoryInterface $landingPage,
        ProductRepositoryInterface $product
    ) {
        $this->landingPage = $landingPage;
        $this->product = $product;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = $this->landingPage->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'landing_page.id', 'landing_page.file', 'landing_page.active',
                'landing_page.title', 'landing_page.slug']
            )->where('landing_page.shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)


            ->addColumn('image', function ($query) {
                if ($query->file) {
                    return '<img src="/files/landing_page/100x100/'.$query->id.'/'.$query->file.'"  />';
                }
            })

            ->addColumn('active', function ($query) {
                if ($query->active) {
                    return '<a href="#" class="change-active" data-url="/admin/landing-page/change-active/'.$query->id.'"><span class="glyphicon glyphicon-ok icon-green"></span></a>';
                } else {
                    return '<a href="#" class="change-active" data-url="/admin/landing-page/change-active/'.$query->id.'"><span class="glyphicon glyphicon-remove icon-red"></span></a>';
                }
            })

            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/landing-page/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                
                $externalLink = '<a href="'.\Auth::guard('admin')->user()->shop->url.'/landing/' . $query->slug. '" target="_blank" class="btn btn-sm btn-info">link</a>';

                $link = $externalLink.'<a href="/admin/landing-page/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>'.$delete;
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('admin.landing-page.index')->with('landingPage', $this->landingPage->selectAll());
        }
    }

    public function create()
    {
        $products = $this->product->selectAll()->lists('title', 'id');
        return view('admin.landing-page.create')->with(array('products' => $products));
    }

    public function store()
    {
        $result  = $this->landingPage->create(\Request::all());

        if (isset($result->id)) {
            \Notification::success('The landing page was inserted.');
            return \Redirect::route('admin.landing-page.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
        return \Redirect::back()->withInput();
    }

    public function changeActive($landingPageId)
    {
        $result = $this->landingPage->changeActive($landingPageId);
        return Response::json($result);
    }

    public function edit($id)
    {
        $products = $this->product->selectAll()->lists('title', 'id');
        return view('admin.landing-page.edit')->with(array('products' => $products, 'landingPage' => $this->landingPage->find($id)));
    }


    public function reDirectoryAllImages()
    {
        $this->landingPage->reDirectoryAllImagesByShopId(\Auth::guard('admin')->user()->selected_shop_id);

        return \Redirect::route('admin.landing-page.index');
    }

    public function refactorAllImages()
    {
        $this->landingPage->refactorAllImagesByShopId(\Auth::guard('admin')->user()->selected_shop_id);

        return \Redirect::route('admin.landing-page.index');
    }

    public function editSeo($id)
    {
        return view('admin.landing-page.edit_seo')->with(array('landingPage' => $this->landingPage->find($id)));
    }

    public function update($landingPageId)
    {

        $result  = $this->landingPage->updateById(Request::all(), $landingPageId);

        if (isset($result->id)) {
            Notification::success('LandingPage was updated.');
            return Redirect::route('admin.landing-page.edit', $landingPageId);
        }

        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
        return Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->landingPage->destroy($id);

        if ($result) {
            Notification::success('The landing page was deleted.');
            return Redirect::route('admin.landing-page.index');
        }
    }
}
