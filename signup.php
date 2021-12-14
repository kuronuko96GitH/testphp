<?php
include('_header.php');
$result＿msg = "";
$err_msg = "";
$chk_flg = true; // 入力チェックフラグ＝true(DB更新を許可する)


if(isset($_POST['signup'])) {
  // 新規登録ボタンを押した時

  $username = $_POST['username'];
  $password = $_POST['password'];

  // テキストエリアの入力チェック。
  if ($_POST['username'] !== null && $_POST['username'] !== '')  {
    $chk_flg = true;
  } else {
    $err_msg = "ユーザーが空白です。";
    $chk_flg = false;
  }

  if ($chk_flg === true) {
    if ($_POST['password'] !== null && $_POST['password'] !== '')  {

      //パスワードの正規表現
      if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      } else {
        $err_msg = "パスワードは半角英数字をそれぞれ<br/>1文字以上含んだ8文字以上で設定してください。";
        $chk_flg = false;
      }

    } else {
      $err_msg = "パスワードが空白です。";
      $chk_flg = false;
    }
  }

  if ( $chk_flg != false ) {
    // 入力項目のチェックが問題無い場合。

    try {    
//		$db = new PDO('mysql:host=localhost; dbname=データベース名','ユーザー名','パスワード');
// Herokuサーバー接続用
          $dbinfo = parse_url(getenv('DATABASE_URL'));
          $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
          $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);

    // DBに接続するためのユーザー名やパスワードを指定
//        $dsn = 'pgsql:dbname=sampledb;host=myapp-db';
//        $db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

          $sql = 'insert into users(username,password) values(?,?)';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($username,$password));
          $stmt = null;
          $db = null;

              //新規登録のユーザー情報をセッションに保存
  //            $_SESSION['id'] = $result['id'];
              $_SESSION['username'] = $username;

              $result＿msg = 'ようこそ。'.$username.'様';
  //            header('Location: http://localhost/index2.php');
  //			exit;


    }catch (PDOException $e){
      echo $e->getMessage();
      exit;
    }

  }
}
?>
    <div class="text-white">
      <div align="center">
        <p class="display-5">― 新規登録 ―</p>
      </div>

<?php
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
              <a class="btn btn-primary" href="QuizGame.php">英単語クイズゲーム</a>
            </div>
        </div>
<?php
    echo "<br/>";
    echo "クイズゲームを押して下さい";
} else {
?>
        <div class="row center-block text-center">
            <div class="col-5">
              <input type="submit" name="signup" class="btn btn-primary" value="新規登録">  
            </div>
            <div class="col-1">
            </div>
            <div class="col-6">
              <a class="btn btn-secondary" href="login.php">ログインへ</a>
            </div>
        </div>
<?php
  }
?>

      </div>
    </div>

  </form>



<?php 
include('_footer.php');