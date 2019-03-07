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

include('post.php');
// 渡されたidを受け取る
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
// 受け取ったidのレコードを取得
$sql = "select * from work2_posts where id = ".$id;
?>
<!DOCTYPE html>
<html lang = “ja”>
<head>
<meta charset="utf-8">
<title>コメントページ</title>
</head>
<body>
<?php echo $id ?>
</body>
</html>