<!doctype html>
<html lang="ja">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
    <title>Hello, world!</title>
</head>
 
<body>
    <br>
    <h1>人事データ管理システム</h1>
    <br>
 
    <div class="border col-7">
        <br>
        <h2>人事データ登録</h2>
        <br>
        <div class="row">
            <div class="col-md">
                <form>
                    <div class="form-group">
                        <label>No：</label>
                        <input type="text" class="form-control" value="d0000005" disabled>
                    </div>
                    <div class="form-group">
                        <label>氏名：</label>
                        <input type="text" class="form-control" placeholder="侍エンジニア 太郎">
                    </div>
                    <div class="form-group">
                        <label>部署：</label>
                        <select class="form-control">
                            <option>システム開発部</option>
                            <option>SEOマーケティング部</option>
                            <option>人事・総務部</option>
                            <option>営業本部</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>住所：</label>
                        <input type="text" class="form-control" placeholder="神奈川県〇〇市〇〇区〇〇〇町X-X-X 侍ビル1 XXX号室">
                    </div>
                    <div class="form-group">
                        <label>電話番号：</label>
                        <input type="text" class="form-control" placeholder="XXX-XXXX-XXXX">
                    </div>
                    <div class="form-group">
                        <label>補足：</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
        </div>
        <div class="row center-block text-center">
            <div class="col-1">
            </div>
            <div class="col-5">
                <button type="button" class="btn btn-outline-secondary btn-block">閉じる</button>
            </div>
            <div class="col-5">
                <button type="button" class="btn btn-outline-primary btn-block">新規登録</button>
            </div>
        </div>
        <br>
    </div>
 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <a href="./../index.php">トップページ</a>
</body>
 
</html>