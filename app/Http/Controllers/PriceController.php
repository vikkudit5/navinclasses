<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Price;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$product_id)
    {
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['prices'] = DB::table('prices')->where('product_id',$product_id)->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            $data['product'] = Product::where(['admin_id'=>$admin_id,'id'=>$product_id])->first();
            return view('admin.price.price-list',$data);
            
        }else{
            $data['prices'] = DB::table('prices')->where('product_id',$product_id)->paginate(10);

            $data['product'] = Product::where(['admin_id'=>$admin_id,'id'=>$product_id])->first();
            return view('admin.price.price-list',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $data['product'] = Product::where(['admin_id'=>$admin_id,'id'=>$id])->first();
        return view('admin.price.add-price',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$product_id)
    {
        //    dd($request->input()); 
            $request->validate([
                'mode'=>'required',
                'duration'=>'required',
                'price'=>'required',
               
            ]);

            
            
            $_sortOrder = Price::get()->last();
            if(empty($_sortOrder))
            {
                $sort_order = 1;
            }else{
            $sort_order =  $_sortOrder->sort_order +1;
            }
            // dd($sort_order);
    
            /* Store data name in DATABASE from HERE */

            // dd($request->input());

            $data = array(

                'product_id'=>$product_id,
                'mode'=>$request->mode,
                'duration'=>$request->duration,
                'price'=>$request->price,               
                'sort_order'=>$sort_order,
               
                
            );

                 

            $res = Price::create($data);
            if($res)
            {
                return back()
                ->with('success', 'Price Has Been Added!.');
                
                
                
            }else{
                return back()
                ->with('error','Something Went Wrong!');
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$product_id)
    {
       
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $data['product'] = Product::where(['id'=>$product_id])->first();
        $data['price'] = Price::where(['id'=>$id])->first();
        return view('admin.price.view-price',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$product_id)
    {
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $data['product'] = Product::where(['id'=>$product_id])->first();
        $data['price'] = Price::where(['id'=>$id])->first();
        return view('admin.price.edit-price',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$product_id)
    {
         //    dd($request->input()); 
         $request->validate([
            'mode'=>'required',
            'duration'=>'required',
            'price'=>'required',
            'sort_order'=>'required',
           
        ]);

        
        
        

        /* Store data name in DATABASE from HERE */

        // dd($request->input());

        $data = array(

           
            'mode'=>$request->mode,
            'duration'=>$request->duration,
            'price'=>$request->price,               
            'sort_order'=>$request->sort_order,
           
            
        );

             

        $res = Price::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', 'Price Has Been Updated!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Price::where(['id'=>$id])->delete();
         return back()->with('success','Post deleted successfully');
    }
}
