<?php
var_dump($_POST);

// 変数の初期化
$page_flag = 0;
if( !empty($_POST['btn_confirm']) ) {
	$page_flag = 1;
}elseif( !empty($_POST['btn_submit']) ) {
	$page_flag = 2;
}
?>

<!DOCTYPE>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お問い合わせフォーム</title>
<style rel="stylesheet" type="text/css">

</style>
</head>
<body>
<h1>お問い合わせフォーム</h1>
<?php if( $page_flag === 1 ): ?>

<form method="post" action="">
	<div class="element_wrap">
		<label>氏名</label><br>
		<p><?php echo $_POST['your_name']; ?></p>
	</div>
	<div class="element_wrap">
		<label>メールアドレス</label><br>
		<p><?php echo $_POST['email']; ?></p>
	</div>
	<div class="element_wrap">
		<label>お問い合わせ内容</label><br>
		<p><?php echo $_POST['text']; ?></p>
	</div>
	<input type="submit" name="btn_back" value="戻る">
	<input type="submit" name="btn_submit" value="送信">
	<input type="hidden" name="your_name" value="<?php echo $_POST['your_name']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="hidden" name="text" value="<?php echo $_POST['text']; ?>">
</form>

<?php elseif( $page_flag === 2 ): ?>

<p>送信が完了しました。</p>
 
<?php else: ?>

<form method="post" action="">
	<div class="element_wrap">
		<label>氏名</label><br>
		<input type="text" name="your_name" value="">
	</div>
	<div class="element_wrap">
		<label>メールアドレス</label><br>
		<input type="text" name="email" value="">
    </div>
    <div class="element_wrap">
        <label>お問い合わせ内容</label><br>
		<textarea type="text" name="text" value=""></textarea>
	</div>
	<input type="submit" name="btn_confirm" value="入力内容を確認する">
</form>

<?php endif; ?>
</body>
</html>