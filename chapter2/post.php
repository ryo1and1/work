<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["USERNAME"])) {
header("Location:login.php");
exit;
}

//MySQLにデータを登録
define('DB_DATABASE', 'work2_users');
define('DB_USERNAME', 'basic');
define('DB_PASSWORD', 'Basic-pass1');
define('DB_DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);
$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$name = $_POST['name'];
$title = $_POST['title'];
$contents = $_POST['contents'];

if( isset($_POST['write'])){   
      $stmt = $pdo->prepare("INSERT INTO work2_posts(name, title, contents) VALUES (?, ?, ?)");
      $stmt->execute(array($name,$title,$contents));
      $pdo->query($stmt);
        header("Location: post.php" . $_SERVER['PHP_SELF']);
} 


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板</title>
</head>
<body>
<form action="" method="post">
お名前: <input type="text" name="name"><br>
題名: <input type="text" name="title"><br>
<textarea type="text" name="contents" cols="60" rows="5"></textarea><br>
<input type="submit" name="write" value="送信">
</form>
<a href="home.php">マイページ</a>
<hr>
<?php $sql = "SELECT * FROM work2_posts ORDER BY id DESC"; ?>
    <?php $stmt = $pdo->query($sql); ?>
    <?php foreach ($stmt as $row) { ?>
        <?php echo htmlspecialchars($row['id'], ENT_QUOTES|ENT_HTML5) ?><br>
        お名前:<?php echo htmlspecialchars($row['name'], ENT_QUOTES|ENT_HTML5) ?><br>
        題名:<?php echo htmlspecialchars($row['title'], ENT_QUOTES|ENT_HTML5) ?><br>
        内容:<?php echo htmlspecialchars($row['contents'], ENT_QUOTES|ENT_HTML5)?><br>
    <?php } ?>
<hr>
</body>
</html>