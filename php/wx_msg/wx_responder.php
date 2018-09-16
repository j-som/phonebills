<?php 
/**
 * 消息响应器
 */
class WxResponder
{
	protected $msg;
	function __construct($msg)
	{
		error_log("WxResponder init");
		$this->msg = $msg;
	}

	public function getRespondStr()
	{
		return "success";
	}
}


/**
 * 文本消息
 */
class TextResponder extends WxResponder
{
	function __construct($msg)
	{
		error_log("TextResponder init");
		parent::__construct($msg);
	}

	public function getRespondStr()
	{
		error_log("TextResponder getRespondStr");
		$content = $this->msg->getProperty("Content");
		// 回应  $respond = answer($content);
		$respond = "你好，我还不懂怎么回应你";
		$now = time();
		$format = "<xml><ToUserName>< ![CDATA[%s] ]></ToUserName> <FromUserName>< ![CDATA[%s] ]></FromUserName><CreateTime>%s</CreateTime><MsgType>< ![CDATA[text] ]></MsgType><Content>< ![CDATA[%s] ]></Content></xml>";
		return sprintf($format, $this->getFromUserName(), $this->getToUserName(), $now, $content);
	}
}
?>