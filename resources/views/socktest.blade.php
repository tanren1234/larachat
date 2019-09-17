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
    var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU0MDVkNDRkYjgxNWRhZjA4MTYzMzJhMzFlNTA0OTJmMDU4NjBhYTYxYjJhZGRlNDY4YTA3Y2I0Nzc0NjM2YjQwNzRlODIyZmI5MTA1MTRkIn0.eyJhdWQiOiIyIiwianRpIjoiZTQwNWQ0NGRiODE1ZGFmMDgxNjMzMmEzMWU1MDQ5MmYw' +
        'NTg2MGFhNjFiMmFkZGU0NjhhMDdjYjQ3NzQ2MzZiNDA3NGU4MjJmYjkxMDUxNGQiLCJpYXQiOjE1NjgwMjIxMjAsIm5iZiI6MTU2ODAyMjEyMCwiZXhwIjoxNTY4MDIyMjQwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.eHpyoJkdHSNmkojwMcS86YVgqE1ciwaETp3G8R-6mHJk7orOLvtZa-jzbGuEjKZVwl2hUJy3WwgrMpQsnvyhoP0YprUkZj0sGSzdkiZGZVwyumUBNhqa57H4cDxP0BkhftoXm4p0SEA_9nBt2PyKDle3fdnEY9xFJORoPUG4-F81LftPmZbh1gtWJ_177Q' +
        '-Sdnj0u_mM9dtsw9btY4CbZWhD5JmIfEhH3qxPNYhxTY31QRrZfMmjtuHnV3fVR_HVm1MpP9S6Ed-' +
        'kdDYPuMSa5hbWFjmyH0vsLvSm4c9hsBNscU5Zj2TcRA1VSf3wLGdXEMSNCKg1xOoMSfZgquLH2sRi6198XsUPPQ2kEcUmck2ldkrwINewh2fBckV5B7RLvrIAL' +
        'qF6397rG9EG-hoaqYg-cEAfVPqQFmT4xS8Gs7Pgw-LBV7TTMYJzRtEaAryZp7dkq9Ta_ZRwu2faDhmwH7A7m2wftFLPPjZTyHdE45pslIG77VsS5PYMETLqwiDNSc5GtGo1iOEEhQF_BZmtSDkX76m5LJePLErB9C0z8Bl90bAeRQQz4RG8DcSGwnh7K1EebKJVk1GGfGDt9ObJ2VYwkJVHuf8o_26_RJou69Fy51Oii2dOCGlUoFf85dZwl2ekKNNXcnT1uqhOdwI7hZCyNPLCSyDh2EC3jfHe1f4';
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
