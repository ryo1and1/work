<?php
$file = "./number.php";
$fp = fopen ( $file,"r" );
$now = fgets ( $fp );
fclose ( $fp );
$now ++;
$fp = fopen ( $file, "w" );
fputs ( $fp, $now );
fclose ( $fp );
// "/test/index.php"は自分の環境に合わせる
header ( "Location:post.php" );
exit;
?>