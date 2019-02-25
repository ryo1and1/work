<?php
require_once('./core/config.php');
session_start();
if(!isset($_SESSION['user'])) {
	header("Location: login.php");
}
// ユーザーIDからユーザー名を取り出す
$query = "SELECT * FROM work2_users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);
$result = $mysqli->query($query);
if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}
// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
	$username = $row['username'];
	$email = $row['email'];
}
// データベースの切断
$result->close();
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>マイページ</title>
</head>
</head>
<body>
<h1>プロフィール</h1>
<ul>
	<li>名前：<?php echo $username; ?></li>
	<li>メールアドレス：<?php echo $email; ?></li>
</ul>
<a href="logout.php">ログアウト</a>

</body>
</html>