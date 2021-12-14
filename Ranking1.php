<?php 

include('_header.php');
$cnt = 0;

?>
      <div class="text-white">
        <div align="center">
        <p class="display-5">ランキング表(TOP10)</p>
      </div>

      <div class="col-15 ml-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-white">順位</th>
                    <th class="text-white">ユーザー</th>
                    <th class="text-white">スコア</th>
                </tr>
            </thead>
            <tbody>

<?php
  // Herokuサーバー接続用
  $dbinfo = parse_url(getenv('DATABASE_URL'));
  $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
  $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

// DBに接続するためのユーザー名やパスワードを指定
//        $dsn = 'pgsql:dbname=sampledb;host=myapp-db';
//        $db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

  // SELECT文を変数に格納（上位１０名のみを表示する）
  $sql = "SELECT username, score FROM users ORDER BY score DESC LIMIT 10";
//$sql = "SELECT username, score FROM users ORDER BY score DESC";

  // SQLステートメントを実行し、結果を変数に格納
  $stmt = $db->query($sql);
  
  // foreach文で配列の中身を一行ずつ出力
  foreach ($stmt as $row) {

    $cnt++; // データが取得できた件数だけ、順位をカウントする。

    echo '<tr>';
    echo '<td class="text-white">'.$cnt.'</td>';
    echo '<td class="text-white">'.$row['username'].'</td>';
    echo '<td class="text-white">'.$row['score'].'</td>';
    echo '</tr>';
    
  }
?>

            </tbody>
          </table>
        </div>
      </div>
    

    <?php 
include('_footer.php');