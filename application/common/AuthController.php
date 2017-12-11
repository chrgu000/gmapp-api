<?php
namespace app\common;

use think\Request;

class AuthController extends BaseController{


    public function __construct()
    {
        parent::__construct(Request::instance());
        $this->jwt_auth();
    }





    public function jwt_auth(){

    }


}