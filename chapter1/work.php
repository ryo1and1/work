<?php
//var_dump($_POST);

// 変数の初期化
$page_flag = 0;
if( !empty($_POST['btn_confirm']) ) {
	$page_flag = 1;
}elseif( !empty($_POST['btn_submit']) ) {
	$page_flag = 2;

	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	// ヘッダー情報を設定
	
	$header = "From: work <ryo1and1@yahoo.co.jp>\n";
	$header .= "Reply-To: GRAYCODE <ryo1and1@yahoo.co.jp>\n";
 
	// 件名を設定
	$auto_reply_subject = 'お問い合わせありがとうございます。';
 
	// 本文を設定
	$auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。\n\n";
	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$auto_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	$auto_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";
	$auto_reply_text .= "内容：" . $_POST['text'] . "\n\n";
	
	// メール送信
	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");
	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

	// 運営側へ送るメールの件名
	$admin_reply_subject = "お問い合わせを受け付けました";
	
	// 本文を設定
	$admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
	$admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$admin_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	$admin_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";
	$admin_reply_text .= "内容：" . $_POST['text'] . "\n\n";
 
	// 運営側へメール送信
	mb_send_mail('ryo1and1@yahoo.co.jp', $admin_reply_subject, $admin_reply_text, $header);

	//MySQLにデータを登録
define('DB_DATABASE', 'work');

define('DB_USERNAME', 'basic');

define('DB_PASSWORD', 'Basic-pass1');

define('DB_DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

try {

    $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

    // エラーが起きた際にExceptionを出力する設定

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // クエリ実行

    $statement = $db->prepare("INSERT INTO work1(name, email, text) VALUES(?, ?, ?);");

    $statement->execute([$_POST['your_name'], $_POST['email'], $_POST['text']]);

    echo "Inserted Id : ".$db->lastInsertId();

} catch (PDOException $e) {

    var_dump($e);

    exit;
}
}
?>

<!DOCTYPE>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お問い合わせフォーム</title>
<link rel="stylesheet" href="work.css">
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