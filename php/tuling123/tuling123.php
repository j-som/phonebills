<?php

class Tuling123
{
    private $ask_content;
    private $reply_data;
    private $api_key = "edb252291251783d7e2d0d51d7b06704";
    private $user_id = "";
    private $reply_type;
    private $reply_content;


    function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function talk_to_tuling_ai($content)
    {
        $this->ask_content = $content;
        $this->get_tuling_ai_reply();
    }

    public function get_reply_type()
    {
        return $this->reply_type;
    }

    public function get_reply_content()
    {
        return $this->$reply_content;
    }

    private function get_tuling_ai_reply()
    {
        $apr_url = "http://openapi.tuling123.com/openapi/api/v2";
        $user_id = $this->msg->getFromUserName();
		$json = json_encode(array(
			'reqType' => 0, 
			'perception' => array(
				'inputText' => array(
					'text' => $this->ask_content
				)
			),
			'userInfo' => array(
				'apiKey' => $this->api_key,
				'userId' => $this->user_id
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
        // 需要优化图灵ai返回数据的处理
        $reply_data = json_decode($data, true);
        $code = $reply_data['intent']['code'];
		$text = "";
		if (isset($reply_data['results'])) {
			$results = $reply_data['results'];
			foreach ($results as $key => $result) {
				if (isset($result['values'])) {
					$values = $result['values'];
					if (isset($values['text'])) {
                        $this->reply_type = "text";
						$this->reply_text = $values['text'];
						break;
					}
				}
			}
		}
		if ($text == "") {
            error_log(sprintf("tuling answer error %s", $data));
            $this->reply_type = "text";
			$this->reply_text = "emmmmm.....快告诉黄哥我抽风了";
		}
    }
}

// 返回数据
// {
//     "emotion":{
//         "robotEmotion":{
//             "a":0,
//             "d":0,
//             "emotionId":0,
//             "p":0
//         },
//         "userEmotion":{
//             "a":0,
//             "d":0,
//             "emotionId":0,
//             "p":0
//         }
//     },
//     "intent":{
//         "actionName":"",
//         "code":10004,
//         "intentName":""
//     },
//     "results":
//     [
//         {
//             "groupType":0,
//             "resultType":"text",
//             "values":{
//                 "text":"怎么啦？"
//             }
//         }
//     ]
// }
?>