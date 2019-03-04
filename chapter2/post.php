<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["USERNAME"])) {
header("Location:login.php");
exit;
}

$yourname = $_POST['yourname'];
$text = $_POST['text'];
$dataFile = 'bbs.dat';

function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8')
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($yourname) &&
    isset($text)){
    

        if ($text !== ''){
            $yourname = ($yourname === '') ? 'ななしさん' : $yourname;
            
            $yourname = str_replace("\t", ' ', $yourname);
            $text = str_replace("\t", ' ', $text);

            $postedAt = date('Y-m-d H:i:s');

            $newData = $yourname . "\t" . $text . "\t" .$postedAt . "\n";

            $fp = fopen($dataFile, 'a');
            fwrite($fp,$newData);
            fclose($fp);
        }
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);
$posts = array_reverse($posts);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>投稿ページ</title>
</head>
<body>
<h1>掲示板</h1>
<section>
    <h1>新規投稿</h1>
    <form action="" method="post">
        <label>名前</label><br>
        <input type="text" name="yourname" value="<?php echo $yourname; ?>"><br>
        <label>本文</label><br> 
        <input type="text" name="text" value=""><br>
        <button type="submit">投稿</button>
    </form>
</section>
<section>
    <h2>投稿一覧 (<?php echo count($posts); ?>件)</h2>
    <ul>
    <?php if (count($posts)) : ?>
    <?php foreach ($posts as $post) : ?>
    <?php lists($yourname, $postedAt) = explode("\t", $post); ?>
        <li><?php echo h($yourname); ?><br>
        <?php echo h($text); ?><br>
        <?php echo h($postedAt); ?> 
        </li>
    <?php endforeach; ?>
    <?php else : ?>
        <p>投稿はまだありません</p>
    <?php endif; ?>
    </ul>
</section>
</body>
</html>