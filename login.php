<?php
// セッション開始
session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION["USERID"])) {
header('Location: main.php');
exit;
}
$db['host'] = 'localhost';
$db['user'] = 'root';
$db['pass'] = 'root';
$db['dbname'] = 'register_func';
$error = '';
// ログインボタンが押されたら
if (isset($_POST['login'])) {
if (empty($_POST['username'])) {
$error = 'ユーザーIDが未入力です。';
} else if (empty($_POST['password'])) {
$error = 'パスワードが未入力です。';
}
if (!empty($_POST['username']) && !empty($_POST['password'])) {
$username = $_POST['username'];
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
try {
$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
$stmt = $pdo->prepare('SELECT * FROM user WHERE name = ?');
$stmt->execute(array($username));
$password = $_POST['password'];
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (password_verify($password, $result['password'])) {
$_SESSION['USERID'] = $username;
header('Location: main.php');
exit();
} else {
$error = 'ユーザーIDあるいはパスワードに誤りがあります。';
}
} catch (PDOException $e) {
echo $e->getMessage();
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ログイン</title>
</head>
<body>
<main>
<form id="loginForm" name="loginForm" action="" method="POST">
<p style="color:red;"><?php echo $error ?></p>
<br>
<label for="username">ユーザーID<br>
<input type="text" id="username" name="username" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
</label><br>
<label for="password">パスワード<br>
<input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
</label>
<input type="submit" id="login" name="login" value="ログイン">
</form>
<p><a href="register.php">新規登録はこちら</a></p>
</main>
</body>
</html>