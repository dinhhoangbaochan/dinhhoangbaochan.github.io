<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportOrder;
use App\Products;
use DB;


class ImportOrderController extends Controller
{
    // Authentication 
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Render all orders page
    public function allOrder()
    {
        $order = Order::all();
    	return view('order.all_order')->with('order', $order);
    }

    // Create order
    public function createImport()
    {
    	return view('order.create_order');
    }

    // Search 
    public function search( Request $request)
    {
    	if($request->get('input'))
        {
            $query = $request->get('input');
            $data = DB::table('products')
            ->where('name', 'LIKE', "%{$query}%")
            ->get();
            $output = '';
            foreach($data as $row)
            {
               $output .= '<a href="" class="dropdown-item" data-id="' .$row->id. '" >' . $row->name . '</a>';
           }
           $output .= '';
           echo $output;
       } else {
       		echo "Unable to find";
       }
    	
    }


    // Find selected product
    public function findProduct(Request $request)
    {
    	$current_id = $request->get('currentID');
    	if ( $current_id ) {
    		$find_product = DB::table('products')
    		->where('id', $current_id)
    		->get();

    		foreach ($find_product as $product) {
    			$response_array = array(
    				'id'		=>		$product->id,
    				'name'		=>		$product->name,
    				'sku'		=>		$product->sku,
                    'img'       =>      $product->product_image,
                    'price'     =>      $product->price,
    			);
    		}

    		$encode_res = json_encode($response_array);

    		echo $encode_res;

    	} else {
    		echo "Unable to find what you've clicked";
    	}
    	
    } 


    // Import Order store
    function storeImport(Request $request)
    {   
        $qty = $request->qty;

        foreach ($qty as $id => $amount) {
            $product = Products::find($id);
            $product->tmp_imp = (int)$amount; 
            $product->save();
        }
        
        $location = $request->location;
        $productsInOrder = serialize($request->products);
        $orderCode = $request->orderCode;
        $deadline = $request->deadline;

        $order = new ImportOrder;
        $order->code = $orderCode;
        $order->location = $location;
        $order->products = $productsInOrder;
        $order->status = "wait";
        $order->deadline = $deadline;

        $order->save();

        return response()->json(['url' => url('orders/import')]);

    }


    // View all import orders
    function allImport() {
        $importOrder = ImportOrder::all();
        return view('order.all_import')->with( 'importOrder', $importOrder );
    }


    // Single order controller
    function single($id) {
        $currentImportOrder = ImportOrder::find($id);
        return view('order.import.single')->with( 'thisOrder', $currentImportOrder );
    }

}