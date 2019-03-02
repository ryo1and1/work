<?php
$yourname = $_POST['yourname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$error = [];

if ($yourname == "") {
    $error['yourname'] = 'ユーザー名が入力されていません';
}
if ($email == "") {
    $error['email'] = 'メールアドレスが入力されていません';
}
if ($password == "") {
    $error['password'] = 'パスワードが入力されていません';
}
if ($password2 == "") {
    $error['password2'] = 'パスワードが入力されていません';
}
if ($password != $password2) {
    $error['differentpassword'] = 'パスワードが確認用と異なります';
}
if (count(array_keys($error))>0) {
    //エラー処理
    require_once ('register.php');
    exit();
}


?>


<!DOCTYPE>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>会員登録</title>
<link rel="stylesheet" href="work.css">
</head>

<body>
<form method="post" action="process.php">
	<div>
		<label>ユーザー名</label><br>
		<p><?php echo $yourname; ?></p>
	</div>
	<div>
		<label>メールアドレス</label><br>
		<p><?php echo $email; ?></p>
	</div>
	<div>
		<label>パスワード</label><br>
		<p><?php echo $password; ?></p>
    </div>
    
	
	<input type="submit" name="btn_submit" value="送信">
	<input type="hidden" name="yourname" value="<?php echo $yourname; ?>">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <input type="hidden" name="password" value="<?php echo $password; ?>">
</form>
<form method="post" action = "register.php">
    <input type="submit" name="btn_back" value="戻る">
    <input type="hidden" name="yourname" value="<?php echo $yourname; ?>">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <input type="hidden" name="password" value="<?php echo $password; ?>">
</body>
</html>