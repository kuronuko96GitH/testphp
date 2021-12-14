<?php
// ユーザー名やパスワードなどは、
// 後ほど紹介する docker-compose.yml と併せて適宜変更してください
$dsn = 'pgsql:dbname=sampledb;host=myapp-db';
$db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

$sql = 'SELECT * FROM users';
echo '<pre>';
foreach ($db->query($sql) as $row) {
  var_dump($row);
}
echo '</pre>';
?>
	<br/>
  <a href="index.php">トップページ</a>
