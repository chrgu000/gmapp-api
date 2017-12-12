<?php
namespace  app\api\controller\v1;

use app\api\service\QiniuYun;
use app\common\BaseController;

class Image extends BaseController {

    public function getUploadToken(){

        $token = (new QiniuYun())->uploadToken();
        return json(['code'=>200,'msg'=>'success','data'=>['token'=>$token]]);

    }

}