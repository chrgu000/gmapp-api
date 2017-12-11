<?php
namespace app\api\model;

use think\helper\Hash;
use think\Model;
use think\Request;

class Member extends Model{


    /**
     * @param $user
     * 注册用户
     */
    public function register($user){

        self::create([
            'phone'         => $user['phone'],
            'password'      => Hash::make($user['password']),
            'create_at'     => NOW_TIME,
            'update_at'     => NOW_TIME,
            'login_ip'      => Request::instance()->ip(),
            'channel'       => $user['channel'],
            'avatar'        => $user['avatar'],
        ]);

    }


    /**
     * @param $phone
     * @return bool
     * 判断手机号是否注册
     */
    public function isRegister($phone){
        $bool  = false;
        self::where('phone',$phone)->count() > 0 && $bool = true;
        return $bool;
    }

}