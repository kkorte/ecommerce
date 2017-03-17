<?php namespace App\Http\Controllers\Admin;

/**
 * CouponController
 *
 * This is the controller of the contents of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\ContentRepositoryInterface;

use Illuminate\Http\Request;
use Notification;


class ContentGroupController extends Controller
{
    public function __construct(
        Request $request,
        ContentRepositoryInterface $content
    ) {
        $this->request = $request;
        $this->content = $content;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->content->getGroupModel()
            ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'content_group.id', 'content_group.title'])
            ->where('content_group.shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);

            $datatables = \Datatables::of($query)
            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/content-group/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/content-group/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);
        } else {
            return view('admin.content_group.index')->with('contentGroup', $this->content->selectAll());
        }
    }

    public function create()
    {
        return view('admin.content_group.create')->with(array());
    }

    public function store()
    {
        $result  = $this->content->create($this->request->all());

        if (isset($result->id)) {
            \Notification::success('The content was inserted.');
            return redirect()->route('admin.content-group.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.content_group.edit')->with(array('contentGroup' => $this->content->findGroup($id)));
    }

    public function editSeo($id)
    {
        return view('admin.content_group.edit_seo')->with(array('contentGroup' => $this->content->find($id)));
    }

    public function update($contentGroupId)
    {
        $result  = $this->content->updateGroupById($this->request->all(), $contentGroupId);

        if (isset($result->id)) {
            if ($this->request->get('seo')) {
                Notification::success('ContentGroup seo was updated.');
                return redirect()->route('admin.content-group.edit_seo', $contentGroupId);
            } elseif ($this->request->get('content-combination')) {
                Notification::success('ContentGroup combination leading attribute group was updated.');
                return redirect()->route('admin.content-group.{contentId}.content-combination.index', $contentGroupId);
            } else {
                Notification::success('ContentGroup was updated.');
                return redirect()->route('admin.content-group.index');
            }
        }

        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }        
       
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->content->destroyGroup($id);

        if ($result) {
            Notification::success('The content was deleted.');
            return redirect()->route('admin.content-group.index');
        }
    }
}
