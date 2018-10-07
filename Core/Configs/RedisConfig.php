<?php

define('DB_REDIS_SCHEME', 'tcp');
define('DB_REDIS_HOST',   '127.0.0.1');
define('DB_REDIS_PORT',  '6379');
define('DB_REDIS_DATABASE',  'MYAPP');
define('DB_REDIS_DATABASE_PSWD',  'XXXX');
define('DB_REDIS_CACHE_DATABASE',  'gf_cache');
define('DB_REDIS_CACHE_DATABASE_PSWD',  'XXXX');


Predis\Autoloader::register();
