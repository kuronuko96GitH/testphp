<?php 
// PHP部分
// 実際にはPOSTされた値を取得したりするなどご自由に
$title = '文字列分割';
$data = 'hoge,huga';
$separator = ',';
?>
<!-- HTMLはPHPタグ外に書く -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<!-- JavaScriptはscriptタグで囲む -->
<script type="text/javascript">
<!-- JacaScript未対応ブラウザ対策
// 実際には入力チェックなどする
var today = new Date();
var month = today.getMonth() + 1;
var day = today.getDate();
document.write("今日は" + month + "月"+ day + "日です。");
// JacaScript未対応ブラウザ対策　-->
</script>
</head>
<body>

<noscript>
<!-- JavaScriptが利用できない環境の場合表示される -->
<p>あなたのブラウザはJavaScriptが利用できません</p>
</noscript>

<h1><?php echo $title; ?></h1>
<p>対象の文字列：<?php echo $data; ?></p>
<p>区切り文字：<?php echo $separator; ?></p>
<p>分割結果：<?php print_r(explode($separator, $data));?></p>

<a href="index.php">トップページ</a>
</body>
</html>