<?php 

/**
 * 用户操作后，微信服务器给我的服务器发送的xml内容
  <xml>
  	<ToUserName><![CDATA[gh_938a5213a4a9]]></ToUserName>\n
  	<FromUserName><![CDATA[oNTs_1abyyv7Gc5fVigYEFAoLv3s]]></FromUserName>\n
  	<CreateTime>1537077950</CreateTime>\n
  	<MsgType><![CDATA[text]]></MsgType>\n
  	<Content><![CDATA[\xe4\xbd\xa0\xe5\xa5\xbd\xe4\xbd\xa0\xe5\xa5\xbd]]></Content>\n
  	<MsgId>6601699527099013082</MsgId>\n
  </xml>
 */

include_once 'wx_responder.php';
include_once 'text_responder.php';

class WxMsg
{
	private $raw_data = "";
	private $msg_type;
	private $to_user_name;
	private $from_user_name;
	private $create_time;
	private $xml_tree;

	function __construct($content)
	{
		$this->raw_data = $content;
		$this->xml_tree = new DOMDocument();
		$this->xml_tree->loadXML($content);
		$this->msg_type = $this->xml_tree->getElementsByTagName('MsgType')->item(0)->nodeValue;
		$this->to_user_name = $this->xml_tree->getElementsByTagName('ToUserName')->item(0)->nodeValue;
		$this->from_user_name = $this->xml_tree->getElementsByTagName('FromUserName')->item(0)->nodeValue;
		$this->create_time = $this->xml_tree->getElementsByTagName('CreateTime')->item(0)->nodeValue;
	}

	public function getType()
	{
		return $this->msg_type;
	}

	public function getToUserName()
	{
		return $this->to_user_name;
	}

	public function getFromUserName()
	{
		return $this->from_user_name;
	}

	public function getCreateTime()
	{
		return $this->create_time;
	}

	public function getProperty($name)
	{
		$v = $this->xml_tree->getElementsByTagName($name);
		if ($v) {
			return $v->item(0)->nodeValue;
		}else{
			return null;
		}
	}

	public function getResponder()
	{
		switch ($this->getType()) {
			case "text":
				return new TextResponder($this);
			
			default:
				return new WxResponder($this);
		}
	}


}
?>