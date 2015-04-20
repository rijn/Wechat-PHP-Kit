<?php

/**
 *	微信公众平台PHP-Kit
 *  @author  rijn <bxbian951122@gmail.com>
 *  @link https://github.com/rijn/Wechat-PHP-Kit
 *  @version 1.0
 */

error_reporting(E_ALL | E_STRICT);

Abstract Class LinkCore {

	/**
	 * 追溯数据，用来进行调试
	 * @var array
	 */
	private $_trace_data = array();

	/**
	 * 保存可用的方法列表
	 * @var array
	 */
	protected $_methods = array(
	);

	/**
	 * 数据本身
	 * @var null
	 */
	protected $data;

	/**
	 * 初始化变量
	 * @param var
	 * @return void
	 */
	public function __construct($data) {
		$this->data                       = $data;
		$this->_trace_data['__construct'] = $data;
		return $this->data;
	}

	/**
	 * 魔术方法，当试图对对象进行打印如 echo 或print的时候，调用这个方法
	 *
	 * @return $data
	 */
	public function __toString() {
		if (is_int($this->data) || is_float($this->data)) {
			$this->data = (string) $this->data;
		}

		return $this->data;
	}

	/**
	 * 魔术方法，当试图调用一个不存在的方法时，这个函数会接管这个请求
	 *
	 * @return object
	 */
	public function __call($name, $args) {
		$this->vaild_func($name);
		if (!$args) {
			$args = $this->data;
		}

		$this->data               = call_user_func($name, $args);
		$this->_trace_data[$name] = $this->data;
		return $this;
	}

	/**
	 * 检查方法是否是有效的
	 * @params string $name
	 * @return void
	 */
	private function vaild_func($name) {
		if (!in_array($name, $this->_methods)) {
			throw new Exception("invaild method");
		}
	}

	/**
	 * 对数据进行追溯
	 *
	 * @return string
	 */
	public function trace() {
		echo "<pre>";
		var_dump($this->_trace_data);
		echo "</pre>";
	}

}

include "WPK.errCode.php";
include "WPK.API.php";
include "WPK.authority.php";
include "WPK.crypt.php";

Class WPK extends LinkCore {

	/**
	 * 定义方法列表
	 */
	protected $_methods = array(
		'load',
	);

	public function __construct() {

	}

	public function load($options) {
		echo (WPK_errCode::getErrText(40001));

		return true;
	}
}

$object = new WPK();
$object->load('');
