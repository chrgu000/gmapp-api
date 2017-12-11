<?php
namespace app\api\controller\v1;
use app\api\model\Member;
use app\api\service\SmsService;
use app\common\BaseController;
use think\helper\Hash;

class Login extends BaseController{

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 用户名密码登录
     */
    public function passwordLogin(){

        $param    = $this->checkParam('phone,password');
        $phone    = $param['phone'];
        $password = $param['password'];
        $member   = new Member();
        $m        = $member->where('phone',$phone)->find();
        if(Hash::check($password,$m['password'])){
            
            return json(['code'=>200,'msg'=>'登陆成功','data'=>$m ]);
        }else{
            abort(400 , '手机号密码错误');
        }

    }


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 短信验证码登录
     */
    public function verifyCodeLogin(){
        $param    = $this->checkParam('phone,verify_code');
        $phone    = $param['phone'];
        $code     = $param['verify_code'];

        if(!(new SmsService())->checkCode($code,$phone)){
                abort(400,'验证码错误');
        }else{
            $member   = new Member();
            $m        = $member->where('phone',$phone)->find();
            return json(['code'=>200,'msg'=>'登陆成功','data'=>$m ]);
        }
    }

    public function forgetPassword(SmsService $smsService){
        $param    = $this->checkParam('phone,verify_code,new_password');
        $phone    = $param['phone'];
        $code     = $param['verify_code'];
        $newpwd   = $param['new_password'];
        if(!$smsService->checkCode($code,$phone)){
            abort(400,'验证码错误');
        }else{
            $member = new Member();
            $member->where('phone',$phone)->update(['password'=>Hash::make($newpwd)]);
            return json(['code'=>200,'msg'=>'重置密码成功']);
        }
    }


}