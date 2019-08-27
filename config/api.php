<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 16:23
 */
$environment = env('APP_ENV', "local");
switch ($environment){
    case "local":
        $api = include "api_config/local.php";
        break;
    case "test":
        $api = include "api_config/test.php";
        break;
    case "production":
        $api = include "api_config/production.php";
        break;
    default:
        $api = include "api_config/local.php";

}
return $api;