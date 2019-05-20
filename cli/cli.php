#!/usr/bin/env php
<?php
    $location = realpath(dirname(__FILE__)).'/..';
    mkdir($argv[1]);

    mkdir($argv[1].'/config');
    copy($location.'/config/db.json', $argv[1].'/config/db.json');
    copy($location.'/config/routes.php', $argv[1].'/config/routes.php');
    copy($location.'/config/middleware.php', $argv[1].'/config/middleware.php');

    mkdir($argv[1].'/Controller');
    copy($location.'/Controller/IndexController.php', $argv[1].'/Controller/IndexController.php');

    mkdir($argv[1].'/Core');
    copy($location.'/Core/Controller.php', $argv[1].'/Core/Controller.php');
    copy($location.'/Core/PageUtils.php', $argv[1].'/Core/PageUtils.php');
    copy($location.'/Core/Request.php', $argv[1].'/Core/Request.php');
    copy($location.'/Core/Router.php', $argv[1].'/Core/Router.php');

    mkdir($argv[1].'/Core/Data');
    copy($location.'/Core/Data/ConnectionStringProducer.php', $argv[1].'/Core/Data/ConnectionStringProducer.php');
    copy($location.'/Core/Data/DataObject.php', $argv[1].'/Core/Data/DataObject.php');
    copy($location.'/Core/Data/SqlDataBase.php', $argv[1].'/Core/Data/SqlDataBase.php');
    copy($location.'/Core/Data/SqlDatabaseQueryBuilder.php', $argv[1].'/Core/Data/SqlDatabaseQueryBuilder.php');
    copy($location.'/Core/Data/SqlTable.php', $argv[1].'/Core/Data/SqlTable.php');
    copy($location.'/Core/Data/SqlTableCreator.php', $argv[1].'/Core/Data/SqlTableCreator.php');

    mkdir($argv[1].'/Middleware');
    mkdir($argv[1].'/Models');
    copy($location.'/Models/User.php', $argv[1].'/Models/User.php');

    mkdir($argv[1].'/views');
    copy($location.'/views/base.php', $argv[1].'/views/base.php');
    copy($location.'/views/error.php', $argv[1].'/views/error.php');

    copy($location.'/index.php', $argv[1].'/index.php');
    copy($location.'/.htaccess', $argv[1].'/.htaccess');
    copy($location.'/composer.json', $argv[1].'/composer.json');
    copy($location.'/Readme.md', $argv[1].'/Readme.md');
