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


