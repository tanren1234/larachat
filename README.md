## install

>git clone https://github.com/tanren1234/larachat.git

- cd larachat
- composer install 
- 数据迁移 php artisan migrate
### 启动服务
- php bin/laravels start
- 使用Nginx代理 [docker_php环境](https://github.com/tanren1234/docker_php_env)


### 前端代码
- https://github.com/tanren1234/im_ui


### 修改config/api_config 下porxy_url为nginx容器的ip 
> docker inspect {容器id} | grep IPAddress
- 也可使用当前项目的域名或ip


#### docker内composer killed 说明缓存不够
```
    free -m
    mkdir -p /var/_swap_
    cd /var/_swap_
    #Here, 1M * 2000 ~= 2GB of swap memory
    dd if=/dev/zero of=swapfile bs=1M count=2000
    mkswap swapfile
    swapon swapfile
    echo “/var/_swap_/swapfile none swap sw 0 0” >> /etc/fstab
    #cat /proc/meminfo
    free -m
```

### 跨域
```
laravel 在发起OPTIONS预检请求时候，执行的中间件只有【全局中间件】
修改.env常量APP_CORS_ALLOW_ORIGIN

protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\Cors::class
    ];
```
