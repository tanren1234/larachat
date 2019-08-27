<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8 0008
 * Time: 21:20
 */
if (!function_exists('generateNumber'))
{
    function generateNumber()
    {
        $count = \App\User::count();

        return 'fafawlp' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}