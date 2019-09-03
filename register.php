<?php

session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION['USERID'])) {
header('Location: main.php');
exit;
}
$db['host'] = 'localhost';
$db['user'] = 'root';
$db['pass'] = 'root';
$db['dbname'] = 'register_func';
$error = '';

if (isset($_POST['signUp'])) {
if (empty($_POST['username'])) {
$error = 'ユーザーIDが未入力です。';
}else if (empty($_POST['password'])) {
$error = 'パスワードが未入力です。';
}
if (!empty($_POST['username']) && !empty($_POST['password'])) {
$username = $_POST['username'];
$password = $_POST['password'];
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

function cheak($id,$count){
if($count > 0){
throw new Exception('そのユーザーIDは既に使用されています。');
}
if ($id < 8) {
throw new Exception('パスワードは8桁以上で入力してください。');
}
}
try{
$sqlname = "SELECT COUNT(*) FROM user WHERE `name` = '$username'";
$ss = $pdo->query($sqlname);
$count = $ss->fetchColumn();
$id = strlen($_POST['password']);
cheak($id,$count);
$stmt = $pdo->prepare('INSERT INTO `user`(`name`, `password`) VALUES (:username, :password)');
$pass = password_hash($password, PASSWORD_DEFAULT);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $pass, PDO::PARAM_STR);
$stmt->execute();
$_SESSION['USERID'] = $username;
echo '<script>
alert("登録が完了しました。");
location.href="main.php";
</script>';
} catch(Exception $e){
$error = $e->getMessage();
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>新規登録</title>
</head>
<body>
<main>
<form id="loginForm" name="loginForm" action="register.php" method="POST">
<p style="color:red;"><?php echo $error ?></p>
<label for="username">ユーザーID<br>
<input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
</label><br>
<label for="password">パスワード<br>
<input type="password" id="password" name="password" value="" placeholder="パスワードを入力">※8桁以上
</label>
<input type="submit" id="signUp" name="signUp" value="新規登録" class="btn up">
</form>
</main>
</body>
</html>