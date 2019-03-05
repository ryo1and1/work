<?php
date_default_timezone_set('Asia/Tokyo');

mb_language("Japanese"); 
mb_internal_encoding("UTF-8");

//MySQLにデータを登録
define('DB_DATABASE', 'work2_users');
define('DB_USERNAME', 'basic');
define('DB_PASSWORD', 'Basic-pass1');
define('DB_DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

$yourname = $_POST['yourname'];
$email = $_POST['email'];
$password = $_POST['password'];

$error = [];
if ($yourname == "") {
    $error['yourname'] = '名前が入力されていません';
}
if ($email == "") {
    $error['email'] = 'メールアドレスが入力されていません';
}
if ($password == "") {
    $error['password'] = 'パスワードが入力されていません';
}
if (count(array_keys($error))>0) {
    //エラー処理
    echo "不正なアクセスを検知しました";
    exit();
}

if (!empty($yourname) && !empty($email) && !empty($password)) {
   
    // 2. ユーザIDとパスワードが入力されていたら認証する
    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', 'localhost', 'work2_users');
    // 3. エラー処理
    try {
        $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare("INSERT INTO work2_users(username, email, password) VALUES (?, ?, ?)");
        $stmt->execute(array($yourname,$email,password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
        $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる
        //$signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
    } catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    }
} 

// 変数とタイムゾーンを初期化
$header = null;
$auto_reply_subject = null;
$auto_reply_text = null;
$admin_reply_subject = null;
$admin_reply_text = null;


// ヘッダー情報を設定

$header = "From: work <ryo1and1@yahoo.co.jp>\n";
$header .= "Reply-To: GRAYCODE <ryo1and1@yahoo.co.jp>\n";

// 件名を設定
$auto_reply_subject = 'お問い合わせありがとうございます。';

// 本文を設定
$auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。\n\n";
$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
$auto_reply_text .= "氏名：" . $_POST['yourname'] . "\n";
$auto_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";
$auto_reply_text .= "内容：" . $_POST['password'] . "\n\n";


mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

// 運営側へ送るメールの件名
$admin_reply_subject = "お問い合わせを受け付けました";

// 本文を設定
$admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
$admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
$admin_reply_text .= "氏名：" . $_POST['yourname'] . "\n";
$admin_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";
$admin_reply_text .= "内容：" . $_POST['password'] . "\n\n";

// 運営側へメール送信
mb_send_mail('ryo1and1@yahoo.co.jp', $admin_reply_subject, $admin_reply_text, $header);

header("Location:complete.php");
exit();
?>