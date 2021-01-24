<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function sign(Request $request){
        $ht=rand(70,85);
        $lp=rand(60,90);
        $hp=rand(90,120);
        $tp=rand(35,37);
        $res=['status'=>0];
        $id=$request['id'];

        if($id=='102') $ht=rand(0,3);


        $res['id']=$id;
        $patient=DB::table('user')->where('id',$id)->get();
        if(count($patient)<=0){
            $res['message']='user is not found.';
            return json_encode($res);
        }
        $res['data']=[$ht,$lp,$hp,$tp];
        $res['alarm']=[];
        $std=DB::table('warnstd')->get();
        if(count($std)>0){
            $std=json_decode(json_encode($std),true);
            $feature=["心跳"=>0,"舒张压"=>1,"收缩压"=>2,"体温"=>3];
            foreach($std as $item){
                $s=$item['content'];
                // $v=$s.sign;
                $s=json_decode($s,true);
                $idx=$feature[$s['sign']];
                $v=(int)$s['num'];
                if($s['cmp']=='大于') 
                    if($res['data'][$idx]>$v) array_push($res['alarm'],$item);
                if($s['cmp']=='小于') 
                    if($res['data'][$idx]<$v) array_push($res['alarm'],$item);
                // $v=$feature[$s['sign']];
                // return $v;
            }
        }
        else{
            return "warnstd is not well defined.";
        }
        if(count($res['alarm'])>0){
            try{
                foreach($res['alarm'] as $al){
                    $num=DB::table('warning')->where(['patient_id'=>$id,'type'=>$al['type'],'content'=>$al['content'],'nurse_id'=>null])->get();
                    if(!count($num))
                        DB::table('warning')->insert(['patient_id'=>$id,'type'=>$al['type'],'content'=>$al['content']]);
                } 
            }catch(Exception $e){
                return $e;
            }
        }
        $res['status']=1;
        return json_encode($res);
    }
}
