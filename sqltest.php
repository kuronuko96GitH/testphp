テーブル：users
<br/>
<?php
    // Herokuサーバー接続用
    $dbinfo = parse_url(getenv('DATABASE_URL'));
    $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
    $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

    $sql = 'SELECT * FROM users order by id';
    echo '<pre>';
    foreach ($db->query($sql) as $row) {
      var_dump($row);
    }
    echo '</pre>';
?>

	<br/>
	<br/>

テーブル：games
<br/>

<?php
    $sql = 'SELECT * FROM games order by user_id, gamecode';
    echo '<pre>';
    foreach ($db->query($sql) as $row) {
      var_dump($row);
    }
    echo '</pre>';

    $db = null;
?>

  <br/>
  <a href="index.php">トップページ</a>
