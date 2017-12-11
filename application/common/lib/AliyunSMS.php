<?php
namespace app\common\lib;



use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Requests\PublishMessageRequest;
use think\Log;

class AliyunSMS{


    private $accessKey      = 'LTAIRt9bzbcjO1bj';
    private $access_secret  = 'trCMaOK6MrX2bRMnEXxEh1uZDLZkUN';
    private $sign_name      = '贵觅科技';
    private $end_point      = 'https://1118588197056383.mns.cn-hangzhou.aliyuncs.com/';
    private $topicName      = "sms.topic-cn-hangzhou";


    public  $phone;
    private $client;


    public function __construct($phone)
    {
        vendor('aliyunMNS.mns-autoloader');
        $this->phone         = $phone;
        $this->client        = new Client($this->end_point,$this->accessKey,$this->access_secret);
        $this->topic         = $this->client->getTopicRef($this->topicName);

    }


    /**
     * @param $templateCode
     * @param array $param   短信内容参数
     * @return mixed
     * 发送短信封装
     */
    public function sendSms($templateCode,$param = []){
        if($templateCode == '') abort('400','短信模板无法找到');
        $batchSmsAttributes  = new BatchSmsAttributes($this->sign_name,$templateCode);
        $batchSmsAttributes->addReceiver($this->phone, $param);
        return $this->sendRequest($batchSmsAttributes);


    }


    /**
     * @param $batchSmsAttributes
     * @return mixed
     * 发送请求
     */
    private function sendRequest($batchSmsAttributes){
        $messageAttributes   = new MessageAttributes(array($batchSmsAttributes));
        $request    = new PublishMessageRequest("messageBody",$messageAttributes);
        try{
            $res = $this->topic->publishMessage($request);
            return $res;
        }catch (MnsException $e){
            Log::error($e);
        }
    }




}