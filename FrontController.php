<?php

define('PATH', __DIR__ .'/');

function fixQueryString($sPath) {

  $aQueryString = array();
  parse_str($_SERVER['QUERY_STRING'], $aQueryString);
  unset($aQueryString['_path'], $_GET['_path']);
  $PHP_SELF = explode("?", $_SERVER['REQUEST_URI']);
  $_SERVER['QUERY_STRING'] = urldecode(http_build_query($aQueryString));
  $_SERVER['PHP_SELF'] = $PHP_SELF[0];
  $_SERVER['SCRIPT_NAME'] = $PHP_SELF[0];
  $_SERVER['SCRIPT_FILENAME'] = PATH . $sPath;

  $GLOBALS['PHP_SELF']         = $PHP_SELF[0];
  $GLOBALS['HTTP_SERVER_VARS'] = & $_SERVER;
}

$sPath = $_GET['_path'];

fixQueryString($sPath);

require_once "std/Modification.php";
require Modification::getFile($sPath);