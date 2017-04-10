<?php namespace Hideyo\Backend\Controllers;

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\TaxRateRepositoryInterface;

use Illuminate\Http\Request;
use Notification;

class TaxRateController extends Controller
{
    public function __construct(
        Request $request, 
        TaxRateRepositoryInterface $taxRate)
    {
        $this->taxRate = $taxRate;
        $this->request = $request;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {
            $query = $this->taxRate->getModel()->select(
                [
                
                'id',
                'rate',
                'title']
            )->where('shop_id', '=', \Auth::guard('hideyobackend')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/tax-rate/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/tax-rate/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('hideyo_backend::tax_rate.index')->with('taxRate', $this->taxRate->selectAll());
        }
    }

    public function create()
    {
        return view('hideyo_backend::tax_rate.create')->with(array());
    }

    public function store()
    {
        $result  = $this->taxRate->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The tax rate was inserted.');
            return redirect()->route('hideyo.tax-rate.index');
        }
            
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('hideyo_backend::tax_rate.edit')->with(array('taxRate' => $this->taxRate->find($id)));
    }

    public function update($id)
    {
        $result  = $this->taxRate->updateById($this->request->all(), $id);

        if (isset($result->id)) {
            Notification::success('The tax rate was updated.');
            return redirect()->route('hideyo.tax-rate.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->taxRate->destroy($id);
        if ($result) {
            Notification::error('The tax_rate was deleted.');
            return redirect()->route('hideyo.tax-rate.index');
        }
    }
}
