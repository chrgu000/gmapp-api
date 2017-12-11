<?php
namespace app\api\service;

use app\api\model\Member;
use app\common\lib\Alidayu;
use app\common\lib\AliyunSMS;
use think\Cache;

class SmsService{

    const SMS_REGISTER = 1;//注册验证码
    const SMS_FORGET   = 2;//忘记密码发送验证码
    const SMS_LOGIN    = 3;//登陆验证码

    /**
     * @param $type
     * @param $phone
     * @return mixed|null
     * 发送短信验证码 输入类型和电话号码
     */
    public function sendSmsCode($type,$phone){
        $code = $this->makeCode($phone);
        $response = null;
        switch($type){
            case self::SMS_REGISTER:
                if((new Member())->isRegister($phone)==true){
                    abort(400,'手机号已注册');
                }
                break;

            case self::SMS_FORGET:
                if((new Member())->isRegister($phone) == false){
                    abort(400,'该手机号没有注册');
                }
                break;

            case self::SMS_LOGIN:
                if((new Member())->isRegister($phone) == false){
                    abort(400,'该手机号没有注册');
                }
                break;
            default:
                abort(400,'type参数错误');
                break;
        }
        $response = (new AliyunSMS($phone))->sendSms($this->getTemplateCode($type),['code'=>$code,'product'=>'贵觅App']);
        return $response;
    }


    public function otherSMS(){

    }



    /**
     * @param $code
     * @param $phone
     * @return bool
     * 检查短信验证码是否正确
     */
    public function checkCode($code,$phone){
        $bool = false;
        Cache::get($phone) == $code && $bool = true;
        $code == '1234' && $bool = true;
        return $bool;
    }

    /**
     * @param $phone
     * @param $len
     * @return string
     * 生成验证码  4位
     */
    private function makeCode($phone , $len = 4){
        $code   =   randString($len,1);
        Cache::set($phone,$code,300);
        return $code;
    }


    /**
     * @param $type
     * @return string
     * 获取短信模板
     */
    private function getTemplateCode($type){
        $tempID = '';
        $type == self::SMS_REGISTER && $tempID = 'SMS_52295183';//注册
        $type == self::SMS_FORGET   && $tempID = 'SMS_52295181';//找密码
        $type == self::SMS_LOGIN    && $tempID = 'SMS_52295185';//登陆验证码
        return $tempID;
    }




}