<?php
namespace app\api\controller\v1;

use app\api\service\SmsService;
use app\common\BaseController;

class Sms extends BaseController{


    public function send(SmsService $smsService){

        $param = $this->checkParam('phone,type');
        $type  = $param['type'];
        $phone = $param['phone'];

        if(!phoneValidate($phone)) abort(400,'手机号码格式有误');
        $response = $smsService->sendSmsCode($type,$phone);
        if($response->isSucceed()){
            return json(['msg'=>'验证码发送成功','code'=>200]);
        }else{
            abort(500,'短信发送失败，请重试');
        }
    }

    


}