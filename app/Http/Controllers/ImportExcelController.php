<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\Staff_import;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function ImportUserData(Request $request){

        $request->validate([
            'xlupload' => 'required|max:10000|mimes:xlsx,xls',
        ]);

         $path = $request->file('xlupload');


        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw");

        $result = array($request->file('xlupload')->getClientOriginalExtension());


        Excel::import(new Staff_import, $path);

        return redirect()->back()->with('message', 'Data Imported Successfully');
        //echo "hello";


    }
}
