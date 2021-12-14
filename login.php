<?php
include('_header.php');
$result＿msg = "";
$err_msg = "";

if(isset($_POST['login'])) {
// ログインボタンを押した時

	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
//		$db = new PDO('mysql:host=localhost; dbname=データベース名','ユーザー名','パスワード');
// Herokuサーバー接続用
$dbinfo = parse_url(getenv('DATABASE_URL'));
$dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
$db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

    // DBに接続するためのユーザー名やパスワードを指定
//        $dsn = 'pgsql:dbname=sampledb;host=myapp-db';
//        $db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

		$sql = 'select * from users where username=? and password=?';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($username,$password));
        $result = $stmt->fetch();

		$stmt = null;
		$db = null;

        if ($result[0] != 0) {
            //DBのユーザー情報をセッションに保存
//            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['score'] = $result['score'];
            $_SESSION['score2'] = $result['score2'];

            $result＿msg = 'ようこそ。'.$result['username'].'様';
//            header('Location: http://localhost/index2.php');
//			exit;
		} else {
            $err_msg = "ユーザ名またはパスワードが誤ってます。";
		}


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
              <a class="btn btn-secondary" href="QuizGame.php">英単語クイズゲーム</a>
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
                        echo '<input type="password" class="form-control" name="password" value="'.$password.'">'
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
              <a class="btn btn-secondary" href="QuizGame.php">英単語クイズゲーム</a>
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