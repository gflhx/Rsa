<?php
require 'vendor/autoload.php';

$resing = Api\Rsa::getInstance();
//进行测试加密
//echo $resing::RsaEncrypt("11111");
//进行测试解密
$str = "y1Cx4ndV/ZQzo5a8eWols29KNzPd/zq/hPSplQU7hwA6syDo690QibU/2FXAOJ8cIygk/0qFAUsHLoz9Ei/xFvlECS1uQPN43poJnz1MqmKhgvVEdVAs2bARuEBPaOLN5hdZ1mN9HqVmFGvEX1rft0wY9mEpFP7S63IXdbpmM2A=";
echo $resing::RsaDecrypt($str);

