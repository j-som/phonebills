<?php

include_once ("data/verify_data.php");
include_once ("wx_msg/wx_msg.php");

$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$tmpArr = array(VerifyData::$TOKEN, $timestamp, $nonce);
sort($tmpArr, SORT_STRING);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );
if ($signature == $tmpStr) {
	if (isset($_GET["echostr"])) {
		echo $_GET["echostr"];
	}else{
		$post_data = file_get_contents("php://input");
		$msg = new WxMsg($post_data);
		$res = $msg->getResponder();
		$ret = $res->getRespondStr();
		echo $ret;
	}
} else{
	echo "error";
};

?>