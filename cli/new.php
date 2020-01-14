<?php
/**
 * Strategy for generating basic application skeleton
 */
$location = realpath(dirname(__FILE__)) . '/..';
$argv[2] = getcwd()."/".$argv[2];
mkdir($argv[2]);

// create configuration files
mkdir($argv[2] . '/config');
copy($location . '/config/db.json', $argv[2] . '/config/db.json');
copy($location . '/config/routes.php', $argv[2] . '/config/routes.php');
copy($location . '/config/middleware.php', $argv[2] . '/config/middleware.php');

// initialize sample controller
mkdir($argv[2] . '/Controller');
copy($location . '/Controller/IndexController.php', $argv[2] . '/Controller/IndexController.php');

// add core libraries
mkdir($argv[2] . '/Core');
copy($location . '/Core/Controller.php', $argv[2] . '/Core/Controller.php');
copy($location . '/Core/PageUtils.php', $argv[2] . '/Core/PageUtils.php');
copy($location . '/Core/Request.php', $argv[2] . '/Core/Request.php');
copy($location . '/Core/Router.php', $argv[2] . '/Core/Router.php');

mkdir($argv[2] . '/Core/Data');
copy($location . '/Core/Data/ConnectionStringProducer.php', $argv[2] . '/Core/Data/ConnectionStringProducer.php');
copy($location . '/Core/Data/DataObject.php', $argv[2] . '/Core/Data/DataObject.php');
copy($location . '/Core/Data/SqlDataBase.php', $argv[2] . '/Core/Data/SqlDataBase.php');
mkdir($argv[2] . '/Core/Data/QueryBuilder');
copy($location . '/Core/Data/QueryBuilder/SQLDatabaseQueryBuilder.php', $argv[2] . '/Core/Data/QueryBuilder/SqlDatabaseQueryBuilder.php');
copy($location . '/Core/Data/QueryBuilder/MySQLDatabaseQueryBuilder.php', $argv[2] . '/Core/Data/QueryBuilder/MySQLDatabaseQueryBuilder.php');
copy($location . '/Core/Data/QueryBuilder/SQLiteDatabaseQueryBuilder.php', $argv[2] . '/Core/Data/QueryBuilder/SQLiteDatabaseQueryBuilder.php');
copy($location . '/Core/Data/QueryBuilder/SQLQueryBuilderFactory.php', $argv[2] . '/Core/Data/QueryBuilder/SQLQueryBuilderFactory.php');
copy($location . '/Core/Data/SqlTable.php', $argv[2] . '/Core/Data/SqlTable.php');
copy($location . '/Core/Data/SqlTableCreator.php', $argv[2] . '/Core/Data/SqlTableCreator.php');

mkdir($argv[2] . '/Core/Environment');
copy($location . '/Core/Environment/EnvironmentAdapter.php', $argv[2] . '/Core/Environment/EnvironmentAdapter.php');
copy($location . '/Core/Environment/ProductionEnvironmentAdapter.php', $argv[2] . '/Core/Environment/ProductionEnvironmentAdapter.php');

mkdir($argv[2] . '/Core/Testing');
copy($location . '/Core/Testing/TestEnvironmentAdapter.php', $argv[2] . '/Core/Testing/TestEnvironmentAdapter.php');
copy($location . '/Core/Testing/TestingRouter.php', $argv[2] . '/Core/Testing/TestingRouter.php');
// initialize middleware directory
mkdir($argv[2] . '/Middleware');

// Initialize Models directory with an example
mkdir($argv[2] . '/Models');
copy($location . '/Models/User.php', $argv[2] . '/Models/User.php');

// initialize test directory
mkdir($argv[2]."/test");

// initialize views directory
mkdir($argv[2] . '/views');
copy($location . '/views/base.php', $argv[2] . '/views/base.php');
copy($location . '/views/error.php', $argv[2] . '/views/error.php');

// Add misc files
copy($location . '/index.php', $argv[2] . '/index.php');
copy($location . '/.htaccess', $argv[2] . '/.htaccess');
copy($location . '/composer.json', $argv[2] . '/composer.json');
copy($location . '/Readme.md', $argv[2] . '/Readme.md');