<?php 
/**
 * 消息响应器
 */
class WxResponder
{
	protected $msg;
	function __construct($msg)
	{
		$this->msg = $msg;
	}

	public function respond()
	{
		echo "success";
	}
}
?>