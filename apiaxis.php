<?php

class ApiCrypto
{
    function cHeader_POST($request)
    {
        $ch = curl_init();
        $url_encrypt = openssl_decrypt("9Dak7fa1LE2pPVTkfzdSo2UFkhVD8Eutv45kWEq4+rAtalLQ/s7wx5s=","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
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
        $enc_data = openssl_decrypt("+COk/A==","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $data_enc = $json_enc[$enc_data];
        $decrypt_data_enc = base64_decode((string)$data_enc,true);
        $json_data_enc = json_decode($decrypt_data_enc, true);
        $enc_decrypt_3des = openssl_decrypt("+Cez7/z/dz32IFL2","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $decrypt_3des = $json_data_enc[$enc_decrypt_3des];
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
        $enc_data = openssl_decrypt("+COk/A==","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $data_dec = $json_dec[$enc_data];
        $decrypt_data_dec = base64_decode((string)$data_dec,true);
        $json_data_dec = json_decode($decrypt_data_dec, true);
        $enc_encrypt_3des = openssl_decrypt("+Syz7/z/dz32IFL2","AES-128-CTR",base64_decode("bHljb3h6"),0,base64_decode("MDgwNDIwMDIxNjAxMjAwNA=="));
        $encrypt_3des = $json_data_dec[$enc_encrypt_3des];
        return $encrypt_3des;
    }
}

class ApiKey
{
    function cPOST_ApiKey($apikey)
    {
        $crypto = new ApiCrypto;
        $ch = curl_init();
        
        $url_encrypt = "U2H4FivA7_Q973cqFPiBBBahyXlhmVjg74PPXjqDCOrULkVG9uaqxAexoXi6SguX";
        curl_setopt($ch, CURLOPT_URL,sprintf($crypto->decrypt($url_encrypt),$apikey));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_ENCODING, "gzip");
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        flush();
        return $server_output;
    }

    function get_status_user($data)
    {
        $status_a = explode('{"status_user":',$this->cPOST_ApiKey($data));
        $status_b = explode(',"', $status_a[1]);
        $status = "{$status_b[0]}";
        return $status;
    }

    function get_name_user($data)
    {
        $name_a = explode('"user":"',$this->cPOST_ApiKey($data));
        $name_b = explode('","', $name_a[1]);
        $name = "{$name_b[0]}";
        return $name;
    }

    function get_expire_user($data)
    {
        $expire_a = explode('"expire_user":"',$this->cPOST_ApiKey($data));
        $expire_b = explode('"}', $expire_a[1]);
        $expire = "{$expire_b[0]}";
        return $expire;
    }
    
}

class ApiAXIS
{
    function cHeader_POST($apikey,$request)
    {
        $crypto = new ApiCrypto;
        $ch = curl_init();

        $url_encrypt = "U2H4FivA7_Q973cqFPiBBBahyXlhmVjg74PPXjqDCOrULkVG9uaqxNXN1Od42MGR668eF2Os20wHsaF4ukoLlw==";
        curl_setopt($ch, CURLOPT_URL,sprintf($crypto->decrypt($url_encrypt),$apikey,$request));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_ENCODING, "gzip");
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        flush();
        return $server_output;

    }

    function SendOTP($apikey,$msisdn_otp)
    {
        $query = sprintf('{"msisdn_otp":"%s"}',$msisdn_otp);
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function LoginOTP($apikey,$msisdn_login,$otp)
    {
        $query = sprintf('{"msisdn_login":"%s","otp":"%s"}',$msisdn_login,$otp);
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function BuyPackage_v2($apikey,$token,$pkgid_buy_v2)
    {
        $crypto = new ApiCrypto;
        $query = sprintf('{"token":"%s","pkgid_buy_v2":"%s"}',$token,$crypto->encrypt($pkgid_buy_v2));
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function Result_BuyPackage_v2($status_user,$name_user,$expire_user,$apikey,$token,$pkgid_buy_v2)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_buy_v2 = $this->BuyPackage_v2($apikey,$token,$pkgid_buy_v2);   
        $result_buy_v2  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$status_user,$name_user,$expire_user)],[''], $result_buy_v2);
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

    function BuyPackage_v3($apikey,$token,$pkgid_buy_v3)
    {
        $crypto = new ApiCrypto;
        $query = sprintf('{"token":"%s","pkgid_buy_v3":"%s"}',$token,$crypto->encrypt($pkgid_buy_v3));
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function Result_BuyPackage_v3($status_user,$name_user,$expire_user,$apikey,$token,$pkgid_buy_v2)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_buy_v3 = $this->BuyPackage_v3($apikey,$token,$pkgid_buy_v2);
        $result_buy_v3  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$status_user,$name_user,$expire_user)],[''], $result_buy_v3);
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

    function DoublePacket_BuyPackage($status_user,$name_user,$expire_user,$apikey,$token,$pkgid)
    {
        $this->Result_BuyPackage_v2($status_user,$name_user,$expire_user,$apikey,$token,$pkgid);
        $this->Result_BuyPackage_v3($status_user,$name_user,$expire_user,$apikey,$token,$pkgid);
    }

    function Claimmccm($apikey,$token,$pkgid_claimmccm)
    {
        $crypto = new ApiCrypto;
        $query = sprintf('{"token":"%s","pkgid_claimmccm":"%s"}',$token,$crypto->encrypt($pkgid_claimmccm));
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function Result_Claimmccm($status_user,$name_user,$expire_user,$apikey,$token,$pkgid_claimmccm)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_claimmccm = $this->Claimmccm($apikey,$token,$pkgid_claimmccm);
        $result_claimmccm  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$status_user,$name_user,$expire_user)],[''], $result_claimmccm);
        $json_claimmccm = json_decode($result_claimmccm, true);
        $status_code_claimmccm = $json_claimmccm["status_code"];
        $message_claimmccm = $json_claimmccm["message"];
    //-------------------------------
        if($status_code_claimmccm == "201")
        {
            echo "$Green ➤ $message_claimmccm !\n";
        }else{
            echo "$Red ➤ $message_claimmccm !\n";
        }
    }
    
    function Claimmccm_v2($apikey,$token,$pkgid_claimmccm_v2)
    {
        $crypto = new ApiCrypto;
        $query = sprintf('{"token":"%s","pkgid_claimmccm":"%s"}',$token,$crypto->encrypt($pkgid_claimmccm_v2));
        return $this->cHeader_POST($apikey,base64_encode($query));
    }

    function Result_Claimmccm_v2($status_user,$name_user,$expire_user,$apikey,$token,$pkgid_claimmccm_v2)
    {
        $Red      = "\e[0;31m";
        $Green  = "\e[0;32m"; 
        $result_claimmccm_v2 = $this->Claimmccm_v2($apikey,$token,$pkgid_claimmccm_v2);
        $result_claimmccm_v2  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$status_user,$name_user,$expire_user)],[''], $result_claimmccm_v2);
        $json_claimmccm_v2 = json_decode($result_claimmccm_v2, true);
        $status_code_claimmccm_v2 = $json_claimmccm_v2["status_code"];
        $message_claimmccm_v2 = $json_claimmccm_v2["message"];
    //-------------------------------
        if($status_code_claimmccm_v2 == "201")
        {
            echo "$Green ➤ $message_claimmccm_v2 !\n";
        }else{
            echo "$Red ➤ $message_claimmccm_v2 !\n";
        }
    }  

    function DoublePacket_Claimmcm($status_user,$name_user,$expire_user,$apikey,$token,$pkgid)
    {
        $this->Result_Claimmccm($status_user,$name_user,$expire_user,$apikey,$token,$pkgid);
        $this->Result_Claimmccm_v2($status_user,$name_user,$expire_user,$apikey,$token,$pkgid);
    }
}

$gitpull = "git pull";
$Red      = "\e[0;31m";
$Green  = "\e[0;32m";
$Yellow = "\e[0;33m";
$Orange = "\e[1;33m";
$Purple = "\e[0;35m";
$Cyan   = "\e[0;36m";
$White  = "\e[0;37m";

echo "\n";

$capikey = new ApiKey;
repeat_apikey:
echo "$White Input APIKey: ";
$apikey = trim(fgets(STDIN));
$GLOBALS["apikey"] = $apikey;
$status_user = $capikey->get_status_user($GLOBALS["apikey"]);
$GLOBALS["status_user"] = $status_user;
if($GLOBALS["status_user"] == "200")
{
    $GLOBALS["name_user"] = $capikey->get_name_user($GLOBALS["apikey"]);
    $GLOBALS["expire_user"] = $capikey->get_expire_user($GLOBALS["apikey"]);
    echo "\n";
    echo "$Cyan Sampurasun, ".$GLOBALS["name_user"]. "\n";
    echo "$Cyan Aktif sampai, ".$GLOBALS["expire_user"]. "\n";

echo "\n";
echo "$Orange AxisForTermux By LyCoXz v2.0 \n";
echo "\n";
echo "$Purple Login Axis... \n";

$axis = new ApiAXIS;
$crypto = new ApiCrypto;
repeat_otp:
echo "$White Input Number: ";
$nomor = str_replace(['-', '+',' '],['', '', ''], trim(fgets(STDIN)));
$result_otp = $axis->SendOTP($GLOBALS["apikey"],$nomor);
$result_otp  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$GLOBALS["status_user"],$GLOBALS["name_user"],$GLOBALS["expire_user"])],[''], $result_otp);
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
$result_login = $axis->LoginOTP($GLOBALS["apikey"],$nomor, $otp);
$result_login  = str_replace([sprintf('{"status_user":%s,"user":"%s","expire_user":"%s"}',$GLOBALS["status_user"],$GLOBALS["name_user"],$GLOBALS["expire_user"])],[''], $result_login);
$json_login = json_decode($result_login, true);
$status_login = $json_login["status"];
$message_login = $json_login["message"];
$data_login = $json_login["data"];
$dec_data_login = base64_decode((string)$data_login);
$json_data_login = json_decode($dec_data_login, true);
$token = "";
$GLOBALS["token"] = $token;
if($status_login==true)
{
    $token = $json_data_login["token"];
    echo "$Green ➤ $message_login !\n";
} else {
    $token = "";
    echo "$Red ➤ $message_login !\n";
    echo "\n";
    goto repeat_token;
}

echo "\n";

function getBuyPackage()
{
    $crypto = new ApiCrypto;
    $axis = new ApiAxis;
    $Red      = "\e[0;31m";
    $Yellow = "\e[0;33m";
    $White  = "\e[0;37m";
    $Cyan   = "\e[0;36m";

    echo "$Yellow Daftar Kuota Harian: \n";

    $one   = "1. Kuota Youtube 1GB, 1hr, 0k";
    $two   = "2. Kuota Youtube 2GB, 3hr, 0k";
    $three = "3. Kuota Tiktok 1GB, 1hr, 0k";
    $four  = "4. Kuota Instagram 1GB, 1hr, 0k";
    $five  =  "5. Kuota Malam 1GB, 2hr, 0k";
    $six   =  "6. Kuota Malam 1GB, 7hr, 0k";
    $seven   =  "7. Kuota Musik 1GB, 7hr, 0k";
    $eight   =  "8. Kuota Video 1GB, 7hr, 0k";
    $nine   =  "9. Kuota Game 1GB, 7hr, 0k";
    $ten   = "10. Kuota Sosmed 1GB, 7hr, 0k";
    $eleven   =  "11. Kuota 5MB + Bonus Vidio Platinum, 30hr, 0k";

    $list=array($one,$two,$three,$four,$five,$six,$seven,$eight,$nine,$ten,$eleven);
    foreach($list as $lists){
        echo "$Yellow $lists \n";
    }    
    repeat_pkgid:

    echo "\n$Cyan Choise Kuota Harian: ";
    $choise = trim(fgets(STDIN));
    if(!($choise==1||$choise==2||$choise==3||$choise==4||$choise==5||
    $choise==6||$choise==7||$choise==8||$choise==9||$choise==10||$choise==11))
    {
        echo "$Red ➤ Your choice is wrong \n"; 
        goto repeat_pkgid;
    }
        
    echo "\n";
    switch($choise){
        case '1' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("-QERCE2V7OsHsaF4ukoLlw=="));
            break;

        case '2' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("_HWiDPCSEaMHsaF4ukoLlw=="));
            break;

        case '3' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("Syma9QW6JwAHsaF4ukoLlw=="));
            break;

        case '4' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("ALEamI8eFzwHsaF4ukoLlw=="));
            break;

        case '5' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("r4r4DFlay5UHsaF4ukoLlw=="));
            break;

        case '6' :
            $buy = $axis->DoublePacket_Claimmcm($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("tHSCk3quBA8HsaF4ukoLlw=="));
            break;
    
        case '7' :
            $buy = $axis->DoublePacket_Claimmcm($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("kzdvhAkuWKgHsaF4ukoLlw=="));
            break;
    
        case '8' :
            $buy = $axis->DoublePacket_Claimmcm($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("LqMMzM3jDO0HsaF4ukoLlw=="));
            break;
    
        case '9' :
            $buy = $axis->DoublePacket_Claimmcm($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("nqqpE2OxQ04HsaF4ukoLlw=="));
            break;
    
        case '10' :
            $buy = $axis->DoublePacket_Claimmcm($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("rugMpL3Py2AHsaF4ukoLlw=="));
            break;

        case '11' :
            $buy = $axis->DoublePacket_BuyPackage($GLOBALS["status_user"] ,$GLOBALS["name_user"],$GLOBALS["expire_user"],$GLOBALS["apikey"],$GLOBALS["token"],$crypto->decrypt("-EinJZs3PlIHsaF4ukoLlw=="));
            break;

        }
        return $buy;
}
repeat_quota:
echo "\n";
echo "$Orange Muhammad Quillen \n";
echo "\n";
getBuyPackage();

echo "\n";

echo "$Cyan Tekan y untuk logout, Tekan n untuk mengulang pembelian kuota [y/N] : ";
$confirmation_logout =  trim( fgets( STDIN ) );
if ( $confirmation_logout !== 'y' ) {
   goto repeat_quota;
}

echo "\n";

system('am start -W -a android.intent.action.VIEW -d "https://chat.whatsapp.com/EhPyNL5ocAMJcmsACsigFa" com.whatsapp');

echo "\n";

}else{
    echo "\n";
    echo "$Red ".$capikey->get_name_user($GLOBALS["apikey"]). "\n";
    echo "\n";
    goto repeat_apikey;
}
?>
