<?php
include('_header.php');
$title = '';
?>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">Portfolio</h1>

                        <br>
                        <br>

                        <a class="btn btn-secondary" href="Reversi.php">オセロゲーム【Vue.js作成版】</a>

                        <br>
                        <br>

<?php
                    if (!isset($_SESSION['id'])) {
                        //ログインしてない時
?>
                        <h4 class="text-white-50 mx-auto mt-2">ランキング登録をする場合は、ログインをして下さい。</h4>
                        <br>
                        <a class="btn btn-primary" href="login.php">ログイン</a>
                        <br>
<?php
                    }
?>

                        <br>
                        <br>

                        <!-- URL GitHub -->
                        <section class="bg-dark">
                            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                                <div class="d-flex justify-content-center">
                                    
                                    <div class="text-center">
                                        <div class="card text-white bg-dark mb-3" style="max-width: 50rem;">
                                            <div class="card-body">
                                                <div>他にも公開してるポートフォリオは <a href="link.php">こちら</a>から</div>
                                                <div><i class="fab fa-github"></i></div>
                                                <div>GitHub（公開ソースコード）: <a href="https://github.com/kuronuko96GitH/testphp" target="_blank" rel="noopener">https://github.com/kuronuko96GitH/testphp</a></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </header>
      
<?php
include('_footer.php');