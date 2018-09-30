<?php


use Core\Controllers\RedisCacheController;
use Core\Controllers\GFEvents\GFEvent;
use Core\Controllers\GFEvents\GFEventController;

if(REDIS_CACHE_ENABLED) {
				$redis = RedisCacheController::getRedisClient();
				$redisKey = 'Redis::GolgoFramework::Test';
				$redis->set($redisKey, "TEST");
				$redis->expire($redisKey, 60);
			}
			

// Nuevo eventos
 
 $event = new GFEvent();
 $event->setName("start");
 $gfevent = new GFEventController();
 $gfevent->attach($event, function($evento) {
 $evento->stopPropagation(false);
 print_r("llamado evento en se acaba!");
 }, 0);
 $gfevent->attach($event, function($args) {print_r("llamado evento en start222!"); die();}, 0);
			 