<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * ClientController
 *
 * This is the controller for the shop clients
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */


use Dutchbridge\Repositories\ClientRepositoryInterface;
use Dutchbridge\Repositories\ClientAddressRepositoryInterface;

use Illuminate\Http\Request;
use Notification;
use Mail;
use Excel;

class ClientController extends Controller
{
    public function __construct(Request $request, ClientRepositoryInterface $client, ClientAddressRepositoryInterface $clientAddress)
    {
        $this->client = $client;
        $this->clientAddress = $clientAddress;
        $this->request = $request;
    }

    public function index()
    {
        $shop  = \Auth::guard('admin')->user()->shop;

        if ($shop->wholesale) {

            if ($this->request->wantsJson()) {

                $shop  = \Auth::guard('admin')->user()->shop();
                $clients = $this->client->getModel()->select(
                    [
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'id', 'company', 'bill_client_address_id', 'vat_number', 'debtor_number', 'active', 'confirmed', 'iban_number', 'chamber_of_commerce_number',
                    'email', 'last_login']
                )->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
                
                $datatables = \Datatables::of($clients)

                ->addColumn('last_login', function ($clients) {
                    return date('d F H:i', strtotime($clients->last_login));
                })


                ->addColumn('company', function ($clients) {

                    if ($clients->clientBillAddress and $clients->clientBillAddress->company) {
                        return $clients->clientBillAddress->company;
                    } else {
                        return $clients->company;
                    }
                })


                ->addColumn('chamber_of_commerce_number', function ($clients) {
                    return '<a href="https://www.kvk.nl/orderstraat/bedrijf-kiezen/?q='.$clients->chamber_of_commerce_number.'" target="_blank">'.$clients->chamber_of_commerce_number.'</a>';
                })


                ->addColumn('action', function ($clients) {
                    $delete = \Form::deleteajax('/admin/client/'. $clients->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                    $link = '<a href="/admin/client/'.$clients->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Show</a>  '.$delete;
                    if (!$clients->active || !$clients->confirmed) {
                        $link .= ' <a href="/admin/client/'.$clients->id.'/activate" class="btn btn-default btn-sm btn-info">activate</a>';
                    } else {
                        $link .= ' <a href="/admin/client/'.$clients->id.'/de-activate" class="btn btn-default btn-sm btn-info">block</a>';
                    }

                    return $link;
                });

                return $datatables->make(true);




            } else {
                return view('admin.client.index-wholesale')->with('client', $this->client->selectAll());
            }
        } else {


            if ($this->request->wantsJson()) {
                $shop  = \Auth::guard('admin')->user()->shop();
                $clients = $this->client->getModel()->select(
                    [
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'id', 'confirmed', 'active',
                    'email', 'last_login']
                )->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
                
                $datatables = \Datatables::of($clients)


                ->addColumn('last_login', function ($clients) {
                    return date('d F H:i', strtotime($clients->last_login));
                })

                ->addColumn('action', function ($clients) {
                    $delete = \Form::deleteajax('/admin/client/'. $clients->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                    $link = '<a href="/admin/client/'.$clients->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Show</a>  '.$delete;
                
                    if (!$clients->active || !$clients->confirmed) {
                        $link .= ' <a href="/admin/client/'.$clients->id.'/activate" class="btn btn-default btn-sm btn-info">activate</a>';
                    } else {
                        $link .= ' <a href="/admin/client/'.$clients->id.'/de-activate" class="btn btn-default btn-sm btn-info">block</a>';
                    }

                    return $link;
                });

                return $datatables->make(true);


            } else {
                return view('admin.client.index')->with('client', $this->client->selectAll());
            }
        }
    }

    public function create()
    {
        return view('admin.client.create')->with(array());
    }

    public function getActivate($id)
    {

        return view('admin.client.activate')->with(array('client' => $this->client->find($id), 'addresses' => $this->clientAddress->selectAllByClientId($id)->lists('firstname', 'id')));
    }

    public function getDeActivate($id)
    {

        return view('admin.client.de-activate')->with(array('client' => $this->client->find($id), 'addresses' => $this->clientAddress->selectAllByClientId($id)->lists('firstname', 'id')));
    }


    public function postActivate($id)
    {
        $input = $this->request->all();

        $result  = $this->client->activate($id);


        $shop  = \Auth::guard('admin')->user()->shop;

        if ($shop->wholesale and $result) {
            if ($input['send_mail']) {
                    Mail::send('frontend.email.activate-mail-wholesale', array('user' => $result->toArray(), 'billAddress' => $result->clientBillAddress->toArray()), function ($message) use ($result) {
                        $message->to($result['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Toegang tot groothandel.');
                    });

                    Notification::container('foundation')->success('U heeft zich geregistreerd voor de groothandels bestel website van Foodelicious. U aanvraag zal zo snel mogelijk bekeken worden en na goedkeuring ontvangt u daarover een email.');
            }
        } else {
            if ($input['send_mail']) {
                    Mail::send('frontend.email.activate-mail', array('user' => $result->toArray(), 'billAddress' => $result->clientBillAddress->toArray()), function ($message) use ($result) {
                        $message->to($result['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Toegang tot groothandel.');
                    });

                    Notification::container('foundation')->success('Uw account is geactiveerd.');
            }
        }

        \Notification::success('The client was activate.');
        return redirect()->route('admin.client.index');
    }


    public function postDeActivate($id)
    {
        $result  = $this->client->deactivate($id);
        \Notification::success('The client was deactivate.');
        return redirect()->route('admin.client.index');
    }

    public function store()
    {
        $result  = $this->client->create($this->request->all());
 

        if (isset($result->id)) {
            \Notification::success('The client was inserted.');
            return redirect()->route('admin.client.index');
        }
            
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $addresses = $this->clientAddress->selectAllByClientId($id);

        $addressesList = array();

        if ($addresses) {
            foreach ($addresses as $row) {
                $addressesList[$row->id] = $row->street.' '.$row->housenumber;
                if ($row->housenumber_suffix) {
                    $addressesList[$row->id] .= $row->housenumber_suffix;
                }

                $addressesList[$row->id] .= ', '.$row->city;
            }
        }

        return view('admin.client.edit')->with(array('client' => $this->client->find($id), 'addresses' => $addressesList));
    }

    public function getExport()
    {
        return view('admin.client.export')->with(array());
    }

    public function postExport()
    {

        $result  =  $this->client->selectAllExport();
        Excel::create('export', function ($excel) use ($result) {

            $excel->sheet('Clients', function ($sheet) use ($result) {
                $newArray = array();
                foreach ($result as $row) {
                    $firstname = null;
                    if($row->clientBillAddress) {
                        $firstname = $row->clientBillAddress->firstname;
                    }

                    $lastname = null;
                    if($row->clientBillAddress) {
                        $lastname = $row->clientBillAddress->lastname;
                    }

                    $gender = null;
                    if($row->clientBillAddress) {
                        $gender = $row->clientBillAddress->gender;
                    }


                    $newArray[$row->id] = array(
                    'email' => $row->email,
                    'company' => $row->company,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'gender' => $gender


                    );


           
                }

                $sheet->fromArray($newArray);
            });
        })->download('xls');


        \Notification::success('The product export is completed.');
        return redirect()->route('admin.product.index');
    }



    public function update($id)
    {
        $result  = $this->client->updateById($this->request->all(), $id);
        $input = $this->request->all();
        if (isset($result->id)) {
            if ($result->active) {
                $shop  = \Auth::guard('admin')->user()->shop;

                if ($shop->wholesale and $result) {
                    if ($input['send_mail']) {
                        Mail::send('frontend.email.activate-mail-wholesale', array('user' => $result->toArray(), 'billAddress' => $result->clientBillAddress->toArray()), function ($message) use ($result) {
                            $message->to($result['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Toegang tot groothandel.');
                        });

                        Notification::container('foundation')->success('U heeft zich geregistreerd voor de groothandels bestel website van Foodelicious. U aanvraag zal zo snel mogelijk bekeken worden en na goedkeuring ontvangt u daarover een email.');
                    }
                } else {
                    if ($input['send_mail']) {
                        Mail::send('frontend.email.activate-mail', array('user' => $result->toArray(), 'billAddress' => $result->clientBillAddress->toArray()), function ($message) use ($result) {
                            $message->to($result['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Toegang tot groothandel.');
                        });

                        Notification::container('foundation')->success('Uw account is geactiveerd.');
                    }
                }
            }



            \Notification::success('The client was updated.');
            return redirect()->route('admin.client.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->client->destroy($id);

        if ($result) {
            Notification::success('The client was deleted.');
            return redirect()->route('admin.client.index');
        }
    }
}
