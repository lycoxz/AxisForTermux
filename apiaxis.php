<?php

class ApiCrypto
{
    function cHeader_POST($request)
    {
        $ch = curl_init();
        $url_encrypt = openssl_decrypt("9Dak7fa1LE2kNF62YztSo2AZzhNMqhm5qtMpR0/nrL0mYV6b4NK93Yt/DMGyd+T96Lo=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        curl_setopt($ch, CURLOPT_URL,sprintf($url_encrypt,$request));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_ENCODING, "gzip");
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        flush();
        return $server_output;
    }

    function Api_Encrypt($data)
    {
        $enc = openssl_decrypt("+Syz7/z/dz32IFL2","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $query = array($enc => "".$data."");
        return $this->cHeader_POST(base64_encode(json_encode($query)));
    }

    function encrypt($data)
    {
        $json_enc = json_decode($this->Api_Encrypt($data), true);
        $data_enc = $json_enc["data"];
        $decrypt_data_enc = base64_decode((string)$data_enc,true);
        $json_data_enc = json_decode($decrypt_data_enc, true);
        $decrypt_3des = $json_data_enc["decrypt_3des"];
        return $decrypt_3des;
    }
    
    function Api_Decrypt($data)
    {
        $dec = openssl_decrypt("+Cez7/z/dz32IFL2","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $query = array($dec => "".$data."");
        return $this->cHeader_POST(base64_encode(json_encode($query)));
    }

    function decrypt($data)
    {
        $json_dec = json_decode($this->Api_Decrypt($data), true);
        $data_dec = $json_dec["data"];
        $decrypt_data_dec = base64_decode((string)$data_dec,true);
        $json_data_dec = json_decode($decrypt_data_dec, true);
        $encrypt_3des = $json_data_dec["encrypt_3des"];
        return $encrypt_3des;
    }
}

class ApiAXIS
{
    function cHeader_POST($request)
    {
        $crypto = new ApiCrypto;
        $ch = curl_init();

        $url_encrypt = "U2H4FivA7_TARK4rDYw240Z35aNAvZ3QpxHTMjbk7580oUAou599G8oqqkcrd6ht2SVW64mjyH4HsaF4ukoLlw==";
        curl_setopt($ch, CURLOPT_URL,sprintf($crypto->decrypt($url_encrypt),$request));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_ENCODING, "gzip");
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        flush();
        return $server_output;

    }

    function SendOTP($msisdn_otp)
    {
        $crypto = new ApiCrypto;
        $query = sprintf($crypto->decrypt("i6e1zC-7idX87EGlntu3L9X_eMfg967OB7GheLpKC5c="),$msisdn_otp);
        return $this->cHeader_POST(base64_encode($query));
    }

    function LoginOTP($msisdn_login,$otp)
    {
        $crypto = new ApiCrypto;
        $query = sprintf($crypto->decrypt("i6e1zC-7idWv-p77rRCAfmdjCgYaVaZsbhSgkTfJums="),$msisdn_login,$otp);
        return $this->cHeader_POST(base64_encode($query));
    }

    function BuyPackage_v2($token,$pkgid_buy_v2)
    {
        $crypto = new ApiCrypto;
        $query = sprintf($crypto->decrypt("s0ssqLS--5zrnuDLbU0vlC7roo5Xqq3DDj1g2-SNov_7e61lkUHsOQexoXi6SguX"),$token,$crypto->encrypt($pkgid_buy_v2));
        return $this->cHeader_POST(base64_encode($query));
    }

    function Result_BuyPackage_v2($token,$pkgid_buy_v2)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_buy_v2 = $this->BuyPackage_v2($token,$pkgid_buy_v2);   
        $json_buy_v2 = json_decode($result_buy_v2, true);
        $status_buy_v2 = $json_buy_v2["status"];
        $message_buy_v2 = $json_buy_v2["message"];
    //-------------------------------
        if($status_buy_v2==true)
        {
            echo "$Green ➤ $message_buy_v2 !\n";
        }else{
            echo "$Red ➤ $message_buy_v2 !\n";
        }
    }

    function BuyPackage_v3($token,$pkgid_buy_v3)
    {
        $crypto = new ApiCrypto;
        $query = sprintf($crypto->decrypt("s0ssqLS--5zrnuDLbU0vlC7roo5Xqq3DwywGtTfyxxv7e61lkUHsOQexoXi6SguX"),$token,$crypto->encrypt($pkgid_buy_v3));
        return $this->cHeader_POST(base64_encode($query));
    }

    function Result_BuyPackage_v3($token,$pkgid_buy_v2)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_buy_v3 = $this->BuyPackage_v3($token,$pkgid_buy_v2);   
        $json_buy_v3 = json_decode($result_buy_v3, true);
        $status_buy_v3 = $json_buy_v3["status"];
        $message_buy_v3 = $json_buy_v3["message"];
    //-------------------------------
        if($status_buy_v3==true)
        {
            echo "$Green ➤ $message_buy_v3 !\n";
        }else{
            echo "$Red ➤ $message_buy_v3 !\n";
        }
    }  
}

$Red      = "\e[0;31m";
$Green  = "\e[0;32m";
$Yellow = "\e[0;33m";
$Orange = "\e[1;33m";
$Purple = "\e[0;35m";
$Cyan   = "\e[0;36m";
$White  = "\e[0;37m";

echo "\n";
echo "$Purple Login Axis...\n";

$axis = new ApiAXIS;
$crypto = new ApiCrypto;
repeat_otp:
echo "$White Input Number: ";
$nomor = str_replace(['-', '+',' '],['', '', ''], trim(fgets(STDIN)));
$result_otp = $axis->SendOTP($nomor);
$json_otp = json_decode($result_otp, true);
$status_otp = $json_otp["status"];
$message_otp = $json_otp["message"];
if($status_otp==true)
{
    echo "$Green ➤ $message_otp !\n";
} else {
    echo "$Red ➤ $message_otp !\n";
    echo "\n";
    goto repeat_otp;
}

echo "\n";

repeat_token:    
echo "$White Input OTP: ";
$otp = strtoupper(trim(fgets(STDIN)));
$result_login = $axis->LoginOTP($nomor, $otp);   
$json_login = json_decode($result_login, true);
$status_login = $json_login["status"];
$message_login = $json_login["message"];
$data_login = $json_login["data"];
$dec_data_login = base64_decode((string)$data_login);
$json_data_login = json_decode($dec_data_login, true);
$token = "";
$GLOBALS['token'] = $token;
if($status_otp==true)
{
    $token = $json_data_login["token"];
    echo "$Green ➤ $message_login !\n";
} else {
    $token = "";
    echo "$Red ➤ $message_login !\n";
    echo "\n";
    goto repeat_token;
}

repeat_buy:
echo "\n";
function DoublePacket($token,$pkgid)
{
    $axis = new ApiAxis;
    $axis->Result_BuyPackage_v2($token,$pkgid);
    $axis->Result_BuyPackage_v3($token,$pkgid);
}
function getBuyPackage()
{
    $crypto = new ApiCrypto;
    $axis = new ApiAxis;
    $Red      = "\e[0;31m";
    $Yellow = "\e[0;33m";
    $White  = "\e[0;37m";
    $Cyan   = "\e[0;36m";
    $daftar = openssl_decrypt("2CO26eT9IymwK0PkJxZA/2Ed0kY=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    echo "$Yellow $daftar \n";

    $one   = openssl_decrypt("rWzw1vDgdwPlHVjwcytD6ChN+z4L/0mhqNFqGEk=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    $two   = openssl_decrypt("rmzw1vDgdwPlHVjwcytD6ChO+z4L/0uhqNFqGEk=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    $three = openssl_decrypt("r2zw1vDgdwPlEF7uczFKrTk7/lAH7hC79t16Qw==","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    $four  = openssl_decrypt("qGzw1vDgdwPlDVn2cz9G/2kRnE1gnVTp65U4BAL4rg==","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    $five  = openssl_decrypt("qWzw1vDgdwPlCVbpZjMBvE8+kFwVtwrl+s0h","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    $six   = openssl_decrypt("qmzw1vDgdwPlEF7uczFKrTk7/lAH7EihqNFqGw77rg==","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));

    $list=array($one,$two,$three,$four,$five,$six);
    foreach($list as $lists){
        echo "$Yellow $lists \n";
    }    
    repeat_pkgid:
    
    $cho = openssl_decrypt("3yq/9PbqIymwK0PkJxZA/2Ed0kY=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
    echo "\n$Cyan $cho ";
    $choise = trim(fgets(STDIN));
    if(!($choise==1||$choise==2||$choise==3||$choise==4||$choise==5||$choise==6))
    {
        $kec_cho = openssl_decrypt("xS2l76Xsaw2sJ1Klbi0B+noT0hs=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        echo "$Red ➤ $kec_cho \n"; 
        goto repeat_pkgid;
    }
        
    echo "\n";
    switch($choise){
        case '1' :
            $buy = DoublePacket($GLOBALS['token'],$crypto->decrypt("-QERCE2V7OsHsaF4ukoLlw=="));
            break;
        case '2' :
            $buy = DoublePacket($GLOBALS['token'],$crypto->decrypt("_HWiDPCSEaMHsaF4ukoLlw=="));
            break;
        case '3' :
            $buy = DoublePacket($GLOBALS['token'],$crypto->decrypt("Syma9QW6JwAHsaF4ukoLlw=="));
            break;
        case '4' :
            $buy = DoublePacket($GLOBALS['token'],$crypto->decrypt("ALEamI8eFzwHsaF4ukoLlw=="));
            break;
        case '5' :
            $buy = DoublePacket($GLOBALS['token'],$crypto->decrypt("r4r4DFlay5UHsaF4ukoLlw=="));
            break;
        case '6' :
            $buy = $axis->Result_BuyPackage_v2($GLOBALS['token'],$crypto->decrypt("mZ4BlrAuzVQHsaF4ukoLlw=="));
            break;
        }
        return $buy;
}getBuyPackage();

echo "\n";

$conf_logout = openssl_decrypt("yCe7/OuvekKwKkPwbH5N4m8TyQgL/yyssZwkCEzosL02cU2V/d+jhZ18A9uwOeCloKuffdy5v+89Xm2qs6Lf","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
echo "$Cyan $conf_logout ";
$confirmation_logout =  trim( fgets( STDIN ) );
if ( $confirmation_logout !== 'y' ) {
   goto repeat_buy;
}

?>
