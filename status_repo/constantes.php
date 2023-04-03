<?php


// SVN
define("SVN_INFO", "svn info");
define("SVN_STATUS", "svn status");


// comandos
define("REVISAO", SVN_INFO . ' | grep -E "Rev(.\S*):" | sed -r "s/Rev(.*): ([0-9]*)/\2/"');

define("MODIFICADOS", SVN_STATUS . ' | grep "M       "');
