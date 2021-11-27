<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{$templateWebPath}css/main.css" type="text/css"/>

    <title>Document</title>
</head>
<body>



<div class="adminloginBox">
    <div class="adminMenuCaption">Вход в админку</div>
    <input type="text" class="adminEmail" name="adminEmail" value="" placeholder="Email"/><br>
    <input type="password" class="adminPass" name="adminPass" value="" placeholder="Password"/><br>
    <input type="button" onclick="adminLogin();" value="Войти"/><br>
</div>




<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="{$templateWebPath}js/admin.js"></script>


</body>
</html>