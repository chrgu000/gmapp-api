<?php
namespace  app\api\service;

use Qiniu\Auth;

class QiniuYun{

    private $accessKey  ;
    private $secretKey  ;
    private $bucket     ;
    private $auth       ;
    private $callbackUrl;

    public function __construct()
    {
        $this->secretKey = config('qiniu.secretKey');
        $this->accessKey = config('qiniu.accessKey');
        $this->auth = new Auth($this->accessKey,$this->secretKey);
    }


    public function uploadToken(){
        $uid    =  1;
        $policy =  [
            'callbackUrl' =>   $this->callbackUrl,
            'callbackBody' => '{"fname":"$(fname)", "fkey":"$(key)", "desc":"$(x:desc)", "uid":' . $uid . '}'
        ];
        return $this->auth->uploadToken($this->bucket, null, 3600, $policy);
    }




}