<?php namespace Hideyo\Backend\Controllers;

/**
 * CouponController
 *
 * This is the controller of the sending methods of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\RedirectRepositoryInterface;
use Dutchbridge\Repositories\ShopRepositoryInterface;

use \Session;
use \Apiclient;
use \Input;
use \Response;
use \View;
use \Request;
use Notification;
use Redirect;
use Excel;

class RedirectController extends Controller
{
    public function __construct(RedirectRepositoryInterface $redirect, ShopRepositoryInterface $shop)
    {
        $this->redirect = $redirect;
        $this->shop = $shop;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = $this->redirect->selectAll();
            $datatables = \Datatables::of($query)

            ->addColumn('url', function ($query) {

                return '<a href="'.$query->url.'" target="_blank">'.$query->url.'</a>';
            })

            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/redirect/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/redirect/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('admin.redirect.index')->with('redirect', $this->redirect->selectAll());
        }
    }

    public function create()
    {
        $shops = $this->shop->selectAll()->lists('title', 'id')->toArray();
        return view('admin.redirect.create')->with(array('shops' => $shops));
    }

    public function store()
    {
        $result  = $this->redirect->create(Request::all());
 

        if (isset($result->id)) {
            \Notification::success('The redirect was created.');
            return \Redirect::route('admin.redirect.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function edit($id)
    {
                $shops = $this->shop->selectAll()->lists('title', 'id');
        return view('admin.redirect.edit')->with(array(
            'redirect' => $this->redirect->find($id),
            'shops' => $shops
        ));
    }

    public function getImport()
    {
        return view('admin.redirect.import')->with(array());
    }

    public function postImport()
    {

        $file = Request::file('file');
        Excel::load($file, function ($reader) {

              $results = $reader->get();

            if ($results->count()) {
                $result = $this->redirect->importCsv($results, \Auth::guard('admin')->user()->selected_shop_id);

                \Notification::success('The redirects are imported.');
       
                return Redirect::route('admin.redirect.index');
            } else {
                \Notification::success('The redirects imported are failed.');
                return \Redirect::route('admin.redirect.import');
            }
        });
    }

    public function getExport()
    {
        $result  =  $this->redirect->selectAll()->get();

        Excel::create('redirects', function ($excel) use ($result) {

            $excel->sheet('Redirects', function ($sheet) use ($result) {
                $newArray = array();
                foreach ($result as $row) {
                    $newArray[$row->id] = array(
                        'active' => $row->active,
                        'url' => $row->url,
                        'redirect_url' => $row->redirect_url
                    );
                }

                $sheet->fromArray($newArray);
            });
        })->download('xls');
    }

    public function update($id)
    {
        $result  = $this->redirect->updateById(Request::all(), $id);

        if (isset($result->id)) {
            \Notification::success('The redirect was updated.');
            return \Redirect::route('admin.redirect.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->redirect->destroy($id);

        if ($result) {
            Notification::success('Redirect item is deleted.');
            return Redirect::route('admin.redirect.index');
        }
    }
}
