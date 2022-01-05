<?php
include('_header.php');
$result_msg = "";
$err_msg = "";

if ($_SESSION['score'] === null || $_SESSION['score'] === '') {
  // ログインがされてない場合は、セッション情報のスコア（ハイスコアも含む）に０を設定する。
  $_SESSION['score'] = 0;
}
  
if(isset($_POST['UpdScore'])) {

  if (!isset($_SESSION['id'])) {
//  if ($_SESSION['username'] === null || $_SESSION['username'] === '') {
    // ログインがされてない場合
//    $_SESSION['score'] = 0;
    $result_msg = "";
    $err_msg = "ランキングに登録する場合は、ログインをして下さい。";

  } elseif( $_POST['game_score'] <= $_SESSION['score'] ) {
  // 前回のハイスコアを更新できなかった場合は、スコア更新ボタンを押してもエラメッセージを出す。
    $result_msg = "";
    $err_msg = "ハイスコアが更新されてないため、ランキング表に登録できませんでした。";

  } else {
    $result_msg = "";
    $err_msg = "";

//    echo '$_SESSION1:'.$_SESSION['score'];
//    echo '<br/>';

    $username = $_SESSION['username'];
  //  $password = $_POST['password'];
    $_SESSION['score'] = $_POST['game_score'];
    $score = $_POST['game_score'];

    try {

  //    echo 'デバッグ';
  //    echo '<br/>';
//  echo '$_SESSION2:'.$_SESSION['score'];

          // Herokuサーバー接続用
          $dbinfo = parse_url(getenv('DATABASE_URL'));
          $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
          $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

          // タイピングゲームは、ゲームコード『１』のデータを更新する。
          $sql = 'update games set score = ?, updated_at = CURRENT_TIMESTAMP where user_id = ? and gamecode = 1';

          $stmt = $db->prepare($sql);
          $stmt->execute(array($score,$_SESSION['id']));
          $stmt = null;
          $db = null;

          //ログインしている時
          $result_msg = "ランキング表に更新されました。";
          $err_msg = "";

    }catch (PDOException $e){
      echo $e->getMessage();
      exit;
    }

  }
}
?>
<header class="masthead">
  <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
    <div class="d-flex justify-content-center">

            <div class="text-white">
                <div align="center">
                  <p class="display-6">― タイピングゲーム ―</p>
                </div>

                <div class="gamebox">
                  <span id="game_targetLeft" ></span><span id="game_target" >click to start!</span>
                </div>

                <div>
                  <input type="button" class="btn btn-primary" value="click to start" id="start_button">
                  <br>
                  <br>
                  <h3 class="text-white">キーボード入力でゲームができます。</h3>
                </div>

                <form action="" method="POST">

<?php
                        echo '<input type="hidden" name="game_score" id="game_score" value='.$_SESSION['score'].'>';
                        echo 'HIGH SCORE：<span id="game_lblhighscore">'.$_SESSION['score'].'</span> / SCORE：<span id="game_lblscore">0</span>';
?>
                        成功数：<span id="game_success">0</span> / Miss: <span id="game_miss">0</span>
                        <br/>
                        <span id="game_timer">制限時間：20秒</span>
                        <br/>
                        <progress id="game_progress" class="progress is-primary" value="0" max="2000"></progress>
                        <br/>

<?php
 if ($err_msg !== null && $err_msg !== '') {
    echo "<div>";
    echo $err_msg;
    echo "</div>";
    echo "<br/>";
 }
?>
<?php
 if ($result_msg !== null && $result_msg !== '') {
   // スコア更新処理に成功した場合、
    echo "<div>";
    echo $result_msg;
    echo "</div>";
    echo "<br/>";
?>
    <a class="btn btn-primary" href="Ranking.php?game_code=1">ランキング表へ</a>
<?php
 }
?>
    <input type="submit" class="btn btn-secondary" name="UpdScore" id="btnUpd" value="スコア更新" disabled="true">
                </form>

            </div>
    </div>
  </div>
</header>

<!-- 外部のJavaScriptファイルの読み込み -->
<script type="text/javascript" src="js/game01.js"></script>


<?php
include('_footer.php');