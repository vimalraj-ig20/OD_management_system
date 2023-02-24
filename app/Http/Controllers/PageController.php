<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Stroage;
use Illuminate\Support\Facades\Redirect;


class PageController extends Controller
{
  public function ViewLoginPageController(){

      return view("login-page");

  }

  public function ViewHomePageController(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[SLHEAD APPROVED]' ORDER BY leave_data.date_of_request ASC"); // SQL-CODE

         return view("admin-dashboard-content/home-page")->with("pending_data", $pending_data);

       }else if($session_type == "mentor"){

            $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[PENDING]' ORDER BY leave_data.date_of_request ASC");

            return view("mentor-dashboard-content/home-page")->with("pending_data", $pending_data);


       }else if($session_type == "Staff"){



       }else if($session_type == "sadmin"){
        $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[PENDING]' ORDER BY leave_data.date_of_request ASC");
        return view("sadmin-dashboard-content/home-page")->with("pending_data", $pending_data);


       }else if($session_type == "slincharge"){
        $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[MENTOR APPROVED]' ORDER BY leave_data.date_of_request ASC");
        return view("slincharge-dashboard-content/home-page")->with("pending_data", $pending_data);

       }else if($session_type == "slhead"){
        $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[SLINC APPROVED]' ORDER BY leave_data.date_of_request ASC");
        return view("slhead-dashboard-content/home-page")->with("pending_data", $pending_data);


       }else{

         return Redirect::to("/");

       }
  }

  public function ViewStaffManagementIndexController(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $staff_data = DB::table('staff_data')->get(); // Get staff data.
         return view("admin-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data); //Send staff data with it.

        }else if($session_type == "mentor"){

         $staff_data = DB::table('staff_data')->get(); // Get staff data.
         return view("mentor-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data);

        }else if($session_type == "slincharge"){

            $staff_data = DB::table('staff_data')->get(); // Get staff data.
            return view("slincharge-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data);

        }else if($session_type == "sadmin"){

            $staff_data = DB::table('staff_data')->get(); // Get staff data.
            return view("sadmin-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data);

        }else{

         return Redirect::to("/");

       }

  }

  public function ViewStaffManagementEditController($auto_id){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "sadmin"){

         $staff_data = DB::table('staff_data')->where("auto_id", $auto_id)->get(); // Get staff data.
         return view("admin-dashboard-content/staff-management-page-2-edit")->with('staff_data', $staff_data); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }

  public function ViewSettingsPageContoller(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.
         return view("admin-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data); //Send staff data with it.

       }else if($session_type=="mentor"){
        $admin_data = DB::table('user_account')->where("account_type", "mentor")->get(); // Get staff data.
        return view("mentor-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);

       }else if($session_type=="slincharge"){
        $admin_data = DB::table('user_account')->where("account_type", "slincharge")->get(); // Get staff data.
        return view("slincharge-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);

       }else if($session_type =="slhead"){
        $admin_data = DB::table('user_account')->where("account_type", "slhead")->get(); // Get staff data.
        return view("slhead-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);

       }else if($session_type =="sadmin"){
        $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.
        return view("sadmin-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);

       }else{

         return Redirect::to("/");

       }

  }



  public function ViewUserAccountsIndexContoller(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "sadmin"){

         $staff_data = DB::select("SELECT * FROM staff_data WHERE staff_data.staff_id NOT IN (SELECT user_account.staff_id FROM user_account)"); // SQL-CODE
         $staff_user_data = DB::table('user_account')->get(); // Get staff data.

         return view("sadmin-dashboard-content/user-accounts-page-1-index")->with(['staff_user_data' => $staff_user_data, "staff_data" => $staff_data]); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }

  public function ViewEditUserAccount($auto_id){

    $session_type = Session::get('Session_Type');
    $session_value = Session::get('Session_Value');

    if($session_type == "Admin"){

      $user_data = DB::table('user_account')->where(["auto_id" => $auto_id])->get();
      return view("admin-dashboard-content/user-accounts-page-2-edit")->with(['user_data' => $user_data]); //Send staff data with it.



    }else{

      return Redirect::to("/");

    }

  }

  public function ViewLeaveHistoryController(){

    $session_type = Session::get('Session_Type');

    if($session_type == "Admin"){

      $staff_basic_data = DB::table('staff_data')->select("staff_id","firstname", "lastname")->get();

      $leave_data = DB::table('leave_data')->where(["approval_status" => "[APPROVED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('date_of_request', 'DESC')->get();

      return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data"=>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["staff_id" => "Select a staff","type_of_leave" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

    }else{

      return Redirect::to("/");

    }

  }

  public function FilterSearchLeaveHistoryController(Request $request){
    $session_type = Session::get('Session_Type');

    if($session_type == "Admin"){

      $session_value = Session::get('Session_Value');

      $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
      $SqlCode = "";


      $staff_id      =  $request->staff_id;
      $type_of_leave =  $request->type_of_leave;
      $year          =  $request->year;
      $month         =  $request->month;
      $status        =  $request->status;


      if($type_of_leave == "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE (approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE type_of_leave = '$type_of_leave' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '{$year}______%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month != "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year == "All" && $month == "All" && $status != "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month != "All" && $status == "All"  && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id'  ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";

      }else{

        return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");

      }

      $leave_data = DB::select($SqlCode); // SQL-CODE

      $staff_basic_data = DB::table('staff_data')->select("staff_id","firstname", "lastname")->get();

      return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["staff_id" => "$staff_id", "type_of_leave" => "$type_of_leave", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.


    }else{

      return Redirect::to("/");
    }

  }




  public function ViewHomePageOfStaffAccountController(){

    $session_type = Session::get('Session_Type');


    if($session_type == "Staff"){

      $session_value = Session::get('Session_Value');

      $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
      $leave_pending_data = DB::table('leave_data')->where(["staff_id" => $session_value, "approval_status" => "[PENDING]"])->orderBy('from_date', 'ASC')->get();
      $username = DB::table('user_account')->select("username")->where(["staff_id" => $session_value])->get();

      return view("staff-dashboard-content/home-page-index")->with(['staff_basic_data' => $staff_basic_data, "username" => $username, "leave_pending_data" => $leave_pending_data]);

    }else{

      return Redirect::to("/");

    }

  }

  public function ViewSettingsPageOfStaffAccountContoller(){

     $session_type = Session::get('Session_Type');
     if($session_type == "Staff"){

       $session_value = Session::get('Session_Value');

       $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
       $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

       return view("staff-dashboard-content/settings-page-1-index")->with(['staff_data' => $staff_data, 'staff_basic_data' => $staff_basic_data]); //Send staff data with it.

     }else{

       return Redirect::to("/");

     }

  }

  public function ViewMyLeaveHistoryPageOfStaffAccountController(){


     $session_type = Session::get('Session_Type');

     if($session_type == "Staff"){

       $session_value = Session::get('Session_Value');

       $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
       $leave_data = DB::table('leave_data')->where(["approval_status" => "[APPROVED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('date_of_request', 'DESC')->get();

       return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data,"filter_options" => ["type_of_leave" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

     }else{

       return Redirect::to("/");

     }
  }

  public function FilterSearchLeaveHistoryPageOfStaffAccountController(Request $request){
    $session_type = Session::get('Session_Type');

    if($session_type == "Staff"){

      $session_value = Session::get('Session_Value');

      $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
      $SqlCode = "";

      $type_of_leave =  $request->type_of_leave;
      $year          =  $request->year;
      $month         =  $request->month;
      $status        =  $request->status;


      if($type_of_leave == "All" && $year == "All" && $month == "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year == "All" && $month == "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE type_of_leave = '$type_of_leave' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month == "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '{$year}______%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month != "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
      }else if($type_of_leave == "All" && $year == "All" && $month == "All" && $status != "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month == "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month != "All" && $status == "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month != "All" && $status != "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";

      }else if($type_of_leave != "All" && $year != "All" && $month == "All" && $status != "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month == "All" && $status != "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND approval_status = '$status' ORDER BY from_date DESC";

      }else if($type_of_leave == "All" && $year != "All" && $month != "All" && $status != "All"){

        $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND approval_status = '$status' ORDER BY from_date DESC";

      }else{

        return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");

      }

      $leave_data = DB::select($SqlCode); // SQL-CODE


      return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["type_of_leave" => "$type_of_leave", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.


    }else{

      return Redirect::to("/");
    }

  }
  public function UploadFile(Request $request){

    $proof = $request->file('proof');
    $input['filename']= time().'.'.$proof->getClientOriginalExtension();
    $destination_path = public_path('/files');
    $proof->move($destination_path,$input['filename']);

  }

  public function DownloadFile($file){

        $url = Storage::url($file);
        $download = DB::table('leave_data')->get();
        return Storage::download($url);
  }

}
