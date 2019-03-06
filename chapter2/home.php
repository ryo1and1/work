<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["USERNAME"])) {
header("Location:login.php");
exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>マイページ</title>
</head>
<body>
<main>
<h1>マイページ</h1>
<a href="post.php">投稿</a>
<a href="logout.php">ログアウト</a>
</main>
</body>
</html>