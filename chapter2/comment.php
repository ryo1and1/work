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
$id = $_POST['id'];

if (!empty($id)){
    if( isset($_POST['post'])){   
        $stmt = $pdo->prepare("INSERT INTO work2_comments(name, comments, posts_id) VALUES (?, ?, ?)");
        $stmt->execute(array($name,$comments,$id));
        $pdo->query($stmt);
            header("Location: " . $_SERVER['PHP_SELF']);
    } 
}

?>
<!DOCTYPE html>
<html lang = “ja”>
<head>
<meta charset="utf-8">
<title>コメントページ</title>
</head>
<body>
<form action="" method="post">
お名前: <input type="text" name="name"><br>
<textarea type="text" name="comments" cols="60" rows="5"></textarea><br>
<input type="submit" name="post" value="送信">
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
</form>
<?php $sql = "SELECT work2_posts.name, work2_posts.title, work2_posts.contents, work2_comments.name, work2_comments.comments 
from work2_posts,work2_comments where work2_posts.id = work2_comments.posts_id;" ?>
    <?php $stmt = $pdo->query($sql); ?>
    <?php foreach ($stmt as $row) { ?>
        <?php echo htmlspecialchars($row['id'], ENT_QUOTES|ENT_HTML5) ?><br>
        お名前:<?php echo htmlspecialchars($row['name'], ENT_QUOTES|ENT_HTML5) ?><br>
        内容:<?php echo htmlspecialchars($row['comments'], ENT_QUOTES|ENT_HTML5)?><br>
    <?php } ?>
</body>
</html>