<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
Welcome<br/><input id="text" type="text"/>
<button onclick="send()">发送消息</button>
<hr/>
<button onclick="closeWebSocket()">关闭WebSocket连接</button>
<hr/>
<div id="message"></div>
</body>
<script>
    var websocket = null;
    var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhlNjI5NDA1OTI0YWNlNDRlYzRhMWJlZGFiYWE1ZDhkMmViNzExYTExYjAzNDQ0OTA5NGY5OGExOTIxMjM3MTNiZWRlYjIwOGZhNGMyZDM0In0.eyJhdWQiOiIyIiwianRpIjoiOGU2Mjk0MDU5MjRhY2U0NGVjNGExYmVkYWJhYTVkOGQyZWI3MTFhMTFiMDM0NDQ5MDk0Zjk4YTE5MjEyMzcxM2JlZGViMjA4ZmE0YzJkMzQiLCJpYXQiOjE1Njg5Njc1NjIsIm5iZiI6MTU2ODk2NzU2MiwiZXhwIjoxNTY5NTcxODIwLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.SwkGGBjA25oDWD0ad2wHF9chapzXuJwBGEO8ybqPnwEfV2mNq9luc_a5Phq68shu4oKFjkj35L7IMBa03qAszbXOSfuGAH3h2qyaqFg4Ivh5ORTQ6Pd5lNo7eXBNFVH1d5kDtRMdQWnpDg-O0-kUhQnhcHPCYBQNObT3iMuBOuTXTkbwNjd8gE6c7rIBCVYsYACno8eg6ZVDA7FlTDKyERYWjcI45_LwXknedM3u_3KBnXzeREmUcH0kNAj1cRoeieD4R3UB2peD5Kw3LNMdcj5Ou2L4cgwMq0CKShDC4Sd2esTBvWh1JFKqhYWwzSR-saHNW6jGn3JXGnZU6jRqlgff5poaWTfG0XRfQfu7zCS2A8RjtzcLdW8VH1J07WXBdZLABVVALF_Ai6sVsRC9K5sMDmHCkP2Ks8VKbogNL8Vby4Ec8GDTae15hWJdVJ6OvUrtPhcb-i1Ax_oxQBIXfx7lplOcYzPVv7DgL-LhwWwoT2sZab4BG5vMQ5PNmF9QXLpDjfSqsdiMWw_h-AQDpmo8zARpsycNFzXe6UgzpnhWhm2fykgPJmR6nrfgnjD-8Gr9OZpUbhBK_mFzHTRH6MUQj-VrhA9YItriQcyD3_CiRp1CUgQmJOFJVC5nKHdU-XXJnEUUHsVNCXUoAwS-00HY_lBib9sbJX1BYIww4TU';
    //判断当前浏览器是否支持WebSocket
    if ('WebSocket' in window) {
        websocket = new WebSocket("ws://127.0.0.1:8088/ws?token="+token);
    }
    else {
        alert('当前浏览器 Not support websocket')
    }

    //连接发生错误的回调方法
    websocket.onerror = function (evt) {
        console.log(evt);
        setMessageInnerHTML("WebSocket连接发生错误");
    };

    //连接成功建立的回调方法
    websocket.onopen = function (event) {
        setMessageInnerHTML("WebSocket连接成功");
        websocket.send("Hello WebSockets!");
    }

    //接收到消息的回调方法
    websocket.onmessage = function (event) {
        setMessageInnerHTML(event.data);
    }

    //连接关闭的回调方法
    websocket.onclose = function () {
        setMessageInnerHTML("WebSocket连接关闭");
    }

    //监听窗口关闭事件，当窗口关闭时，主动去关闭websocket连接，防止连接还没断开就关闭窗口，server端会抛异常。
    window.onbeforeunload = function () {
        closeWebSocket();
    }

    //将消息显示在网页上
    function setMessageInnerHTML(innerHTML) {
        document.getElementById('message').innerHTML += innerHTML + '<br/>';
    }

    //关闭WebSocket连接
    function closeWebSocket() {
        websocket.close();
    }

    //发送消息
    function send() {
        var message = document.getElementById('text').value;
        websocket.send(message);
    }
</script>

</html>
