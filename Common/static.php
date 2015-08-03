<?php
define('SYS_TIMESTART', microtime(true));
define('DIR_SEPERATOR', strstr(strtoupper(PHP_OS), 'WIN')?'\\':'/');
define('DIR_ROOT', str_replace('\\','/',dirname(__FILE__)));
define('SYS_MAGICGPC', get_magic_quotes_gpc());
define('SYS_PHPFILE', DIR_ROOT . '/config/system.php');
define('WWW_ROOT', rtrim(dirname(DIR_ROOT),'/'));
define('IMG_ROOT', WWW_ROOT . '/uploads');
define('UPLOAD_ROOT', WWW_ROOT . '/uploads');

define('PM_NAME', 'yinxing_pm');