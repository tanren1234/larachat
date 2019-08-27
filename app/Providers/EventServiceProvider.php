<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen('laravels.received_request', function (\Illuminate\Http\Request $req, $app) {
            //$req->query->set('get_key', 'hhxsv5');// 修改querystring
            $req->request->set('post_key', 'hhxsv5'); // 修改post body
            dump($req->all());
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM1MzYzNzcxYTY5NTcyN2MxYjA1YjM1ZjVlMjczNGFkNjQ3NzFhZWJhY2Y3ZmJkNTJjMTc0NTc1ZDRlY2MzNmEwOTc2NjdkNWRhYzRkM2Q3In0.eyJhdWQiOiIyIiwianRpIjoiMzUzNjM3NzFhNjk1NzI3YzFiMDViMzVmNWUyNzM0YWQ2NDc3MWFlYmFjZjdmYmQ1MmMxNzQ1NzVkNGVjYzM2YTA5NzY2N2Q1ZGFjNGQzZDciLCJpYXQiOjE1NDc5NzM1NjcsIm5iZiI6MTU0Nzk3MzU2NywiZXhwIjoxNTQ4NTc4MzY3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.3Eo5EMouBZ65JCwVvipbBm6H3ksWSh7_R30l5oLjMk6ktQ6QbOTFiDJ2AtaMhE44FU2Y9jL7xt4pTvkMG3jwpYUaSH0n8AXfYv0OOwhr-4Bl84gQKhu8X3JirjqrZKaCBy0p_bS-a5qZcNwPfc9MRlBxp1HV5m9ISo4dIRvSLk_EapCcTLv_U3E97iLkiitEFCBNvHLsv2sUYjeJpzb2-F5VahEzo4EKnFCqGok3wkkKIrUGNeSQU17vlcS9D_CXnf8YQITXj4F9WWHDR9ZxujDdebM2TiZFLH6KAkmNBQ0o11WFmG7hICGOJ0GNmOUw8Blps-14LsQa61Zd9w9TwA899QLP36qFV5kOubXoCoi2l-hDeLmpJPmc5IRq-oPO_Nx8470WPBrex7AXAnEKf6DKyLXtHDlQv0yM1OCyb5G-hv2zwRfayHurwvx6jvif4MWOIvCvhJw_xDok8s3SGdJu5y5TXAKVTTN5AZJ7aVYrjXEzcTBt67uanL-9k-w_QZqUIjlueWcck5PvBkjy01EKuqV_Dh7vPEzIHSg7RXuxEkliJ8RVRvWk7rAjZhrOW-HrKQNKQxE4J-NZu7isDrEBuzJkgGwP-fmxSkzb2w4zskCTT9lQvBEwFcytKvL8kEhmnvySuKizMewQu1ArHjZLn_hscUDlXsl9AVIFEfU';
            $req->headers->set('Authorization','Bearer '.$token);
            $req->headers->set('Accept','application/json');
        });
        //
        Event::listen('laravels.generated_response', function (\Illuminate\Http\Request $req, \Symfony\Component\HttpFoundation\Response $rsp, $app) {
            $rsp->headers->set('header-key', 'hhxsv5');// 修改header
        });
    }
}
