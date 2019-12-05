<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;



class OrdersController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $orders = $this->getAllOrders();

        return view('orders.index', ['orders' => $orders]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
		
		
		
		$products 	= DB::select('select * from products');
        $users 		= DB::select('select * from users');
        
		return view('orders.create',
			[
				'orders' => $this->getAllOrders(),			
				'products' => $products,			
				'users' => $users,			
			]
		);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
       
        $Orders = $this->validate(request(), [
          'product_id' => 'required',
          'user_id' => 'required',
          'qty' => 'integer|min:1'
        ]);
        
        DB::insert('insert into orders 
		(user_id,product_id, qty,updated_at) values (?, ?, ?, NOW())', 
		[$request->user_id, $request->product_id, $request->qty ]);

  
        return back()->with('success', 'Order has been added to database');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function search (Request $request){

        //Send an empty variable to the view, unless the if logic below changes, then it'll send a proper variable to the view.
        $results = null;
    
        $limit = $request->limit ? $request->limit : 10;

        $orders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->select('orders.*', 'products.product_name', 'products.product_price' , 'users.name');

        
        //Runs only if the search has something in it.
        if (!empty($request->filter_name)) {
            
            $orders = $orders->where("products.product_name", 'LIKE', '%' . $request->filter_name . '%')
            ->orWhere("users.name", 'LIKE', '%' . $request->filter_name . '%');

        }
        //Runs only if the search has something in it.
        if (!empty($request->by_date) && $request->by_date == 1 ) {
            
            $orders = $orders->where('orders.created_at','>=', date('Y-m-d'));

        }
        //Runs only if the search has something in it.
        if (!empty($request->by_date) && $request->by_date > 1 ) {
            
            $orders = $orders->whereDate('orders.created_at','>=', date('Y-m-d', strtotime('-'.$request->by_date.' days')));

        }

        $orders = $orders->paginate($limit);

        return view('orders.index', ['orders' => $orders]);
    }


    /**
     * Returns all orders 
     *
     * @return Array Orders
     */

    private function getAllOrders($json=false)
    {
        
       
        $orders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->select('orders.*', 'products.product_name', 'products.product_price' , 'users.name')
        ->paginate(20);

        
        if ($json==true)
            return json_encode($orders);

        return $orders;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products 	= DB::select('select * from products');
        $users 		= DB::select('select * from users');
		$the_order 	= Orders::find($id);
        
		
		
		return view('orders.edit',
			[
				'orders' => $this->getAllOrders(false),			
				'the_order' => $the_order,			
				'products' => $products,			
				'users' => $users,			
				'id' => $id,			
			]
		);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		
		$theOrderId = $_POST['order_id'];
		
        $Orders = Orders::find($theOrderId);
        $this->validate(request(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'qty' => 'integer|min:1'
        ]);
        
		$Orders->product_id = $_POST['product_id'];
        $Orders->user_id = $_POST['user_id'];
        $Orders->qty = $_POST['qty'];
        $Orders->save();
        
		return back()->with('success', 'Orders updated successfully');
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Orders = Orders::find($id);
        $Orders->delete();
        return redirect('orders')->with('success','Orders has been  deleted');
    }
}