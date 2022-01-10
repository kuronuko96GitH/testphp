<?php
include('_header.php');
$title = '';
?>

       <!-- ER図 -->
       <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">                    
                    <div class="text-center">
                        <div class="card text-white bg-dark mb-3" style="max-width: 50rem;">
                            <div class="card-body">
                                <p class="card-text">ER図(実体関連図)</p>
                            </div>

                            <img class="card-img-bottom" src="../assets/img/er_phpgames.png" alt="Card image cap">

                            <div class="card-body">
                                <div>ゲームテーブルの『gamecode』で複数のゲームを管理しています。</div>
                                <div>例えば、オセロゲームのスコアを更新した場合は、</div>
                                <div>gamecode="2"のscoreデータが更新されます。</div>
                            </div>

                        </div>                        
                    </div>
                </div>

            </div>
        </header>

<?php
include('_footer.php');