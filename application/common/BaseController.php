<?php
namespace app\common;

use think\Request;

class BaseController{

    public  $request;
    public  $param;

    public function __construct(Request $request)
    {

        $this->request    =  $request;
        $this->param      =  json_decode(file_get_contents('php://input'),true);


    }


    /**
     * @param string $param
     * @return mixed
     * 进入所需参数过滤
     */
    protected function checkParam($param = ''){

        $paramArr = explode(',',$param);

        foreach ($paramArr as $item) {

            if(!isset($this->param[$item]) ){
                abort(400,$item.'不能为空');
                //throw new HttpException(400,$item.'不能为空');
            }
        }
        return $this->param;
    }


}