<?php
//		$db = new PDO('mysql:host=localhost; dbname=データベース名','ユーザー名','パスワード');
// Herokuサーバー接続用
$dbinfo = parse_url(getenv('DATABASE_URL'));
$dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
$db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

// DBに接続するためのユーザー名やパスワードを指定
//        $dsn = 'pgsql:dbname=sampledb;host=myapp-db';
//        $db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

$sql = 'SELECT * FROM users';
echo '<pre>';
foreach ($db->query($sql) as $row) {
  var_dump($row);
}
echo '</pre>';
?>
	<br/>
  <a href="index.php">トップページ</a>
