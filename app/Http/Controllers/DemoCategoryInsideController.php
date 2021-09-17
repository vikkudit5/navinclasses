<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;   
use App\Models\Demo_category;   
use App\Models\Product;  
use File;   

class DemoCategoryInsideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$prod_id,$cat_id=null)  
    {		
        $data['mainMenu'] = 'productManagement';   
        $data['subMenu'] = 'demoproductList';  
		$parent_id=(!empty($cat_id))?$cat_id:0; 
		$info = Product::find($prod_id);
		
		if($parent_id)	
		{
			$cat = Demo_category::find($parent_id); 	
			if($cat->type=='content')
			{
				return back()->with('error','Sub category not possible!');  
			}	
		}
		
		if($request->search)   
		{
			$data['categories'] = Demo_category::where('parent_id',$parent_id)->where('product_id',$prod_id)->where('name','LIKE','%'.$request->search.'%')->paginate(10);  
		}
		else
		{
			$data['categories'] = Demo_category::where('parent_id',$parent_id)->where('product_id',$prod_id)->paginate(10);  
		}
		$nav_tree = $this->parentsTree($cat_id,'demo_categories');	
		$nav_leafs = $this->array_depth($nav_tree,array()); 
		$rev_leafs = array_reverse($nav_leafs);  
		$final_links = array();  	
		
		foreach($rev_leafs AS $leaf)
		{
			$nav = Demo_category::where('slug',$leaf)->first();    
			$final_links[$nav->id]=$leaf;    
		} 
		
		$data['nav_links'] = $final_links;     
		$data['info'] = $info;   
        return view('admin.demo-inside-category.category-list',$data);			
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($prod_id,$cat_id=null)
    {
        $data['mainMenu'] = 'categoryManagement';  
        $data['subMenu'] = 'categoryList'; 
        return view('admin.demo-inside-category.add-category',$data);	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'status'=>'required',  
            'description'=>'required',
            'sort_order'=>'required',   
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        
        $imageName = time().rand().'.'.$request->image->extension();        
        $request->image->move(public_path('uploads/category'),$imageName);  
        $slug =  str_replace(' ', '-', strtolower($request->name));  
		if(is_null($request->parent_id))	
		{
			$parent_id=0;
		}
		else
		{
			$parent_id=$request->parent_id;
		}
  
        /* Store data name in DATABASE from HERE */

        $data = array( 
			'parent_id'=>$parent_id,  
			'product_id'=>$request->product_id,    
            'admin_id'=>$admin_id,
            'name'=>$request->name,
            'type'=>$request->type,             
            'description'=>$request->description,              
            'image'=>$imageName,   
            'slug'=>$slug,
            'sort_order'=>$request->sort_order,     
            'status'=>$request->status,                
        );

        $res = Demo_category::create($data);		
        if($res)
        {
            return back()
            ->with('success', $request->name.' Has Been Added!.');    	
            
            
            
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
    public function show($id)
    {
        $data['mainMenu'] = 'categoryManagement';  
        $data['subMenu'] = 'categoryList'; 
		$info = Demo_category::findOrFail($id);   
		$data['info']=$info;   
		return view('admin.demo-inside-category.view-category',$data);	  		  		  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'categoryManagement';  
        $data['subMenu'] = 'categoryList'; 
		$info = Demo_category::findOrFail($id);   
		$data['info']=$info;   
		return view('admin.demo-inside-category.edit-category',$data);	  
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
        $admin_id = $request->session()->get('loggedIn')['id']; 
		$cat = Demo_category::findOrFail($id);       
		$image_rule = (!empty($request->image))?'required|image|mimes:jpeg,png,jpg,gif,svg':'';   
		$name_rule = ($request->name==$cat->name)?'required':'required|unique:categories';  
		
        $request->validate([
            'name'=>$name_rule,    
            'type'=>'required',
            'status'=>'required',  
            'description'=>'required',
            'sort_order'=>'required',   
            'image'=>$image_rule,  
        ]);
		
		if(!empty($request->image))
        {
			$imageName = time().rand().'.'.$request->image->extension();        
			$request->image->move(public_path('uploads/category'),$imageName);   			
		}
		else 
		{
			$imageName = $cat->image;   
		}			
		$slug =  str_replace(' ', '-', strtolower($request->name));  
        /* Store data name in DATABASE from HERE */

        $data = array( 
			'parent_id'=>$cat->parent_id,      
			'product_id'=>$request->product_id,     
            'admin_id'=>$admin_id,
            'name'=>$request->name,
            'type'=>$request->type,             
            'description'=>$request->description,              
            'image'=>$imageName,   
            'slug'=>$slug,
            'sort_order'=>$request->sort_order,     
            'status'=>$request->status,                
        ); 
        
		$res = Demo_category::where(['id'=>$id])->update($data);   
        if($res)
        {
            return back()
            ->with('success', $request->name.' Has Been Updated!.');      
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
		$cat = Demo_category::findOrFail($id);           
        if(File::exists(public_path('uploads/category/'.$cat->image)))
		{
            File::delete(public_path('uploads/category/'.$cat->image));   
        }
        $cat->delete();   	
        return back()->with('success','Category deleted successfully');      
    }
	public function changeStatus($id,$action)
	{
		$flag = 0;
		$level = 'Inactive';   
        if ($action == 'true') 
		{
            $flag = 1;
			$level = 'Active'; 	
        } 
		$cat = Demo_category::findOrFail($id);   
		$cat->status=$flag;  			
		if($cat->save())
		{
			$arr['status']=$flag;  
			$arr['code']=200;
			$arr['message']='Category is successfully '.$level;  
		}
		else
		{
			$arr['status']=$flag; 
			$arr['code']=201;   
			$arr['message']='something went wrong !!';  
		}
		echo json_encode($arr);  
	}
	public function parentsTree($id,$tble)  
    {
        $row1 = [];
        // $row = $this->db->query("SELECT id,name,parent_id,seo_url from $tble WHERE id = $id order by sort ASC")->result_array(); 
		$row = DB::table($tble)->select('*')->where('id',$id)->get();   
	
        foreach ($row as $key => $value) 
		{		
            $id = $value->parent_id;  
            $row1[$key]['id'] = $value->id;
            $row1[$key]['parent_id'] = $value->parent_id;
            $row1[$key]['name'] = $value->name;
            $row1[$key]['slug'] = $value->slug;    
            $row1[$key]['parent'] = array_values($this->parentsTree($id,$tble));               
        }
		
        return $row1;
    }
	
	public function array_depth(array $array, array $result) 
	{	
		foreach ($array as $key=>$elem)   
		{
			if (! is_array($elem)) 
			{	
				if($key=='slug')   
					array_push($result,$elem); 	   			
			}
			else
			{
				return $this->array_depth($elem,$result);   		
			}
		}
		
		return $result;  
	}
	
}
