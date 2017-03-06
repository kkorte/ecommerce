<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->shopId = config()->get('app.shop_id');

    }

    public function getIndex()
    {
        $products = "";

        if (isset($_GET['query'])) {
            $keyWord = urldecode($_GET['query']);

            $products = Product::searchByQuery(
                array(
                    'bool' =>  array(
                        "must" => array(
                            'term' => array('shop_id' => $this->shopId),            
                        ),
                        "should" => array (
                            'multi_match' => [

                    
                                "prefix_length" => 3,
                                "query" => $keyWord, "type" => "phrase_prefix", "fields" => ["title", "reference_code"]
                            ],
                        ),
                        "must_not" => array(                    
                            'term' => array('active' => '0'),                      
                        ),
                        "minimum_should_match" => 1,
                    ),
                ),
                null,
                null,
                100
            );
        }

        return view('frontend.search.index')->with(array('products' => $products));
    }

    public function getDialog()
    {
        $keyWord = $_GET['query'];

        $products = Product::searchByQuery(
            array(
                'bool' =>  array(
                    "must" => array(
                        'term' => array('shop_id' => $this->shopId),        
                    ),
                    "should" => array (
                        'multi_match' => [
                    
                            "prefix_length" => 3,
                            "query" => $keyWord, "type" => "phrase_prefix", "fields" => ["title", "reference_code"]
                        ],
                    ),
                    "must_not" => array(                
                        'term' => array('active' => '0'),                  
                    ),
                    "minimum_should_match" => 1,
                ),
            ),
            null,
            array('id', 'title'),
            20
        );      

        if ($products->count()) {
            return response()->json(array("query" => $keyWord, "suggestions" => $products->toArray()));
        } else {
                return response()->json(false);
        }
    }
}
