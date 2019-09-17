<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/11
 * Time: 12:17
 */
class ChatFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'chat';
    }
}
