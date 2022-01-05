<?php
include('_header.php');
$result＿msg = "";
$err_msg = "";

if(isset($_POST['login'])) {
// ログインボタンを押した時

	$email = $_POST['email']; // 入力画面のメールアドレスを取得。

	try {
    // Herokuサーバー接続用
    $dbinfo = parse_url(getenv('DATABASE_URL'));
    $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
    $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

    $sql = 'select * from users where email=?';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($email));
    $result = $stmt->fetch();

    
    if ($result['id'] !== null) {
      // メールアドレスが存在する場合。

      $password = $_POST['password']; // 入力画面のパスワードを取得。
      if ( password_verify($password, $result['password']) ) {

        // password_verify…画面で入力したパスワードと、データベースの暗号化されたパスワードをキーにして、
        //パスワードが正しいことをチェックする関数。

        // パスワードも存在する場合
        //DBのユーザー情報をセッションに保存
        $_SESSION['id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $result['email'];


        for ($x=1; $x <= 3; $x++) {
          // ゲームの数だけループを繰り返し、セッション情報を設定する。
          $sql = 'select * from games where user_id=? and gamecode=?';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($_SESSION['id'],$x));
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
          $err_msg = "パスワードが誤ってます。";
      }


    } else {
      $err_msg = "メールアドレスが誤ってます。";
    }

		$stmt = null;
		$db = null;

	}catch (PDOException $e){
		echo $e->getMessage();
		exit;
	}
}
?>
<!-- Masthead-->
<header class="masthead">
  <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
    <div class="d-flex justify-content-center">
      <div class="text-white">

        <div align="center">
          <p class="display-5">― ログイン ―</p>
        </div>

<?php
      if ($_SESSION['email'] !== null && $_SESSION['email'] !== '') {
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
                            <label>メールアドレス：</label>
<?php
                            echo '<input type="text" class="form-control" name="email" id="id_email" value="'.$email.'">'
?>
                        </div>

                        <br/>

                        <div class="form-group">
                            <label>パスワード：</label>
<?php
                            echo '<input type="password" class="form-control" name="password" id="id_password" value="'.$password.'">'
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
        </form>

        <br>ゲスト(guest)で、ログインすることもできます。
        <div class="row center-block text-center">
                <div class="col-5">
                  <input type="button" class="btn btn-info" value="ゲストアカウント" id="guest_button">
                </div>
                <div class="col-1">
                </div>
                <div class="col-6">
                </div>
        </div>

      </div>
    </div>
  </div>
</header>

<!-- 外部のJavaScriptファイルの読み込み -->
<script type="text/javascript" src="js/guestlogin.js"></script>

<?php
  // ここまでが、まだログインしてないユーザーだった場合 
  }

include('_footer.php');