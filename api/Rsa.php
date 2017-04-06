<?php

namespace Api;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author gflhx
 */
class Rsa {

    private static $_instance;
    private static $PRIVATE_KEY = '';
    private static $Public_KEY = '';

    //private标记的构造方法
    private function __construct() {
        
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        self::$PRIVATE_KEY = file_get_contents( dirname(__FILE__).'/rsa_private_key.pem');
        self::$Public_KEY = file_get_contents( dirname(__FILE__).'/rsa_public_key.pem');
        return self::$_instance;
    }

    public function RsaEncrypt($data) {
        $crypt_res = "";
        for ($i = 0; $i < ((strlen($data) - strlen($data) % 117) / 117 + 1); $i++) {
            $crypt_res = $crypt_res . (self::SingEncrypt(mb_strcut($data, $i * 117, 117, 'utf-8')));
        }
        return $crypt_res;
    }

    private static function SingEncrypt($data) {
        $encrypted = '';
        openssl_public_encrypt($data, $encrypted, self::$Public_KEY); //公钥加密，私钥解密
        return base64_encode($encrypted); //加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
    }

    public function RsaDecrypt($encrypted) {
        $decrypt_res = "";
        $datas = explode('=', $encrypted);
        foreach ($datas as $value) {
            $decrypt_res = $decrypt_res . self::SingDecrypt($value);
        }
        return $decrypt_res;
    }

    private static function SingDecrypt($data) {
        $decrypted = '';
        openssl_private_decrypt(base64_decode($data), $decrypted, self::$PRIVATE_KEY);
        return $decrypted;
    }

}
