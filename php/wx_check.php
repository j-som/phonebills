<?php

include_once "data/verify_data.php";


$signature = _GET["signature"];
$timestamp = _GET["timestamp"];
$nonce = _GET["nonce"];
$echostr = _GET["echostr"];

if (checkSignature($signature, $timestamp, $nonce)) {
	echo $echostr;
}else{
	echo "";
};

function checkSignature($signature, $timestamp, $nonce)
{
	$tmpArr = array(VerifyData::$TOKEN, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );
	if ($signature == $tmpStr) {
		return true;
	} else{
		return false;
	}
}
?>