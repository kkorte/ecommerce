<?php namespace App\Http\Controllers\Admin;

/**
 * ProductController
 *
 * This is the controller of the product weight types of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;


use Dutchbridge\Repositories\ProductRelatedProductRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;

use Illuminate\Http\Request;
use Notification;

class ProductRelatedProductController extends Controller
{
    public function __construct(Request $request, ProductRelatedProductRepositoryInterface $productRelatedProduct, ProductRepositoryInterface $product)
    {
        $this->productRelatedProduct = $productRelatedProduct;
        $this->product = $product;
        $this->request = $request;
    }

    public function index($productId)
    {
           $product = $this->product->find($productId);
        if ($this->request->wantsJson()) {

            $query = $this->productRelatedProduct->getModel()
            ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','related_product_id', 'product_id'])
            ->where('product_id', '=', $productId);
            
            $datatables = \Datatables::of($query)
                ->addColumn('related', function ($query) use ($productId) {
                    return $query->RelatedProduct->title;
                })
                ->addColumn('product', function ($query) use ($productId) {
                    return $query->Product->title;
                })
                ->addColumn('action', function ($query) use ($productId) {
                    $delete = \Form::deleteajax('/admin/product/'.$productId.'/related-product/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                    
                    return $delete;
                });

                return $datatables->make(true);


        } else {
            return view('admin.product_related_product.index')->with(array('product' => $product));
        }
    }

    public function create($productId)
    {
        $product = $this->product->find($productId);
        $products = $this->product->selectAll()->lists('title', 'id');

        return view('admin.product_related_product.create')->with(array('products' => $products, 'product' => $product));
    }

    public function store($productId)
    {
        $result  = $this->productRelatedProduct->create($this->request->all(), $productId);
        return redirect()->route('admin.product.{productId}.related-product.index', $productId);
    }

    public function edit($id)
    {
        return view('admin.product_related_product.edit')->with(array('productRelatedProduct' => ProductImage::find($id), 'categories' => $this->productRelatedProduct->selectAll()->lists('title', 'id')));
    }

    public function update($id)
    {

        $result  = $this->productRelatedProduct->updateById($this->generateInput(), $id);

        if (!$result->id) {
            return redirect()->back()->withInput()->withErrors($result->errors()->all());
        } else {
            Notification::success('The related product is updated.');
            return redirect()->route('admin.product_related_product.index');
        }
    }

    public function destroy($productId, $id)
    {
        $result  = $this->productRelatedProduct->destroy($id);

        if ($result) {
            Notification::success('The related product is deleted.');
            return redirect()->route('admin.product.{productId}.related-product.index', $productId);
        }
    }
}