<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["USERNAME"])) {
header("Location:login.php");
exit;
}

  function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
  $rows = json_decode(file_get_contents('bbs.json'), true);
  if (!empty($_POST['write'])) {
    $row = array(
      'name' => $_POST['name'],
      'title' => $_POST['title'],
      'contents' => $_POST['contents'],
      'time' => date("Y/m/d H:i:s")
    );
    array_unshift($rows, $row);
    file_put_contents('bbs.json', json_encode($rows));
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板</title>
</head>
<body>
<form method="post">
お名前: <input name="name"><br>
題名: <input name="title"><br>
<textarea name="contents" cols="60" rows="5"></textarea><br>
<input type="submit" name="write" value="送信">
</form>
<hr>
<?php foreach($rows as $row): ?>
  <strong><?php echo h($row['title']) ?></strong>
  <br><small>投稿者：<?php echo h($row['name']) . ' ' . h($row['time']) ?></small>
  <p><?php echo nl2br(h($row['contents']), false) ?></p>
  <hr>
<?php endforeach ?>
</body>
</html>