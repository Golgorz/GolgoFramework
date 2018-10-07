<?php

include_once 'EventConstants.php';

date_default_timezone_set("Europe/Madrid");


//MYSQL DATABASE
define("MYSQL_HOST", 'localhost');
define("DB_NAME", 'golgo_framework');
define("DB_USER", 'root');
define("DB_PASS", 'AAAAA');
define("DB_PORT", '3306');
define("DB_DRIVER", 'pdo_mysql');


//SESSION OPTIONS
define("SESSION_LENGTH", 3600); //30 MINS
define("SESSIONS_SYSTEM_ACTIVE", true);
define ("GF_GLOBAL_SESSION", "gf_session");
define ("GF_DEFAULT_SESSION", "gf_default");

//LOCALIZATION
define("LOCALIZATION_ENABLED", true);
define("DEFAULT_LOCALIZATION", "es");



//EVENTS
define("EVENTS_SYSTEM_ACTIVE", true);


//LOGGING
define("LOGGING_ENABLED", true);
define("LOGGING_TO_FILE", true);
define("LOGGING_TO_MYSQL", true);



//HOST CONFIGURATION
define("DOMAIN_HOST","localhost");

define("DOMAIN_PATH","GolgoFramework2018");


//REDIS CACHE
define("REDIS_CACHE_ENABLED", false);
if(REDIS_CACHE_ENABLED)
    include '/RedisConfig.php';

//SMTP CONFIGURATION
define("SMTP_HOST","");
define("SMTP_USER","");
define("SMTP_PASS","");
define("SMTP_FROM","");
define("SMTP_FROM_NAME","");

//SECURITY

define("CSRF_ENABLED", true);
