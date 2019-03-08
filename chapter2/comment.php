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
$comments = $_POST['comments'];

if( isset($_POST['write'])){   
      $stmt = $pdo->prepare("INSERT INTO work2_comments(name, comments) VALUES (?, ?, ?)");
      $stmt->execute(array($name,$comments));
      $pdo->query($stmt);
        header("Location: comment.php" . $_SERVER['PHP_SELF']);
} 



?>
<!DOCTYPE html>
<html lang = “ja”>
<head>
<meta charset="utf-8">
<title>コメントページ</title>
</head>
<body>
<form action="post.php" method="post">
お名前: <input type="text" name="name"><br>
<textarea type="text" name="comments" cols="60" rows="5"></textarea><br>
<input type="submit" name="write" value="送信">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
</form>
<?php $sql = "SELECT * FROM work2_comments ORDER BY id DESC"; ?>
    <?php $stmt = $pdo->query($sql); ?>
    <?php foreach ($stmt as $row) { ?>
        <?php echo htmlspecialchars($row['id'], ENT_QUOTES|ENT_HTML5) ?><br>
        お名前:<?php echo htmlspecialchars($row['name'], ENT_QUOTES|ENT_HTML5) ?><br>
        内容:<?php echo htmlspecialchars($row['comments'], ENT_QUOTES|ENT_HTML5)?><br>
    <?php } ?>
</body>
</html>