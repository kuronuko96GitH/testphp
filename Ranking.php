<?php 

include('_header.php');
$cnt = 0;

?>
<header class="masthead">
  <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
    <div class="d-flex justify-content-center">

      <div class="text-white">
        <div align="center">
        <p class="display-5">ランキング表</p>
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

//  // SELECT文を変数に格納(件数を取得する)
//  $sql = "SELECT count(*) FROM users";
//
//  // SQLステートメントを実行し、結果を変数に格納
//  $stmt = $db->query($sql);
//  // fetchColumn()…１レコードを取り出しつつ、１カラムだけ取り出す処理。
//  $ranking_cnt = $stmt->fetchColumn(); // 取得したデータの総件数


  // 件数を取得する
  $sql = "SELECT count(*) FROM games WHERE gamecode = :game_code";

  // SQLステートメントを実行し、結果を変数に格納  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":game_code", $_GET['game_code'], PDO::PARAM_INT);
  $stmt->execute();

  // fetchColumn()…１レコードを取り出しつつ、１カラムだけ取り出す処理。
  $ranking_cnt = $stmt->fetchColumn(); // 取得したデータの総件数



  // 定数を設定
  define('MAXCNT','10'); // 1ページに表示できる最大件数
 
  $max_page = ceil($ranking_cnt / MAXCNT); // トータルページ数（※ceilは小数点を切り捨てる関数）
   
  if(!isset($_GET['page_id'])){ // $_GET['page_id'] はURLに渡された現在のページ数
      $now = 1; // 設定されてない場合は1ページ目にする
  }else{
      $now = $_GET['page_id'];
  }
   
  $start_no = ($now - 1) * MAXCNT; // 配列の何番目から取得すればよいか
  $cnt = $start_no;
 
  // SELECT文を変数に格納（上位１０名のみを表示する）
//  $sql = "SELECT username, score FROM users ORDER BY score DESC LIMIT 10 offset :limitcnt";
//  $sql = "SELECT username, score FROM games WHERE gamecode = :game_code ORDER BY score DESC LIMIT 10 offset :limitcnt";
    $sql = "SELECT users.username, games.score FROM users, games WHERE users.id = games.user_id and games.gamecode = :game_code ORDER BY games.score DESC LIMIT 10 offset :limitcnt";

  // SQLステートメントを実行し、結果を変数に格納  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":game_code", $_GET['game_code'], PDO::PARAM_INT);
  $stmt->bindValue(":limitcnt", $start_no, PDO::PARAM_INT);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $db = null;


  // foreach文で配列の中身を一行ずつ出力
  foreach ($result as $row) {

    $cnt++; // データが取得できた件数だけ、順位をカウントする。

    echo '<tr>';

    if($_SESSION['username'] === $row['username']) {
      // ランキング表にログインユーザーがいた場合、背景色を変える。
      echo '<td class="text-white bg-secondary">'.$cnt.'</td>';
      echo '<td class="text-white bg-secondary">'.$row['username'].'</td>';
      echo '<td class="text-white bg-secondary">'.$row['score'].'</td>';

    } else {
      echo '<td class="text-white">'.$cnt.'</td>';
      echo '<td class="text-white">'.$row['username'].'</td>';
      echo '<td class="text-white">'.$row['score'].'</td>';
    }

    echo '</tr>';
    
  }
?>

          </tbody>
        </table>
      </div>

      <h3>
        <?php for ($x=1; $x <= $max_page; $x++) {
          // ページ数を表示する。
        ?> 
          <a href="?game_code=<?php echo $_GET['game_code'] ?>&page_id=<?php echo $x ?>"><?php echo $x; ?></a>
        <?php } ?>
      </h3>

    </div>
  </div>
</header>

<?php 
include('_footer.php');