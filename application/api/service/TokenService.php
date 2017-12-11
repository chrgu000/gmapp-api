<?php
namespace app\api\service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class TokenService {


    private $issuser  = 'JWT';
    private $audience = 'JWT';
    private $sign     = 'GM';

    public function __construct()
    {

    }

    public function make(array $member){
        
       return  (new Builder())
           ->setId($member['id'])
           ->setIssuer($this->issuser)
           ->setAudience($this->audience)
           ->set('member',$member)
           ->setExpiration(time()+1)
           ->sign(new Sha256(),$this->sign)
           ->getToken();

    }


    public function parse($token){
        $result =  (new Parser())->parse((string) $token);
        return object_to_array($result->getClaim('name'));
    }

    public function validate(){

        $data   =   new ValidationData();


    }

}