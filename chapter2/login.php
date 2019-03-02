<?php
// データベース名の定義
define('DB_DATABASE', 'work2_users');
// データベースユーザー名の定義
define('DB_USERNAME', 'basic');
// データベースユーザーの接続パスワードの定義
define('DB_PASSWORD', 'Basic-pass1');
// DSN（データソースネーム）の定義
define('DB_DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION["USERNAME"])) {
    header('Location:home.php');
    exit;
    }
$errorMessage[] = "";
// ログインボタンが押された場合[\]
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($username)) {  // emptyは値が空のとき
        $errorMessage['yourname'] = 'ユーザー名が未入力です。';
    } else if (empty($email)) {
        $errorMessage['email'] = 'メールアドレスが未入力です。';
    } else if (empty($password)) {
        $errorMessage['password'] = 'パスワードが未入力です。';
    }
    
    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
               

        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', 'localhost', 'work2_users');
        try {
            $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $stmt = $pdo->prepare('SELECT * FROM work2_users WHERE username = ? and email = ? and password = ?');
            $stmt->execute(array($username,$email,$password));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password'])) {
            $_SESSION['USERNAME'] = $username;
            header('Location:home.php');
            exit();
            } else {
            $errorMessage['different'] = 'ユーザー名、メールアドレスあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage['database'] = 'データベースエラー';
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
        <form name="loginForm" action="home.php" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <label for="yourname">ユーザー名</label>
                <input type="text" name="yourname" placeholder="ユーザー名を入力" value="<?php echo $username; ?>">
                <?php if (isset($errorMessage['yourname'])) { ?>
                <div style = "color:red;"><?php echo $errorMessage['yourname']; ?></div>
                <?php } ?>
                <br>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" placeholder="メールアドレスを入力" value="<?php echo $email; ?>">
                <?php if (isset($errorMessage['email'])) { ?>
                <div style = "color:red;"><?php echo $errorMessage['email']; ?></div>
                <?php } ?>
                <br>
                <label for="password">パスワード</label><input type="password" name="password" placeholder="パスワードを入力" value="<?php echo $password; ?>">
                <?php if (isset($errorMessage['password'])) { ?>
                <div style = "color:red;"><?php echo $errorMessage['password']; ?></div>
                <?php } ?>
                <br>
                <input type="submit" name="login" value="ログイン">
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