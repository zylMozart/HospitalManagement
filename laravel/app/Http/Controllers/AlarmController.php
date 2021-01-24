<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlarmController extends Controller
{
    public function addstd(Request $request){
        $res = ['status' => 0];
        $name = $request['name'];
        $info = $request['info'];
        $content = json_encode($request['content']);
        $type = $request['type'];
        if(strlen($name)==0||strlen($info)==0||strlen($content)==0||strlen($type)==0){
            $res['message']='format error.';
            return json_encode($res);
        }
        try {
            DB::table('warnstd')->insert(['name'=>$name,'info'=>$info,'type'=>$type,'content'=>$content]);
            $res['status']=1;
            $res['message']='successfully add new std.';
            return json_encode($res);
        } catch (Exception $e) {
            return $e;
        }
        return json_encode($res);
    }
    public function changestd(Request $request){
        $res = ['status' => 0];
        $id=$request['id'];
        $name = $request['name'];
        $info = $request['info'];
        $content = json_encode($request['content']);
        $type = $request['type'];
        if(strlen($name)==0||strlen($info)==0||strlen($content)==0||strlen($type)==0){
            $res['message']='format error.';
            return json_encode($res);
        }
        try {
            $std=DB::table('warnstd')->where('id',$id)->get();
            DB::table('warnstd')->where('id',$id)->update(['name'=>$name,'info'=>$info,'type'=>$type,'content'=>$content]);
            $res['status']=1;
            $res['message']='successfully changed std.';
            return json_encode($res);
        } catch (Exception $e) {
            return $e;
        }
        return json_encode($res);
    }
    public function showstd(Request $request){
        $res=['status'=>0];
        $std=DB::table('warnstd')->get();
        $std=json_decode(json_encode($std),true);
        return $std;
    }
    public function cope(Request $request){
        $res=['status'=>0];
        $nurse_id=$request['manager_id'];
        $patient_id=$request['patient_id'];
        $nid=DB::table('user')->where(['id'=>$patient_id,'type'=>'patient'])->get();
        $pid=DB::table('user')->where(['id'=>$nurse_id,'type'=>'nurse'])->get();
        if(count($nid)<=0||count($pid)<=0){
            $res['message']='id not found or type does not match.';
            return json_encode($res);
        }
        try{
            DB::table('warning')->where(['patient_id'=>$patient_id,'nurse_id'=>null])->update(['nurse_id'=>$nurse_id]);
            $res['status']=1;
            $res['message']='Successfully cope the warning.';
            return json_encode($res);
        }catch(Exception $e){
            return $e;
        }
        $res['message']='Fail to cope the warning.';
        return json_encode($res);
    }
}
