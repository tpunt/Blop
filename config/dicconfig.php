<?php

/**
 * This is the configuration file for Dice (a dependency injection container).
 *
 * @package  config
 * @author   Thomas Punt
 * @license  MIT
 */
function configureDICE(Dice\Dice $dice, array $config)
{
	$rulePDO = new Dice\Rule;
	$rulePDO->shared = true;
	$rulePDO->constructParams = ["mysql:host={$config['dbconfig']['mysql']['host']};dbname={$config['dbconfig']['mysql']['dbname']}",
								 $config['dbconfig']['mysql']['username'],
								 $config['dbconfig']['mysql']['password'],
								 [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]];
	$dice->addRule('PDO', $rulePDO);
}