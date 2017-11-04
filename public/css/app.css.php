<?php 

// compile less - comment the following three lines out, 
// if your development is done or you don not what to user less
require "lessc.inc.php";
$less = new lessc;
//$less->checkedCompile("template.less", "template.css");
$less->checkedCompile("app.less", "app.css");

// initialize ob_gzhandler to send and compress data
ob_start ("ob_gzhandler");
// initialize compress function for whitespace removal
ob_start("compress");
// required header info and character set
header("Content-type:text/css; charset=UTF-8");
// cache control to process
header("Cache-Control:must-revalidate");
// duration of cached content (1 hour)
$offset = 60 * 60 ;
// expiration header format
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
// send cache expiration header to broswer
header($ExpStr);
// begin function compress
function compress($buffer) {
	// remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// remove tabs, spaces, new lines, etc.        
	$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
	// remove unnecessary spaces        
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(';}', '}', $buffer);
	
	return $buffer;
}

// imports.css
//require('imports.css');

// normalize.css
//require('normalize.css');

// template css
//require('nouislider.min.css');
require('../plugins/select2/dist/css/select2.min.css');
require('photoswipe.css');
require('default-skin.css');
require('app.css');

?>