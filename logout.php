<?php
include('_header.php');
$_SESSION = array();//セッションの中身をすべて削除（ログアウト処理）
session_destroy();//セッションを破壊
?>
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">Portfolio</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5">ログアウトしました。</h2>
                        <a class="btn btn-primary" href="login.php">ログインへ</a>
                    </div>

<?php
include('_footer.php');