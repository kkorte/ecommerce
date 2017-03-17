<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * ClientAddressController
 *
 * This is the controller for the shop clients images
 * @author Matthijs Neijenhuijs <matthijs@Dutchbridge.nl>
 * @version 1.0
 */

use Dutchbridge\Repositories\ClientAddressRepositoryInterface;
use Dutchbridge\Repositories\ClientRepositoryInterface;

use Illuminate\Http\Request;
use Notification;

class ClientAddressController extends Controller
{
    public function __construct(Request $request, ClientAddressRepositoryInterface $clientAddress, ClientRepositoryInterface $client)
    {
        $this->clientAddress = $clientAddress;
        $this->client = $client;
        $this->request = $request;
    }

    public function index($clientId)
    {
        $client = $this->client->find($clientId);
        if ($this->request->wantsJson()) {

            $addresses = $this->clientAddress->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'firstname',
                'street',
                'housenumber',
                'housenumber_suffix',
                'city',
                'lastname']
            )->with(array('clientDeliveryAddress', 'clientBillAddress'))->where('client_id', '=', $clientId);
            
            $datatables = \Datatables::of($addresses)
            ->addColumn('housenumber', function ($addresses) use ($clientId) {
                return $addresses->housenumber.$addresses->housenumber_suffix;
            })
            ->addColumn('delivery', function ($addresses) {
                if ($addresses->clientDeliveryAddress()->count()) {
                          return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                        return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })

            ->addColumn('bill', function ($addresses) {
                if ($addresses->clientBillAddress()->count()) {
                          return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                        return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })
            ->addColumn('action', function ($addresses) use ($clientId) {
                $delete = \Form::deleteajax('/admin/client/'.$clientId.'/addresses/'. $addresses->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/client/'.$clientId.'/addresses/'.$addresses->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);
        } else {
            return \View::make('admin.client_address.index')->with(array('client' => $client));
        }
    }

    public function create($clientId)
    {
        $client = $this->client->find($clientId);

        return \View::make('admin.client_address.create')->with(array('client' => $client));
    }

    public function store($clientId)
    {

        $result  = $this->clientAddress->create($this->request->all(), $clientId);
 
        if ($result->id) {
            Notification::success('The client address is inserted.');
            return redirect()->route('admin.client.{clientId}.addresses.index', $clientId);
        } else {
            Notification::error('field are required');
        }

        return redirect()->back()->withInput()->withErrors($result->errors()->all());
    }

    public function edit($clientId, $id)
    {
        $client = $this->client->find($clientId);
        return \View::make('admin.client_address.edit')->with(array('clientAddress' => $this->clientAddress->find($id), 'client' => $client));
    }

    public function update($clientId, $id)
    {

        $result  = $this->clientAddress->updateById($this->request->all(), $clientId, $id);

        if (!$result->id) {
            return redirect()->back()->withInput()->withErrors($result->errors()->all());
        } else {
            Notification::success('The client address is updated.');
            return redirect()->route('admin.client.{clientId}.addresses.index', $clientId);
        }
    }

    public function destroy($clientId, $id)
    {
        $result  = $this->clientAddress->destroy($id);

        if ($result) {
            Notification::success('The client address is deleted.');
            return redirect()->route('admin.client.{clientId}.addresses.index', $clientId);
        }
    }
}
