<?php
    $host = 'localhost:8889';
    $dbname = 'register_func';
    $dbuser = 'root';
    $dbpassword = 'root';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8","$dbuser","$dbpassword");
    #データベースへの登録
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
    #テーブル内容の表示
    $sql = "SELECT * FROM user ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    foreach ($stmt as $row) {
        echo htmlspecialchars($row['name'], ENT_QUOTES|ENT_HTML5).' '.htmlspecialchars($row['comment'], ENT_QUOTES|ENT_HTML5);
        echo '<br>';
    }
?>


<!DOCTYPE HTML>
<html lang="ja">

<head>
</head>

<body>
    <form method="post" action="">
        <input type="text" name="name" value="">
        <input type="text" name="comment" value="">
        <input type="submit" name="regist" value="登録">
    </form>
</body>
<?php
?>
</html>