<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Main_category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$cat_id=null)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'categoryList';
        // $data['categories'] = Category::where(['admin_id'=>$admin_id])->paginate(10);

        $parent_id=(!empty($cat_id))?$cat_id:0; 
		
		
		if($parent_id)	
		{
			$cat = Main_category::find($parent_id); 	
			if($cat->type=='content')
			{
				return back()->with('error','Sub category not possible!');  
			}	
		}
		
		if($request->search)   
		{
			$data['categories'] = Main_category::where('parent_id',$parent_id)->where('admin_id',$admin_id)->where('name','LIKE','%'.$request->search.'%')->paginate(10);  
		}
		else
		{
			$data['categories'] = Main_category::where('parent_id',$parent_id)->where('admin_id',$admin_id)->paginate(10);  
		}
		$nav_tree = $this->parentsTree($cat_id,'main_categories');	
		$nav_leafs = $this->array_depth($nav_tree,array()); 
		$rev_leafs = array_reverse($nav_leafs);  
		$final_links = array();  	
		
		foreach($rev_leafs AS $leaf)
		{
            $nav = Main_category::where('slug',$leaf)->first(); 
             
			$final_links[$nav->id]=$leaf;    
		} 
		
		$data['nav_links'] = $final_links;     
		// $data['info'] = $info;  

        // dd($data['categories']);
        return view('admin.category.category-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$cat_id=null)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'categoryList';
        $data['categories'] = Main_category::where('admin_id',$admin_id)->get();
        return view('admin.category.add-category',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCategory(Request $request)
    {

        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            
           
        ]);

        
        $imageName = time().rand().'.'.$request->image->extension();        
        $request->image->move(public_path('uploads/category'),$imageName);  
        $slug =  str_replace(' ', '-', strtolower($request->name));  

        $_sortOrder = Main_category::where('admin_id',$admin_id)->get()->last();
        if(empty($_sortOrder))
        {
            $sort_order = 1;
        }else{
           $sort_order =  $_sortOrder->sort_order +1;
        }
	
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
			 
            'admin_id'=>$admin_id,
            'name'=>$request->name,
            'type'=>$request->type,             
            'sort_order'=>$sort_order,     
            'image'=>$imageName,   
            'slug'=>$slug,
               
                           
        );

        // dd($data);

        $res = Main_category::create($data);		
        if($res)
        {
            return back()
            ->with('success', $request->name.' Has Been Added!.');    	
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }

        
    }

    public function saveSubCategory(Request $request)
    {
        // dd($request->input());
        
        $admin_id = $request->session()->get('loggedIn')['id'];
       
        $slug =  str_replace(' ', '-', strtolower($request->subcatName));
        $_sortOrder = Main_category::where('admin_id',$admin_id)->get()->last();
        if(empty($_sortOrder))
        {
            $sort_order = 1;
        }else{
           $sort_order =  $_sortOrder->sort_order +1;
        }

        $data = array(

            'admin_id'=>$admin_id,
            'parent_id'=>$request->catId,
            'name'=>$request->subcatName,            
            'slug'=>$slug,
            'sort_order'=>$sort_order,          
            
        );

        $res = Main_category::create($data);
        if($res)
        {
            echo 1;
        }else{
            echo -1;
        }
        

    }

    public function getSubCategory(Request $request)
    {
        // dd($request->catId);
        $getSubCat = '';
        $catId = $request->catId;
        $getSubCategory = Main_category::where('parent_id',$catId)->get();

        // print_r($getSubCategory);exit;

        if(!empty($getSubCategory))
        {
            $getSubCat  .= '<select class="form-control category">';
            $getSubCat .= '<option value="">Select Category</option>';
            foreach($getSubCategory as $getSubCateg)
            {
                $getSubCat .= '<option value='.$getSubCateg->id.'>'.$getSubCateg->name.'</option>';
            }

            $getSubCat  .= '</select">';
        }

        // dd($getSubCat);

        return response()->json($getSubCat);
        
    }


    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'categoryList';
        $data['category'] = Main_category::where(['id'=>$id])->first();
        // dd($data['category']);
        return view('admin.category.view-main-category',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'categoryList';
        $data['category'] = Main_category::where(['id'=>$id])->first();
        // dd($data['category']);
        return view('admin.category.edit-main-category',$data);
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
        $data = array(

         
            'name'=>$request->name,
            'type'=>$request->type,
           
            'sort_order'=>$request->sort_order,
            
            
        );

        $res = Main_category::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', $request->name.' Has Been Added!.');
        }else{
            return back()
            ->with('error', 'Something Went Wrong!');
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
    //    dd($id);
       Main_category::where(['id'=>$id])->delete(); 	
        return back()->with('success','Category deleted successfully');   
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
