<?php
$yourname = $_POST['yourname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];


session_start();
if (isset($_SESSION['USERID'])) {
    header('Location:home.php');
    exit;
    }
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="confirm.php" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <label for="username">ユーザー名</label>
                <input type="text" name="yourname" placeholder="ユーザー名を入力" value="<?php echo $username; ?>">
                <?php if (isset($error['yourname'])) { ?>
                <div style = "color:red;"><?php echo $error['yourname']; ?></div>
                <?php } ?>
                <br>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" placeholder="メールアドレスを入力" value="<?php echo $email; ?>">
                <?php if (isset($error['email'])) { ?>
                <div style = "color:red;"><?php echo $error['email']; ?></div>
                <?php } ?>
                <br>
                <label for="password">パスワード</label><input type="password" name="password" placeholder="パスワードを入力" value="<?php echo $password; ?>">
                <?php if (isset($error['password'])) { ?>
                <div style = "color:red;"><?php echo $error['password']; ?></div>
                <?php } ?>
                <br>
                <label for="password2">パスワード(確認用)</label><input type="password" name="password2" placeholder="再度パスワードを入力" value="<?php echo $password2; ?>">
                <?php if (isset($error['password'])) { ?>
                <div style = "color:red;"><?php echo $error['password2']; ?></div>
                <?php } ?>                
                <br>
                <?php if (isset($error['differentpassword'])) { ?>
                <div style = "color:red;"><?php echo $error['differentpassword']; ?></div>
                <?php } ?>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="login.php">
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>