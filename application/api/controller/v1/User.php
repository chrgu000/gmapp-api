<?php
namespace app\api\controller\v1;


use app\api\model\Member;
use app\api\service\SmsService;
use app\common\BaseController;

class User extends BaseController{

    /**
     * @return \think\response\Json
     * 注册
     */
    public function save(){
        $param    = $this->checkParam('phone,password,verify_code,channel');
        $sms_code = $param['verify_code'];
        $phone    = $param['phone'];
        
        $member   = new Member();
        //检查是否已经注册
        $member->isRegister($phone) == true && abort(400,'手机号已注册');

        //检查短信验证码
        $ret      = (new SmsService())->checkCode($sms_code,$phone);
        if(!$ret) abort(400,'短信验证码错误');

        //检查头像


        //创建用户
        $member->register($param);
        return json(['code'=>200,'msg'=>'注册成功']);
    }

    /**
     * @param $id
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 查询用户信息
     */
    public function read($id){

        $member =  Member::get($id)->toArray();
        return json(['msg'=>'','code'=>200,'data'=>$member]);

    }



}