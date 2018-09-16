<?php

include_once ("data/verify_data.php");
include_once ("wx_msg/wx_msg.php");

$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
// $echostr = $_GET["echostr"];
$tmpArr = array(VerifyData::$TOKEN, $timestamp, $nonce);
sort($tmpArr, SORT_STRING);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );
if ($signature == $tmpStr) {
	$post_data = file_get_contents("php://input");
	$msg = new WxMsg($post_data);
	$res = $msg->getResponder();
	$ret = $res->getRespondStr();
	echo $ret;
	// echo $echostr;
} else{
	echo "error";
};

?>