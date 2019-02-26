<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["USERID"])) {
header("Location:login.php");
exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>メインページ</title>
</head>
<body>
<main>
<p>メイン</p>
<a href="logout.php">ログアウト</a>
</main>
</body>
</html>