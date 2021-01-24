<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function diagnosis(Request $request){
        $res=['status'=>0];
        $patient_id=$request['patient_id'];
        $manager_id=$request['manager_id'];
        $patient_diagnosis=$request['patient_diagnosis'];
        try{
            DB::table('report')->insert(['patient_id'=>$patient_id,'manager_id'=>$manager_id,'content'=>$patient_diagnosis]);
            $res['status']=1;
            $res['message']='successfully add the report.';
            return json_encode($res);
        }catch(Exception $e){
            return $e;
        }
    }
}
