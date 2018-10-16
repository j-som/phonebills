<?php  
include_once 'wx/errorCode.php';
include_once 'wx_api/access_token.php';

if (isset($_GET["op"])) {
	switch ($_GET["op"]) {
		case 'create_menu':
			$json = '{
					    "button":[
					     	{    
					          "type":"view",
					          "name":"前往充值",
					          "url":"http://www.j-som.com/php/recharge.php"
					      	}
					    ]
					 }';
			create_menu($json);
			break;
		
		default:
			echo "nothing todo.";
			break;
	}
}

function create_menu($json)
{
	$token_res = get_access_token();
	if ($token_res[0] == ErrorCode::$OK){
		$access_token = $token_res[1];
		$url = sprintf("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s", $access_token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$data = curl_exec($ch);
		echo $data;
	}else{
		echo json_encode($token_res);
	}
}

?>