<?php
// データベース名の定義

define('DB_DATABASE', 'work2_users');

// データベースユーザー名の定義

define('DB_USERNAME', 'basic');

// データベースユーザーの接続パスワードの定義

define('DB_PASSWORD', 'Basic-pass1');

// DSN（データソースネーム）の定義

define('DB_DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION["USERID"])) {
    header('Location:home.php');
    exit;
    }
$errorMessage = "";
// ログインボタンが押された場合[\]
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["email"])) {
        $errorMessage = 'メールアドレスが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        $userid = $_POST["userid"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', 'localhost', 'work2_users');
        try {
            $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $stmt = $pdo->prepare('SELECT * FROM work2_users WHERE name = ?');
            $stmt->execute(array($username));
            $password = $_POST["password"];
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password'])) {
            $_SESSION['USERID'] = $userid;
            header('Location:home.php');
            exit();
            } else {
            $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                <br>
                <label for="email">メールアドレス</label><input type="email" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>
        <form action="register.php">
            <fieldset>          
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>
    </body>
</html>