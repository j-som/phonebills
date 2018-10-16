<?php  
include_once dirname(__FILE__) . '/../data/verify_data.php';
include_once dirname(__FILE__) . '/../wx/errorCode.php';
public function get_access_token()
{
	// todo 读取缓存
	$url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s", VerifyData::$APP_ID, VerifyData::$APP_SECRET);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	$res = json_decode($output, true);
	if (isset($res["access_token"])) {
		$access_token = $res["access_token"];
		// $remain_time = $res["expires_in"];
		// todo 存入缓存
		return array(ErrorCode::$OK, $access_token);
	}else{
		$error_code = $res["errcode"];
		$error_msg = $res["errmsg"];
		return array($error_code, $error_msg);
	}
}
?>