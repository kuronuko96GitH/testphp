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
        // ※今回はテストデータなので、暗号化をしてデータベースには登録しない。
//        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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

    // データベースに、既に登録されてるユーザーが存在しないかをチェック。
    try {
          // Herokuサーバー接続用
          $dbinfo = parse_url(getenv('DATABASE_URL'));
          $dsn = 'pgsql:host=' . $dbinfo['host'] . ';dbname=' . substr($dbinfo['path'], 1);
          $db = new PDO($dsn, $dbinfo['user'], $dbinfo['pass']);
      
          $sql = 'select * from users where username=?';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($username));
          $result = $stmt->fetch();
      
          if ($result['username'] !== null) {
            //同じユーザー名が存在する。
            $err_msg = "そのユーザー名は、既に登録されています。";
            $chk_flg = false;
          }

    }catch (PDOException $e){
      echo $e->getMessage();
      exit;
    }
  }


  if ( $chk_flg != false ) {
    // 入力項目のチェックが問題無い場合。

    try {    
      
          $sql = 'insert into users(username,password) values(?,?)';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($username,$password));

          
          // 新規データから、user_idを取得する。
          $sql = 'select * from users where username=? and password=?';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($username,$password));
          $result = $stmt->fetch();

          // セッション情報に設定する。
          $_SESSION['id'] = $result['id'];
          $_SESSION['username'] = $username;

          for ($x=1; $x <= 3; $x++) {
            // ゲームの数だけループを繰り返し、gamesテーブルに新規データを追加する。
           
            $sql = 'insert into games(user_id, username, gamecode) values(?,?,?)';
            $stmt = $db->prepare($sql);
            $stmt->execute(array($_SESSION['id'], $_SESSION['username'], $x));
          }


          $stmt = null;
          $db = null;

          $result＿msg = 'ようこそ。'.$username.'様';

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
                  <a class="btn btn-secondary" href="Reversi.php">オセロゲーム【Vue.js作成版】</a>
                </div>
            </div>
<?php
              echo "<br/>";
              echo "オセロゲームを押して下さい";
          } else {
?>
            <div class="row center-block text-center">
                <div class="col-5">
                  <input type="submit" name="signup" class="btn btn-secondary" value="新規登録">  
                </div>
                <div class="col-7">
                </div>
            </div>
<?php
          }
?>

          </div>
        </form>

      </div>
    </div>
  </div>
</header>

<?php 
include('_footer.php');