<?php
	// надёжно и гарантированно убирает пробелы и комментарии из PHP-кода, переданного в виде строки (требуется PHP 5 и выше).
	// Наружние открывающие скобки <?php ...  > должны отсутствовать.
	function php_strip_whitespace_from_string($php_code)
	{
		if (!class_exists('PhpSourceMemoryStreamWrapper'))
		{class PhpSourceMemoryStreamWrapper {const WRAPPER_NAME = 'phpsource';private static $_content;private $_position;public static function prepare($content) {if (!in_array(self::WRAPPER_NAME, stream_get_wrappers())) {stream_wrapper_register(self::WRAPPER_NAME, get_class());}self::$_content = $content;}public function stream_open($path, $mode, $options, &$opened_path) {$this->_position = 0;return true;}public function stream_read($count) {$ret = substr(self::$_content, $this->_position, $count);$this->_position += strlen($ret);return $ret;}public function stream_stat() {return array();}public function stream_eof() {return $this->_position >= strlen(self::$_content);}}}
		PhpSourceMemoryStreamWrapper::prepare('<?php '.$php_code);
		$res = php_strip_whitespace(PhpSourceMemoryStreamWrapper::WRAPPER_NAME.'://');
		$res = preg_replace('#^<\?php #','',$res);
		return $res;
	}
	$result = php_strip_whitespace_from_string($_POST['data']);
?>
<form method=post>
	<input type=submit value="PHP Minify"><br>
	<textarea placeholder="исходный код без &lt;?php ... ?&gt;" name=data style="width:70%;height:300px"><?=htmlspecialchars($_POST['data'])?></textarea><br>
	<textarea onclick="this.select()" placeholder="результат" readonly="yes" style="width:70%;height:300px"><?=htmlspecialchars($result)?></textarea><br>
</form>
