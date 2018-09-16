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
				'userId' => "2695da7716437c58fe04dc7f211dddf0"
			)
		));
		// $post_data = http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apr_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$data = curl_exec($ch);
		// {"emotion":{"robotEmotion":{"a":0,"d":0,"emotionId":0,"p":0},"userEmotion":{"a":0,"d":0,"emotionId":0,"p":0}},"intent":{"actionName":"","code":10004,"intentName":""},"results":[{"groupType":0,"resultType":"text","values":{"text":"怎么啦？"}}]}
		$tuling_back = json_decode($data),
		$code = $tuling_back['intent']['code'];
		if ($code > 10000) {
			$text = $tuling_back['results'][0]['values']['text'];
			return $text;
		}else{
			error_log(sprintf("tuling answer error %s", $data));
			return "emmmmm.....快告诉黄哥我抽风了";
		}
	}
}
?>