<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function register(Request $request){
        $res=['status'=>0];
        $type=$request['type'];
        $name=$request['name'];
        $password=$request['password'];
        $password2=$request['password2'];
        $activate=$request['activate'];
        $age=$request['age'];
        $sex=$request['sex'];
        $id=$request['id'];
        if($activate!='666'){
            $res['message']='activate is invaild.';
            return json_encode($res);
        }
        if($password!=$password2){
            $res['message']='passwords do not match.';
            return json_encode($res);
        }
        if(strlen($name)<2){
            $res['message']='username is too short.';
            return json_encode($res);
        }
        if(strlen($password)<6){
            $res['message']='password is too short.';
            return json_encode($res);
        }
        if($type!='patient'&&$type!='doctor'&&$type!='nurse'&&$type!='admin'){
            $res['message']='type is invalid.';
            return json_encode($res);
        }
        $age=(int)($age);
        if(!is_int($age)||$age<0||$age>200){
            $res['message']='age is invalid';
            return json_encode($res);
        }
        if($sex!='男'&&$sex!='女'){
            $res['message']=$sex;
            return json_encode($res);
        }
        $hasid=DB::table('user')->where('id',$id)->get();
        if(count($hasid)>0){
            $res['message']='id has already exists';
            return json_encode($res);
        }
        $msg=DB::table('user')->insert(['id'=>$id,'type'=>$type,'name'=>$name,'sex'=>$sex,'age'=>$age,'pwd'=>$password]);
        $res['status']=1;
        $res['res']=$msg;
        return json_encode($res);
    }
    public function login(Request $request){
        $res=['status'=>0];
        $id=$request['id'];
        $password=$request['password'];
        $haslogin=DB::table('user')->where('id',$id)->where('pwd',$password)->get();
        if(count($haslogin)>0){
            $haslogin=json_decode(json_encode($haslogin),true)[0];
            $res['status']=1;
            $res['message']='Successfully login.';
            $res['type']=$haslogin['type'];
            $res['username']=$haslogin['name'];
            $res['id']=$haslogin['id'];
            return json_encode($res);
        }
        $res['message']='username or password does not match.';
        return json_encode($res);
        // return $haslogin;
        // return json_encode($res);
    }
    public function profile(Request $request){
        $res=['status'=>0];
        $id=$request['id'];
        $user=DB::table('user')->where('id',$id)->get();
        if(count($user)>0){
            $user=json_decode(json_encode($user),true)[0];
            $res['status']=1;
            $res['user']=$user;
            return json_encode($res);
        }
        $res['message']='user_id is not found.';
        return json_encode($res);
    }
    public function allusers(Request $request){
        $res=['status'=>0];
        $type=$request['type'];
        $users=DB::table('user')->where('type',$type)->get();
        if(count($users)>0){
            $users=json_decode(json_encode($users),true);
            $res['status']=1;
            $res['message']='successfully get all users.';
            $res['user']=$users;
            return json_encode($res);
        }
        $res['message']='fail to get all users.';
        return json_encode($res);
    }
    public function report(Request $request){
        $res=['status'=>0];
        $id=$request['id'];
        $reports=DB::table('report')->where('patient_id',$id)->get();
        if(count($reports)>0){
            $reports=json_decode(json_encode($reports),true);
            foreach($reports as &$r){
                $doctor=DB::table('user')->where('id',$r['manager_id'])->get();
                $patient=DB::table('user')->where('id',$r['patient_id'])->get();
                $r['doctor']=$doctor[0];
                $r['patient']=$patient[0];
            }
            $res['status']=1;
            $res['message']='successfully get reports.';
            $res['reports']=$reports;
            return json_encode($res);
        }
        $res['message']='fail to get all user.';
        return json_encode($res);
    }
    public function change(Request $request){
        $res=['status'=>0];
        $user=$request['user'];
        try{
            DB::table('user')->where('id',$user['id'])->update(['id'=>$user['id'],'name'=>$user['name'],'type'=>$user['type'],'sex'=>$user['sex'],'age'=>$user['age'],'bed'=>$user['bed']]);
            $res['status']=1;
            $res['message']='successfully changed user\'s information.';
            return json_encode($res);
        }catch(Exception $e){
            return $e;
        }
        $res['message']='fail to get all user.';
        return json_encode($res);
    }
    public function add(Request $request){
        $res=['status'=>0];
        $user=$request['user'];
        // return json_encode($user['type']);
        try{
            DB::table('user')->insert(['id'=>$user['id'],'name'=>$user['name'],'type'=>$user['type'],'sex'=>$user['sex'],'age'=>$user['age'],'bed'=>$user['bed'],'pwd'=>$user['pwd']]);
            $res['status']=1;
            $res['message']='successfully added new user';
            return json_encode($res);
        }catch(Exception $e){
            return $e;
        }
        $res['message']='fail to add new user.';
        return json_encode($res);
    }
    public function delete(Request $request){
        $res=['status'=>0];
        $id=$request['id'];
        try{
            DB::table('user')->where('id',$id)->delete();
            $res['status']=1;
            $res['message']='successfully deleted user';
            return json_encode($res);
        }catch(Exception $e){
            return $e;
        }
        $res['message']='fail to delete user.';
        return json_encode($res);
    }
    public function log(Request $request){
        $res=['status'=>0];
        $id=$request['id'];
        $thing1=DB::table('report')->where('patient_id',$id)->get();
        $thing1=json_decode(json_encode($thing1),true);
        $thing2=DB::table('warning')->where('patient_id',$id)->get();
        $thing2=json_decode(json_encode($thing2),true);
        $things=[];
        foreach($thing1 as $t){
            $temp=[];
            $temp['type']='report';
            $temp['title']=$t['title'];
            $temp['pubtime']=$t['pubtime'];
            array_push($things,$temp);
        }
        foreach($thing2 as $t){
            $temp=[];
            $temp['type']='warning';
            $con=json_decode($t['content'],true);
            $temp['title']=$con['sign'].$con['cmp'].$con['num'];
            $temp['pubtime']=$t['pubtime'];
            array_push($things,$temp);
        }
        foreach($things as $v1){
            $pubtime[]=$v1['pubtime'];
        }
        array_multisort($things,SORT_ASC,$pubtime);
        return json_encode($things);
    }
}
