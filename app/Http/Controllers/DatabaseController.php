<?php

namespace App\Http\Controllers;

use data;

use Exception;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\leave_data;

class DatabaseController extends Controller
{
    public function InsertStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                //   'position' => 'required',
            ]);

            $staff_id       = $request->staff_id;
            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $date_of_birth  = $request->date_of_birth;
            $email          = $request->email;
            $phone_number   = $request->phone_number;
            // $position       = $request->position;


            if (DB::table('staff_data')->where('staff_id', $staff_id)->doesntExist()) {

                if (DB::insert('INSERT INTO staff_data (staff_id, firstname, lastname, dob, email, phone_number) values (?, ?, ?, ?, ?, ?)', [$staff_id, $first_name, $last_name, $date_of_birth, $email, $phone_number])) {

                    return redirect()->back()->with('message', 'Registeration is Successful.');
                }
            } else {
                return redirect()->back()->withErrors("<strong>Unable to register:</strong> The given staff ID already exists in the database");
            }
        }
    }

    public function DeleteStaffData($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            if (DB::table('staff_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function UpdateStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            $validatedata = $request->validate([
                'auto_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                //   'position' => 'required',
            ]);

            $auto_id        = $request->auto_id;
            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $date_of_birth  = $request->date_of_birth;
            $email          = $request->email;
            $phone_number   = $request->phone_number;
            // $position       = $request->position;


            if (DB::table('staff_data')->where('auto_id', $auto_id)->update(['firstname' => $first_name, 'lastname' => $last_name, 'dob' => $date_of_birth, 'email' => $email, 'phone_number' => $phone_number])) {

                return Redirect::to("/view-staff-management-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-staff-management-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function ChangeUsername(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.

            if ($request->password == $admin_data[0]->password) {

                if (DB::table('user_account')->where('account_type', 'admin')->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePassword(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'admin')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        }else if($session_type == "mentor"){

            $admin_data = DB::table('user_account')->where("account_type", "mentor")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'mentor')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }

        }else if($session_type == "slincharge"){

            $admin_data = DB::table('user_account')->where("account_type", "slincharge")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'slincharge')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            }else if($session_type == "slhead"){

                $admin_data = DB::table('user_account')->where("account_type", "slhead")->get(); // Get staff data.

                if ($request->current_password == $admin_data[0]->password) {

                    if ($request->new_password == $request->confirm_password) {

                        if (DB::table('user_account')->where('account_type', 'slhead')->update(['password' => $request->new_password])) {

                            return redirect()->back()->with('message', 'Password has been updated successfully.');
                        } else {

                            return redirect()->back()->with('message', 'No changes made.');
                        }
                    } else {

                        return redirect()->back()->withErrors('The confirm password does not match');
                    }
                } else {

                    return redirect()->back()->withErrors('The current password is wrong.');
                }

            }else if($session_type == "sadmin"){

                $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.

                if ($request->current_password == $admin_data[0]->password) {

                    if ($request->new_password == $request->confirm_password) {

                        if (DB::table('user_account')->where('account_type', 'sadmin')->update(['password' => $request->new_password])) {

                            return redirect()->back()->with('message', 'Password has been updated successfully.');
                        } else {

                            return redirect()->back()->with('message', 'No changes made.');
                        }
                    } else {

                        return redirect()->back()->withErrors('The confirm password does not match');
                    }
                } else {

                    return redirect()->back()->withErrors('The current password is wrong.');
                }

            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }

        } else {

            return Redirect::to("/");
        }
    }

    public function EditUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);


            $username  =  $request->username;
            $password  =  $request->password;
            $auto_id   =  $request->auto_id;

            if (DB::table('user_account')->where('auto_id', $auto_id)->update(['username' => $username, 'password' => $password])) {

                return Redirect::to("/view-user-accounts-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-user-accounts-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function DeleteUserAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            if (DB::table('user_account')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function InsertUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'username' => 'required',
                'password' => 'required',
                'acc_type' => 'required',
            ]);

            $staff_id  =  $request->staff_id;
            $username  =  $request->username;
            $password  =  $request->password;
            $acc_type  =  $request->acc_type;


            if (DB::table('user_account')->where('staff_id', $staff_id)->doesntExist()) {

                if (DB::table('user_account')->where('username', $username)->doesntExist()) {

                    if (DB::insert('INSERT INTO user_account (staff_id, username, password, account_type) values (?, ?, ?, ?)', [$staff_id, $username, $password, $acc_type])) {

                        return redirect()->back()->with('message', 'Account creation is Successful.');
                    }
                } else {

                    return redirect()->back()->withErrors("<strong>Unable to create:</strong> The given username already exists in the database.");
                }
            } else {

                return redirect()->back()->withErrors("<strong>Unable to create:</strong> The staff already has an account");
            }
        }
    }

    public function AcceptRequest($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "mentor") {

            $leave_type_check = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();

            $leave_type_final = $leave_type_check[0]->type_of_leave;

            if ($leave_type_final == 'Sick leave' or $leave_type_final == 'Casual leave') {
                if ($this->isOnline()) {

                    $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                    $staffid = $leavedata[0]->staff_id;
                    $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                    $mailid = $staffdata[0]->email;
                    //return $mailid;
                    $data = [

                        "recipient" => $mailid,
                        "fromemail" => "camps@bitsathy.ac.in",
                        "fromname" => "Camps Site",
                        "subject" => 'Reg: Leave request',
                        "body" => '           Your leave request has been accepted'

                    ];
                    try {
                        Mail::to($mailid)->send(new MailNotify($data));
                    } catch (Exception $th) {
                        return $th;
                    }

                    if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
                        return redirect()->back()->with('message', 'Accepted');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return "No Internet Connection";
                }
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
                    return redirect()->back()->with('message', 'Accepted');
                } else {
                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[MENTOR APPROVED]"])) {
                    return redirect()->back()->with('message', 'Accepted');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            }
        } else if ($session_type == 'slincharge') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[SLINC APPROVED]"])) {
                return redirect()->back()->with('message', 'Accepted');
            } else {

                return redirect()->back()->with('message', 'No changes made.');
            }
        } else if ($session_type == 'slhead') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[SLHEAD APPROVED]"])) {
                return redirect()->back()->with('message', 'Accepted');
            } else {

                return redirect()->back()->with('message', 'No changes made.');
            }
        } else if ($session_type == 'Admin') {

            if ($this->isOnline()) {

                $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                $staffid = $leavedata[0]->staff_id;
                $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                $mailid = $staffdata[0]->email;
                //return $mailid;
                $data = [

                    "recipient" => $mailid,
                    "fromemail" => "camps@bitsathy.ac.in",
                    "fromname" => "Camps Site",
                    "subject" => 'Reg: Leave request',
                    "body" => '            Your OD request has been accepted'

                ];
                try {
                    Mail::to($mailid)->send(new MailNotify($data));
                } catch (Exception $th) {
                    return $th;
                }

                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
                    return redirect()->back()->with('message', 'Accepted');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return "No Internet Connection";
            }
        } else {
            return Redirect::to("/");
        }
    }

    //  public function sendEmail(){

    //     if($this->isOnline()){

    //         $leavedata = DB::table('leave_data')->where(['auto_id'=> $auto_id])->get();
    //         $staffid = $leavedata[0]->staff_id;
    //         $staffdata=DB::table('staff_data')->where(['staff_id'=> $staffid])->get();
    //         $mailid= $staffdata[0]->email;
    //         //return $mailid;
    //          $data1=[

    //              "recipient"=> "kavinraj.cs21@bitsathy.ac.in",
    //              "fromemail"=>"srisathyasai24680@gmail.com",
    //              "fromname"=> "Camps Site",
    //              "subject" => 'Reg: Leave request',
    //              "body"=> 'Your leave request as been accepted'

    //          ];
    //          try {
    //              Mail::to("srisathyasai24680@gmail.com")->send(new MailNotify($data1));
    //          } catch (Exception $th) {
    //              return 'mail not sent';
    //          }

    //      }else{
    //          return "No internet connection";
    //      }

    //  }

    public function isOnline($site = "https://youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }

    public function DeclineRequest($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            if ($this->isOnline()) {

                $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                $staffid = $leavedata[0]->staff_id;
                $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                $mailid = $staffdata[0]->email;
                //return $mailid;
                $data = [

                    "recipient" => $mailid,
                    "fromemail" => "srisathyasai24680@gmail.com",
                    "fromname" => "Camps Site",
                    "subject" => 'Reg: Leave request',
                    "body" => '         Your leave/OD request has been declined'

                ];
                try {
                    Mail::to($mailid)->send(new MailNotify($data));
                } catch (Exception $th) {
                    return 'mail not sent';
                }
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                    return redirect()->back()->with('message', 'Declined');
                } else {

                    return Redirect::to("/");
                }
            } else {
                return "No internet connection";
            }
        } else if ($session_type == 'mentor') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else if ($session_type == 'slincharge') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else if ($session_type == 'slhead') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else {
            return redirect()->back()->with('message', 'No changes made.');
        }
    }

    public function ChangeUsernameOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->password == $staff_data[0]->password) {

                if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePasswordOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->current_password == $staff_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function InsertLeaveDataOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Staff") {

            $validatedata = $request->validate([

                'type_of_leave' => 'required',
                'description' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
                'session' => 'required',
                'file'   => 'required',
            ]);

            $staff_id          =  $session_value;
            $type_of_leave     =  $request->type_of_leave;
            $description       =  $request->description;
            $from_date         =  $request->from_date;
            $to_date           =  $request->to_date;
            $session           =  $request->session;
            $proof             =  $request->file;
            $date_of_request   =  date('Y-m-d H:i:s');
            $approval_status      =  "[PENDING]";

            if (DB::insert('INSERT INTO leave_data (staff_id, type_of_leave, description, from_date, to_date, session,proof,  date_of_request, approval_status ) values (?, ?, ?, ?, ?, ?,?,?,?)', [$staff_id, $type_of_leave, $description, $from_date, $to_date, $session, $proof, $date_of_request, $approval_status])) {

                return redirect()->back()->with('message', 'Leave request has been submited successfully.');
            }
        }
    }

    public function DeleteLeavePendingRequestInStaffAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Staff") {

            if (DB::table('leave_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }
}
