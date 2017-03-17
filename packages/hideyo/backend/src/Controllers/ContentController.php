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

class ContentController extends Controller
{
    public function __construct(
        Request $request,
        ContentRepositoryInterface $content
    ) {
        $this->content = $content;
        $this->request = $request;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $content = $this->content->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'content.id',
                'content.title', 'content_group_id', 'content_group.title as contenttitle']
            )->where('content.shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)


            ->with(array('contentGroup'))        ->leftJoin('content_group', 'content_group.id', '=', 'content.content_group_id');
            
            $datatables = \Datatables::of($content)

            ->filterColumn('title', function ($query, $keyword) {
                $query->whereRaw("content.title like ?", ["%{$keyword}%"]);
            })
            ->addColumn('contentgroup', function ($content) {
                return $content->contenttitle;
            })
            ->addColumn('action', function ($content) {
                $delete = \Form::deleteajax('/admin/content/'. $content->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/content/'.$content->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('admin.content.index')->with('content', $this->content->selectAll());
        }
    }

    public function create()
    {
        return view('admin.content.create')->with(array('groups' => $this->content->selectGroupAll()->lists('title', 'id')->toArray()));
    }

    public function store()
    {
        $result  = $this->content->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The content was inserted.');
            return redirect()->route('admin.content.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.content.edit')->with(array('content' => $this->content->find($id), 'groups' => $this->content->selectGroupAll()->lists('title', 'id')->toArray()));
    }

    public function editSeo($id)
    {
        return view('admin.content.edit_seo')->with(array('content' => $this->content->find($id)));
    }

    public function update($contentId)
    {

        $result  = $this->content->updateById($this->request->all(), $contentId);

        if (isset($result->id)) {
            if ($this->request->get('seo')) {
                Notification::success('Content seo was updated.');
                return redirect()->route('admin.content.edit_seo', $contentId);
            } elseif ($this->request->get('content-combination')) {
                Notification::success('Content combination leading attribute group was updated.');
                return redirect()->route('admin.content.{contentId}.content-combination.index', $contentId);
            } else {
                Notification::success('Content was updated.');
                return redirect()->route('admin.content.edit', $contentId);
            }
        }

        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
       
        return redirect()->back()->withInput();
    }


    public function destroy($id)
    {
        $result  = $this->content->destroy($id);

        if ($result) {
            Notification::success('The content was deleted.');
            return redirect()->route('admin.content.index');
        }
    }
}
