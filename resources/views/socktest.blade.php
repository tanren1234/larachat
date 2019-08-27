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
    var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM1MzYzNzcxYTY5NTcyN2MxYjA1YjM1ZjVlMjczNGFkNjQ3NzFhZWJhY2Y3ZmJkNTJjMTc0NTc1ZDRlY2MzNmEwOTc2NjdkNWRhYzRkM2Q3In0.eyJhdWQiOiIyIiwianRpIjoiMzUzNjM3NzFhNjk1NzI3YzFiMDViMzVmNWUyNzM0YWQ2NDc3MWFlYmFjZjdmYmQ1MmMxNzQ1NzVkNGVjYzM2YTA5NzY2N2Q1ZGFjNGQzZDciLCJpYXQiOjE1NDc5NzM1NjcsIm5iZiI6MTU0Nzk3MzU2NywiZXhwIjoxNTQ4NTc4MzY3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.3Eo5EMouBZ65JCwVvipbBm6H3ksWSh7_R30l5oLjMk6ktQ6QbOTFiDJ2AtaMhE44FU2Y9jL7xt4pTvkMG3jwpYUaSH0n8AXfYv0OOwhr-4Bl84gQKhu8X3JirjqrZKaCBy0p_bS-a5qZcNwPfc9MRlBxp1HV5m9ISo4dIRvSLk_EapCcTLv_U3E97iLkiitEFCBNvHLsv2sUYjeJpzb2-F5VahEzo4EKnFCqGok3wkkKIrUGNeSQU17vlcS9D_CXnf8YQITXj4F9WWHDR9ZxujDdebM2TiZFLH6KAkmNBQ0o11WFmG7hICGOJ0GNmOUw8Blps-14LsQa61Zd9w9TwA899QLP36qFV5kOubXoCoi2l-hDeLmpJPmc5IRq-oPO_Nx8470WPBrex7AXAnEKf6DKyLXtHDlQv0yM1OCyb5G-hv2zwRfayHurwvx6jvif4MWOIvCvhJw_xDok8s3SGdJu5y5TXAKVTTN5AZJ7aVYrjXEzcTBt67uanL-9k-w_QZqUIjlueWcck5PvBkjy01EKuqV_Dh7vPEzIHSg7RXuxEkliJ8RVRvWk7rAjZhrOW-HrKQNKQxE4J-NZu7isDrEBuzJkgGwP-fmxSkzb2w4zskCTT9lQvBEwFcytKvL8kEhmnvySuKizMewQu1ArHjZLn_hscUDlXsl9AVIFEfU';
    //判断当前浏览器是否支持WebSocket
    if ('WebSocket' in window) {
        websocket = new WebSocket("ws://larchat.test/ws?token="+token);
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
    websocket.onopen = function () {
        setMessageInnerHTML("WebSocket连接成功");
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