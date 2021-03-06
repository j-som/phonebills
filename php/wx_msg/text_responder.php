<?php 
include_once dirname(__FILE__) . '/../tuling123/tuling123.php';
/**
 * 文本消息
 */
class TextResponder extends WxResponder
{
	function __construct($msg)
	{
		parent::__construct($msg);
	}

	public function respond()
	{
		$content = $this->msg->getProperty("Content");
		$wx_user_id = $this->msg->getFromUserName();
		$user_id = str_replace("_","", $wx_user_id);
		$tuling123 = new Tuling123($user_id);
		$tuling123->talk_to_tuling_ai($content);
		$reply_type = $tuling123->get_reply_type();
        error_log(sprintf("tuling answer3 %s", $reply_type));
		switch ($reply_type) {
			case 'text':
				$now = time();
				$respond = $tuling123->get_reply_content();
				$format = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
				$respond_str = sprintf($format, $wx_user_id, $this->msg->getToUserName(), $now, $respond);
				echo $respond_str;
				break;
			
			default:
				$now = time();
				$respond = $tuling123->get_reply_content();
				$format = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
				$respond_str = sprintf($format, $wx_user_id, $this->msg->getToUserName(), $now, $reply_type);
				echo $respond_str;
				break;
		}
	}
}
 ?>