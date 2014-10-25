<?php

/**
 * This is the configuration file containing the credentials for the databases
 * used within this application.
 *
 * @package  config
 * @author   Thomas Punt
 * @license  MIT
 */
return [ 
	'mysql' => ['host' => '127.0.0.1',
				'dbname' => 'LindseysPT',
				'username' => 'root',
				'password' => 'root'],
    'redis' => ['host' => '127.0.0.1',
                'port' => 6379,
                'timeout' => 3,
                'db' => 1]
];