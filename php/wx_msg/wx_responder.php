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
		$respond = $this->tuling_answer($content);
		$now = time();
		$format = "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[%s]]></Content>
 </xml>";
		return sprintf($format, $this->msg->getFromUserName(), $this->msg->getToUserName(), $now, $respond);
	}

// {
// 	"reqType":0,
//     "perception": {
//         "inputText": {
//             "text": "附近的酒店"
//         }
//     },
//     "userInfo": {
//         "apiKey": "",
//         "userId": ""
//     }
// }
	private function tuling_answer($msg)
	{
		$apr_url = "http://openapi.tuling123.com/openapi/api/v2";
		$key = "edb252291251783d7e2d0d51d7b06704";
		$json = json_encode(array(
			'reqType' => 0, 
			'perception' => array(
				'inputText' => array(
					'text' => $msg
				)
			),
			'userInfo' => array(
				'apiKey' => $key,
				'userId' => "xskj"
			)
		));
		$post_data = http_build_query($json);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apr_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		$data = curl_exec($ch);
		return $data;
	}
}
?>