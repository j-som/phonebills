<?php 
/**
 * 消息响应器
 */
class WxResponder
{
	protected $msg;
	function __construct($msg)
	{
		this->msg = $msg
	}

	public function getRespondStr()
	{
		return "success"
	}
}


/**
 * 文本消息
 */
class TextResponder extends WxResponder
{
	function __construct($msg)
	{
		parent::__construct($msg);
	}

	public function getRespondStr()
	{
		$content = this->msg->getProperty("Content");
		// 回应  $respond = answer($content);
		$respond = "你好，我还不懂怎么回应你";
		$now = time();
		$format = "<xml><ToUserName>< ![CDATA[%s] ]></ToUserName> <FromUserName>< ![CDATA[%s] ]></FromUserName><CreateTime>%s</CreateTime><MsgType>< ![CDATA[text] ]></MsgType><Content>< ![CDATA[%s] ]></Content></xml>";
		return sprintf($format, this->getFromUserName(), this->getToUserName(), $now, $content);
	}
}
?>