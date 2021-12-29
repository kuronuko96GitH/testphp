<?php
include('_header.php');
$result＿msg = "";
$err_msg = "";

if(isset($_POST['login'])) {
// ログインボタンを押した時

	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
    // Herokuサーバー接続用
    $dbinfo = parse_url(getenv('DATABASE_URL'));
    $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
    $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

		$sql = 'select * from users where username=? and password=?';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($username,$password));
    $result = $stmt->fetch();


    if ($result['id'] !== null) {
      //DBのユーザー情報をセッションに保存
      $_SESSION['id'] = $result['id'];
      $_SESSION['username'] = $result['username'];


      for ($x=1; $x <= 3; $x++) {
        // ゲームの数だけループを繰り返し、セッション情報を設定する。
        $sql = 'select * from games where username=? and gamecode=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($username,$x));
        $result = $stmt->fetch();

        if ($x === 1) {
          $_SESSION['score'] = $result['score'];

        } else if ($x === 2) {
          $_SESSION['score2'] = $result['score'];
          
        } else if ($x === 3) {
          $_SESSION['score3'] = $result['score'];
          
        }
      }

        $result＿msg = 'ようこそ。'.$result['username'].'様';

		} else {
        $err_msg = "ユーザ名またはパスワードが誤ってます。";
		}

		$stmt = null;
		$db = null;

	}catch (PDOException $e){
		echo $e->getMessage();
		exit;
	}
}
?>
    <div class="text-white">
      <div align="center">
        <p class="display-5">― ログイン ―</p>
      </div>

<?php
  if ($_SESSION['username'] !== null && $_SESSION['username'] !== '') {
    // ログイン済みのユーザーの場合。
        echo "<br/>";
        echo 'ようこそ。'.$_SESSION['username'].'様';
        echo "<br/>";
        echo "<br/>";
?>
        <div class="row center-block text-center">
            <div class="col-12">
              <a class="btn btn-secondary" href="TypingGame.php">タイピングゲーム</a>
              <a class="btn btn-secondary" href="Reversi.php">オセロゲーム【Vue.js作成版】</a>
            </div>                      
        </div>

<?php
      echo "<br/>";
      echo "遊びたいゲームを押して下さい";
  } else {
  // まだログインされてないユーザーの場合

    if ($err_msg !== null && $err_msg !== '') {
        echo "<div>";
        echo $err_msg;
        echo "</div>";
        echo "<br/>";
    }
?>
    <form action="" method="POST">
      <div class="col-20">
        <div class="row">
            <div class="col-md">
                <form>
                    <div class="form-group">
                        <label>ユーザー：</label>
<?php
                        echo '<input type="text" class="form-control" name="username" value="'.$username.'">'
?>
                    </div>

                    <br/>

                    <div class="form-group">
                        <label>パスワード：</label>
<?php
                        echo '<input type="password" class="form-control" name="password">'
?>
                    </div>
                </form>
            </div>
        </div>

        <br/>

<?php
    if ($result＿msg !== null && $result＿msg !== '') {
        echo "<br/>";
        echo $result＿msg;
        echo "<br/>";
        echo "<br/>";
?>
        <div class="row center-block text-center">
            <div class="col-12">
              <a class="btn btn-secondary" href="Reversi.php">オセロゲーム【Vue.js作成版】</a>
            </div>
        </div>
<?php
      echo "<br/>";
      echo "クイズゲームを押して下さい";
    } else {
?>
        <div class="row center-block text-center">
            <div class="col-5">
              <input type="submit" name="login" class="btn btn-primary" value="ログイン">  
            </div>
            <div class="col-1">
            </div>
            <div class="col-6">
              <a class="btn btn-secondary" href="signup.php">新規登録へ</a>
            </div>
        </div>
<?php
    }
?>

      </div>
    </div>

  </form>
<?php
  // ここまでが、まだログインしてないユーザーだった場合 
  }

include('_footer.php');