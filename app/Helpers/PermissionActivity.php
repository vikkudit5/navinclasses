<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Request;
// use App\Models\LogActivity as LogActivityModel;    
use carbon\carbon;


class PermissionActivity
{

    public static function getPermission($module_id)
    {
        $adminId = [];
		$modulePermission = DB::table('admin_module_permissions')
            ->where('module_id',$module_id)		
		->get();

        if(!empty($modulePermission))
        {
            foreach($modulePermission as $modulePermis)
            {
                $adminId[] = $modulePermis->admin_id;
            }
        }

		return $adminId;
		
        // return "hello";

    }

    public static function getPermissionByAdminId($admin_id,$module_id)
    {
        
		$modulePermission = DB::table('admin_module_permissions')
            ->where('admin_id',$admin_id)		
            ->where('module_id',$module_id)		
		->first();

      

		return $modulePermission->permission;
		
        // return "hello";

    }




	




}

