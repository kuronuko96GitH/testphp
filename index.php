<?
echo 'phpのテストです。<br>';

$dbinfo = parse_url(getenv('DATABASE_URL'));

$dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);

$pdo = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);
var_dump($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));

echo '$dbinfo_host：'.$dbinfo['host'];
echo '$dbinfo_path：'.$dbinfo['path'];

echo '$dbinfo_user：'.$dbinfo['user'];
echo '$dbinfo_pass：'.$dbinfo['pass'];


phpinfo();
?>