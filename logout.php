<?php
session_start();
// セッションクリア
session_destroy();
$error = "ログアウトしました。";
?>
<!doctype html>
<html>
<head>
<title>ログアウト</title>
</head>
<body>
<div><?php echo $error; ?></div>
<ul>
<li><a href="login.php">ログインページへ</a></li>
</ul>
</body>
</html>