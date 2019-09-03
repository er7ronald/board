<?php
session_start();

if (!isset($_SESSION["USERID"])) {
header("Location: login.php");
exit;

}



$host = 'localhost:8889';
    $dbname = 'register_func';
    $dbuser = 'root';
    $dbpassword = 'root';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8","$dbuser","$dbpassword");
    
    if( isset($_POST['regist']) ){
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $stmt = $pdo -> prepare("INSERT INTO board (name, comment) VALUES (:name, :comment)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
        $pdo->query($stmt);
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    
    $sql = "SELECT * FROM board ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    foreach ($stmt as $row) {
        echo htmlspecialchars($row['name'], ENT_QUOTES|ENT_HTML5).' '.htmlspecialchars($row['comment'], ENT_QUOTES|ENT_HTML5);
        echo '<br>';
    }


?>
<!DOCTYPE html>
<html>
<head>
<title>メインページ</title>
</head>
<body>
<div>
<form method="post" action="main.php">
        <input type="text" name="name" value="">
        <input type="text" name="comment" value="">
        <input type="submit" name="regist" value="登録">
    </form>
</div>
<main>
<p>メイン</p>
<a href="logout.php">ログアウト</a>
</main>
</body>
</html>