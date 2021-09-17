<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\Product;
use App\Models\Price;
use App\Models\Billing;
use App\Models\Orderproductgroup;
use App\Models\Main_category;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // echo "hello";exit;
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        
        $data['mainMenu'] = 'orderManagement';
        $data['subMenu'] = 'orderList';
        

        if( isset($_GET['query']) && (strlen($_GET['query']) > 1) &&  !isset($_GET['daterange'])  ){

            $search_text = $_GET['query'];
           $data['billings'] = Billing::where('users.name','LIKE','%'.$search_text.'%')
            ->orWhere('users.email','LIKE','%'.$search_text.'%')
            ->orWhere('users.phone','LIKE','%'.$search_text.'%')
            ->orWhere('billings.trans_id','LIKE','%'.$search_text.'%')
            ->orWhere('billings.payment_id','LIKE','%'.$search_text.'%')
            ->orWhere('billings.paymentstatus','LIKE','%'.$search_text.'%')
            ->orWhere('billings.order_no','LIKE','%'.$search_text.'%')
            ->orWhere('orderproductgroups.product_name','LIKE','%'.$search_text.'%')
            ->where(['billings.admin_id'=>$admin_id])            
            ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id') 
            ->join('orderproductgroups', 'billings.id', '=', 'orderproductgroups.billing_id')                                                                      
            ->paginate(10, ['billings.*','users.name','users.email','users.phone']);

            // return view('admin.order.order-list',$data);
            
        }else if(isset($_GET['daterange']) && strlen($_GET['daterange']) > 1 && !isset($_GET['query'])){

            $daterange = explode("-",$_GET['daterange']);
            $start_date = date("Y-m-d",strtotime(trim($daterange[0])));
            $end_date = date("Y-m-d",strtotime(trim($daterange[1])));
            

            $data['billings'] = Billing::whereBetween('billings.created_at',[$start_date, $end_date])
             ->where(['billings.admin_id'=>$admin_id])            
             ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id') 
             ->join('orderproductgroups', 'billings.id', '=', 'orderproductgroups.billing_id')                                                                      
             ->paginate(10, ['billings.*','users.name','users.email','users.phone']);


        }else if(isset($_GET['daterange']) && strlen($_GET['daterange']) > 1 && isset($_GET['query'])){

            $search_text = $_GET['query'];
            $daterange = explode("-",$_GET['daterange']);
            $start_date = date("Y-m-d",strtotime(trim($daterange[0])));
            $end_date = date("Y-m-d",strtotime(trim($daterange[1])));
            // dd($end_date);
            $data['billings'] = Billing::where('users.name','LIKE','%'.$search_text.'%')
             ->orWhere('users.email','LIKE','%'.$search_text.'%')
             ->orWhere('users.phone','LIKE','%'.$search_text.'%')
             ->orWhere('billings.trans_id','LIKE','%'.$search_text.'%')
             ->orWhere('billings.payment_id','LIKE','%'.$search_text.'%')
             ->orWhere('billings.paymentstatus','LIKE','%'.$search_text.'%')
             ->orWhere('billings.order_no','LIKE','%'.$search_text.'%')
             ->orWhere('orderproductgroups.product_name','LIKE','%'.$search_text.'%')
             ->where(['billings.admin_id'=>$admin_id])  
            ->whereBetween('billings.billing_date',[$start_date, $end_date])          
             ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id') 
             ->join('orderproductgroups', 'billings.id', '=', 'orderproductgroups.billing_id')                                                                      
             ->paginate(10, ['billings.*','users.name','users.email','users.phone']);


        }else{
            $data['billings'] = Billing::where(['billings.admin_id'=>$admin_id])            
            ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id')                                                                       
            ->paginate(10, ['billings.*','users.name','users.email','users.phone']);

            // dd($data['contents']);

          
        }

       $data['main_categories'] =  Main_category::where(['admin_id'=>$admin_id,'type'=>'content'])->get();

    //    dd($data['main_categories']);
        return view('admin.order.order-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'orderManagement';
        $data['subMenu'] = 'orderList';
        $data['users'] = User::where(['admin_id'=>$admin_id,'status'=>'1'])->get();
        $data['products'] = Product::where(['admin_id'=>$admin_id,'status'=>'1'])->get();
        return view('admin.order.add-order',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $admin_id = $request->session()->get('loggedIn')['id'];
        $user_unique_id = $request->user_id;
        $prod_id = $request->prod_id;
        $mode = $request->mode;
        $duration = $request->duration;
        $select_mode = $request->select_mode;
        $amount = $request->price;
        // dd($prod_id);
        

            // dd($expire_date);


        $_serialNo = Billing::where(['admin_id'=>$admin_id,'paymentstatus'=>'Credit'])->get()->last();
        if(empty($_serialNo))
        {
            $serialNo = 1;
        }else{
           $serialNo =  $_serialNo->serialno +1;
        }


        // $_serialNo = $this->Cart_model->get_bill_no();
        $_thisYear = date('Y');
        $_bill_No  = "";
        
        if (date('m') <= 3)
        {
            
            $_bill_No = config('constants.bill.invoice').'/' . (date('Y') - 1) . '-' . date('Y') . '/' . $serialNo;
        }
        else
        {
            $_bill_No = config('constants.bill.invoice').'/' . date('Y') . '-' . (date('Y') + 1) . '/' . $serialNo;
        }

        $data = array(

            'admin_id'=>$admin_id,
            'payment_id'=>"Manual-".uniqid(),
            'order_no'=>$_bill_No,
            'serialno'=>$serialNo,
            'user_unique_id'=>$user_unique_id,
            'amount'=>$amount,
            'taxamt'=>0,
            'grandtotal'=>$amount,
            'purpose'=>'billing',
            'long_url'=>uniqid(),
            'trans_id'=>'Manual-'.uniqid(),
            'quantity'=>'1',
            'bill_type'=>'in',
            'instrument_type'=>'manual',
            'use_wallet'=>'no',
            'promocode'=>'',
            'cashback'=>0,
            'taxable'=>0,
            'paymentstatus'=>'Credit',
            'ordertype'=>'Live',
            'billing_date'=>date('Y-m-d'),
        );

        $res = Billing::create($data);

       $billing_id =  $res->id;
       if(!empty($billing_id))
       {
            $product = Product::where(['id'=>$prod_id])->first();

            $timestamp = date('Y-m-d');
            $expires = strtotime('+'.$duration.' days', strtotime($timestamp));
            $expire_date = date('Y-m-d', $expires);
            
            
            $orderproduct = array(
                'product_id'=>$prod_id,                
                'qty'=>1,
                'promo'=>'',
               'user_unique_id'=>$user_unique_id,
                
                'billing_id'=>$billing_id,
                'billing_no'=>$_bill_No,
                'tax'=>0,
                'price'=>$amount,
                'discount'=>0,
                'cashback'=>0,
                'product_mode'=>$select_mode,
                'product_type'=>$product->type,
                'product_name'=>$product->name,
                'days'=>$duration,
                'start_date'=>date('Y-m-d'),
                'expire_date'=>$expire_date,
                'updgrade'=>'new'
            );

            // dd()

            $result = Orderproductgroup::create($orderproduct);

            if($result)
            {
                return back()
                ->with('success', 'Order Has Been Created!.');
                
                
                
            }else{
                return back()
                ->with('error','Something Went Wrong!');
            }


       }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProductPrice(Request $request)
    {
        $html = '';
        $prod_id = $request->prod_id;

        $prices = Price::where(['product_id'=>$prod_id])->get();

        $html .= "<option>Select Mode</option>";
        if(!empty($prices))
        {
            foreach($prices as $price)
            {
                $html .= "<option value=".$price->id.">".$price->mode."-".$price->duration."</option>";
            }
        }

        print_r($html);

    }

    public function getPriceDuration(Request $request)
    {
        
        $mode_id = $request->mode_id;

        $price = Price::where(['id'=>$mode_id])->first();
        echo json_encode($price);

       
    }



    /// order product list

    public function orderProductList(Request $request,$billing_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'orderManagement';
        $data['subMenu'] = 'orderList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           
  
            
            $data['billings'] = Billing::where('users.name','LIKE','%'.$search_text.'%')
            ->orWhere('users.email','LIKE','%'.$search_text.'%')
            ->orWhere('users.phone','LIKE','%'.$search_text.'%')
            ->orWhere('billings.trans_id','LIKE','%'.$search_text.'%')
            ->orWhere('billings.payment_id','LIKE','%'.$search_text.'%')
            ->orWhere('billings.paymentstatus','LIKE','%'.$search_text.'%')
            ->orWhere('billings.order_no','LIKE','%'.$search_text.'%')
            ->orWhere('orderproductgroups.product_name','LIKE','%'.$search_text.'%')
            ->where(['billings.admin_id'=>$admin_id,'orderproductgroups.billing_id'=>$billing_id])            
            ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id') 
            ->join('orderproductgroups', 'billings.id', '=', 'orderproductgroups.billing_id')                                                                       
            ->paginate(10, ['orderproductgroups.*','users.name','users.email','users.phone']);

            return view('admin.order.order-product-list',$data);
            
        }else{
            $data['billings'] = Billing::where(['billings.admin_id'=>$admin_id,'orderproductgroups.billing_id'=>$billing_id])            
            ->join('users', 'users.user_unique_id', '=', 'billings.user_unique_id')                                                                       
            ->join('orderproductgroups', 'billings.id', '=', 'orderproductgroups.billing_id')                                                                       
            ->paginate(10, ['orderproductgroups.*','users.name','users.email','users.phone']);

            // dd($data['billings']);

          
            return view('admin.order.order-product-list',$data);
        }
    }

    public function changeOrderStatus(Request $request)
    {
        // dd($request->input());
        $data = array(
            'expired'=>$request->status
        );

        Orderproductgroup::where(['id'=>$request->id])->update($data);

       

    }
}
