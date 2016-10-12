<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    public function signup()
    {
    	$username=Request::get('username');
    	$password=Request::get('password');
    	// 检查用户名和密码是否为空
    	if(!($username && $password))
    		return ['status'=>0,'msg'=>'用户名和密码不可为空'];

    	//检查用户名是否存在
    	$user_exists=$this
    	    ->where('username',$username)
    	    ->exists();

    	    if($user_exists)
    	    	return ['status'=>0,'msg'=>'用户名已存在'];
    	    	
    	//加密密码
    	$hashed_password = bcrypt($password);   
      
    	//存入数据库
    	$this->password = $hashed_password;
    	$this->username = $username;
    	if($this->save())
    		return ['status' => 1,'id' => $this -> id];
		    else
		    return ['status' => 0, 'msg' => 'db insert failed'];
	}
}