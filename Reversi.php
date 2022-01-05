<?php
include('_header.php');
$result_msg = "";
$err_msg = "";

if ($_SESSION['score2'] === null || $_SESSION['score2'] === '') {
  // ログインがされてない場合は、セッション情報のスコア（ハイスコアも含む）に０を設定する。
  $_SESSION['score2'] = 0;
}
  
if(isset($_POST['UpdScore'])) {

  if (!isset($_SESSION['id'])) {
//  if ($_SESSION['username'] === null || $_SESSION['username'] === '') {
	// ログインがされてない場合
//    $_SESSION['score2'] = 0;
    $result_msg = "";
    $err_msg = "ランキングに登録する場合は、<br>ログインをして下さい。";

  } elseif( $_POST['game_score'] <= $_SESSION['score2'] ) {
  // 前回のハイスコアを更新できなかった場合は、スコア更新ボタンを押してもエラメッセージを出す。
    $result_msg = "";
    $err_msg = "ハイスコアが更新されてません。";

  } else {
    $result_msg = "";
    $err_msg = "";

//    echo '$_SESSION1:'.$_SESSION['score2'];
//    echo '<br/>';

    $username = $_SESSION['username'];
  //  $password = $_POST['password'];
    $_SESSION['score2'] = $_POST['game_score'];
    $score = $_POST['game_score'];

    try {

  //    echo 'デバッグ';
  //    echo '<br/>';
//  echo '$_SESSION2:'.$_SESSION['score2'];

          // DBに接続するためのユーザー名やパスワードを指定
          $dsn = 'pgsql:dbname=sampledb;host=myapp-db';
          $db = new PDO($dsn, 'sample-user', 'hi2mi4i6');

		  // オセロは、ゲームコード『２』のデータを更新する。
          $sql = 'update games set score = ?, updated_at = CURRENT_TIMESTAMP where user_id = ? and gamecode = 2';

          $stmt = $db->prepare($sql);
          $stmt->execute(array($score,$_SESSION['id']));
          $stmt = null;
          $db = null;

          //ログインしている時
          $result_msg = "ランキング表に更新されました。";
          $err_msg = "";

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
			<div>

				<div align="center" class="text-white">
					<p class="display-6">―オセロ(Vue.js)―</p>
				</div>

				<form action="" method="POST">

					<div id="app">
						<!-- vueで表を作る -->
						<table cellspacing="0">
							<tr v-for="cell in cells" class="cellborder">
								<td v-for="i in cell" class="cell" v-on:click="clicked()">
									<!-- 空白=0, 黒石=1, 白石=-1 -->
									<span v-if="i===1">&#x26AB;</span> <!-- 絵文字の黒 -->
									<span v-if="i===-1">&#x26AA;</span> <!-- 絵文字の白 -->
									<span v-if="i===0"></span> <!-- 空白 -->
								</td>
							</tr>
						</table>

						<div id="text" class="text-white">
			<?php
				if ($err_msg !== null && $err_msg !== '') {
					// スコア更新が失敗した時
					echo $err_msg;
					echo "<br/>";
				} 
			?>

			<?php	
				if ($result_msg !== null && $result_msg !== '') {
					// スコア更新処理に成功した場合、
					echo $result_msg;
					echo "<br/>";
				} else {
			?>
							<span id="message"></span>
							<br>
							<span id="message2"></span>
							<br>
			<?php
				}
							// HTML非表示・データ更新用スコア
							echo '<input type="hidden" name="game_score" id="game_score" value='.$_SESSION['score2'].'>';
							// ハイスコアとスコアの表示。
							echo 'HIGH SCORE：<span id="game_lblhighscore">'.$_SESSION['score2'].'</span> / SCORE：<span id="game_lblscore">0</span>';
			?>
						</div>

			<?php
				if ($result_msg !== null && $result_msg !== '') {
					// スコア更新処理に成功した場合、
			?>
						<a class="btn btn-primary" href="Ranking.php?game_code=2">ランキング表へ</a>
			<?php
				} else {
			?>
						<button v-on:click="new_game" class="btn btn-primary">新しいゲームを始める</button>
			<?php
				}
			?>
						<input type="submit" class="btn btn-secondary" name="UpdScore" id="btnUpd" value="スコア更新" disabled="true">


					</div>

					<!--
					<script src="js/vue.js"></script>
					-->
					<!-- VUEをCDNで呼び出す -->
					<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
					<script>
						let app = new Vue({
							el: "#app",
							data: {
								// 探索する方向
								direction: [
									[-1, -1],
									[0, -1],
									[1, -1],
									[1, 0],
									[1, 1],
									[0, 1],
									[-1, 1],
									[-1, 0],
								],
								isPlaying: false, // 他のJavaScript内で使ってるゲームフラグ
												// true：ゲームプレイ中、false：ゲーム停止中
												// （一度スタートボタンを押したら、時間終了までボタンは実行できなくする、予定。）
								cells: [],
								flag_cells: [],
								turn: "",
								flag_pass: "",
								random: "",
								flag_vscpu: "cpu" // 対戦相手は自分操作ではなく、
												// cpu戦に固定する。
							},

							methods:{
								// 盤面の初期化処理
								init_field: function(){
									// 盤面
									this.cells =  [
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0,-1, 1, 0, 0],
										[0, 0, 1,-1, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
									];

									// 返せる駒の位置
									this.flag_cells = [
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
										[0, 0, 0, 0, 0, 0],
									];

									// その他
									this.isPlaying = true; // 他のJavaScript内で使ってるゲームフラグ
												// true：ゲームプレイ中、false：ゲーム停止中
												// （一度スタートボタンを押したら、時間終了までボタンは実行できなくする、予定。）
			//						document.getElementById('btnUpd').removeAttribute('disabled'); // 更新ボタンの非活性要素を削除。
									document.getElementById('btnUpd').disabled = true; // 更新ボタンの非活性に設定する。

									this.turn = 1;
									this.flag_pass = false;
									this.random = Math.floor(Math.random() * 2) * 2 -1;
									document.getElementById("message").innerHTML = "次は黒番です";
									this.verification_put();
								},

								// クリック時の処理
								clicked: function(ev){
									// イベントから行と列を特定
									// 置こうとした石の座標を取得する処理です
									ev = ev || window.event;
									elem = ev.target;
									let list_tr = document.getElementsByTagName("tr");
									let list_td = elem.parentNode.childNodes;
									list_tr = [].slice.call(list_tr); // 列
									list_td = [].slice.call(list_td); // 行
									// 現在の座標(列＆行のセル番号)を取得
									tr_num = list_tr.indexOf(elem.parentNode);
									td_num = list_td.indexOf(elem);

									this.put(tr_num, td_num) // 石を置く処理へ
								},
								
								// 石を置く処理
								put: function(tr_num, td_num){
									if (this.check_put(tr_num, td_num)){
										// ひっくり返す
										for (let i=0; i<6; i++) {
											for (let j=0; j<6; j++) {
												if (this.flag_cells[i][j] === 1){
													this.cells[i][j] = this.turn;
												};
											};
										};
					
										// 石を置く
										this.$set(this.cells[tr_num], td_num, this.turn);
										this.change_turn();
									};
								},

								// ターンを変える処理
								change_turn: function(){
									//ターンは石の値に合わせて{白:-1, 黒:1}のように設定している。
									//0から引くことでこれを行っています。
									this.turn = 0 - this.turn;
									document.getElementById("message").innerHTML = "次は" + [ "白", "", "黒"][this.turn+1] + "番です";
									
									// 終了判定
									if (!this.cells.some(value => value.some(v => v===0))){
									//ここで、もしすべてのマスが埋まっていたら、終了の処理を行う。
										this.finish()
									}

									//パスになるかどうかの確認等の処理を行う。
									this.verification_put();
								},

								// cpuと対戦のチェックボックスが押されたときに手を確認する
								vs_cpu: function(){
									this.flag_vscpu = "cpu";
									this.verification_put();
								},

								// 置き場所の確認・cpuの指し手
								verification_put: function(){
									// 人の手番を表示/非表示
									if (this.flag_vscpu === "cpu"){
										document.getElementById("message2").innerHTML = "あなたは" + [ "白", "", "黒"][-this.random+1] + "番です";
									} else{
										document.getElementById("message2").innerHTML = "";
									}

									// 置き場所があるかを確認
									let able_put = []
									for (let i=0; i<6; i++) {
										for (let j=0; j<6; j++) {
											if (this.check_put(i, j)){
												able_put.push([i, j]);
											};
										};
									};

									// 置く場所なかったら終了or手番を変える
									if (able_put.length === 0){
										document.getElementById("message").innerHTML = "置ける場所がありません";
										if (this.flag_pass){
											this.finish()
										} else {
										this.flag_pass = true
										this.change_turn()
										};
									} else {
										this.flag_pass = false

										// cpuの番
										if (this.flag_vscpu === "cpu" & this.turn === this.random){
											// cpu操作の時は、置ける場所からランダムに一つ選んでおくようにしています。
											// なのでCPUは、そこまで賢くは無いです。
											let random_choice = able_put[Math.floor(Math.random() * able_put.length)];

											// ほかの言語でいうところのsleepの機能を実装することで、
											//cpuが置くまでに時間がかかるようにして視覚的にわかりやすくしています。
											setTimeout(this.put, 1000, random_choice[0], random_choice[1]);
										};
									};
								},

								// 終了時の処理
								finish: function(){
									// 石の和を数えることで＋なら黒の勝ち、－なら白の勝ちと判定。
									// 空白=0, 黒石=1, 白石=-1
									let sum = this.cells.reduce((sum, element) => sum + element.reduce((sum2, element2) => sum2 + element2, 0), 0)

									// ハイスコア
									let highscore = document.getElementById("game_lblhighscore").textContent;
									let nowscore = 0; // 今回のスコア
									let blackCnt = 0; // 黒石の数
									let whiteCnt = 0; // 白石の数

									for (i=0; i<6; i++) {
										for (j=0; j<6; j++) {
											if (this.cells[i][j] === 1){
											// 黒石の時
												blackCnt++;
											} else if (this.cells[i][j] === -1){
											// 白石の時
												whiteCnt++;
											};
										};
									};

									if (sum > 0){
										if ([ "白", "", "黒"][-this.random+1] === "黒") {
										// プレイヤーの手番が黒の場合
											document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）あなたの勝ちです";
										} else {
											document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）あなたの負けです";
										}
			//							document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）黒の勝ちです";
									} else if (sum < 0){
										if ([ "白", "", "黒"][-this.random+1] === "白") {
										// プレイヤーの手番が白の場合
											document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）あなたの勝ちです";
										} else {
											document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）あなたの負けです";
										}
			//							document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）白の勝ちです";
									} else {
										document.getElementById("message").innerHTML = "（黒は" + blackCnt + "、白は" + whiteCnt + "）引き分けです";
									}

									if ([ "白", "", "黒"][-this.random+1] === "白") {
										// プレイヤーの手番が白の場合
										if (sum < 0) {
											// （白勝利）プレイヤーの勝利
											//  (白石 - 黒石) × 10点　とする。
											nowscore = (whiteCnt - blackCnt) * 10;
											document.getElementById("game_lblscore").textContent = nowscore;
										} else {
											// （黒勝利）プレイヤーの敗北
											document.getElementById("game_lblscore").textContent = 0;
										}
									} else if ([ "白", "", "黒"][-this.random+1] === "黒") {
										// プレイヤーの手番が黒の場合
										if (sum > 0) {
											// （黒勝利）プレイヤーの勝利
											//  (黒石 - 白石) × 10点　とする。
											nowscore = (blackCnt - whiteCnt) * 10;
											document.getElementById("game_lblscore").textContent = nowscore;
										} else {
											// （白勝利）プレイヤーの敗北
											document.getElementById("game_lblscore").textContent = 0;
										}
									}

									if ( nowscore > highscore ) {
										// 今回のスコアが、前回のハイスコアより大きい場合はスコアを更新する。
										document.getElementById("game_lblhighscore").textContent = nowscore;
										// データベース更新用のHTML非表示テキストのスコアも更新する。
										document.getElementById('game_score').value = nowscore;
									}

									this.isPlaying = false; // 他のJavaScript内で使ってるゲームフラグ
												// true：ゲームプレイ中、false：ゲーム停止中
												// （一度スタートボタンを押したら、時間終了までボタンは実行できなくする、予定。）
									//	document.getElementById('btnUpd').removeAttribute('disabled'); // 更新ボタンの非活性要素を削除。
									document.getElementById('btnUpd').disabled = false; // 更新ボタンを活性に変更する。
								},

								// 新しいゲームを開始
								new_game: function(){
									// 盤面の初期化処理
									this.init_field();
									// 画面の表示を更新するために、Array.spliceメソッドを使う。
									this.cells.splice(this.cells.length-1, [0, 0, 0, 0, 0, 0]);
								},

								// 盤面の端に来たかどうかの確認
								check_end: function(tr_num, td_num){
									return 5>=tr_num & tr_num>=0 & 5>=td_num & td_num>=0;
								},

								// 駒を置けるか確認
								check_put: function(tr_num, td_num){
									if (this.cells[tr_num][td_num] != 0){
									// 黒石=1, 白石=-1　の時は強制終了。
										return false;
									} else {
									// 空白=0　の時
										this.flag_cells = [
											[0, 0, 0, 0, 0, 0],
											[0, 0, 0, 0, 0, 0],
											[0, 0, 0, 0, 0, 0],
											[0, 0, 0, 0, 0, 0],
											[0, 0, 0, 0, 0, 0],
											[0, 0, 0, 0, 0, 0],
										];
										this.turn_over(tr_num, td_num);
										// some関数：for分でループしなくても、配列の中にある全ての値をチェックしてくれる。
										// ひっくり返せる石があるよフラグ＝１があった場合、戻り値を返す
										// 戻り値：True/False
										return this.flag_cells.some(value => value.some(v => v===1));
									};
								},

								// 返せるか確認
								turn_over: function(tr_num, td_num){
									this.direction.forEach(dir => {
										//↑direction：自分の石を置いた場所から、８方向の座標情報。
										//　forEach：自分の石を置いた現在の座標に、隣接する８方向の座標を足すことで、
										//隣接する８方向の状態をチェックしたい
										let td_here = td_num + dir[0];
										let tr_here = tr_num + dir[1];

										// 自分の石があるか確認
										let flag_mystone = false;
										while (this.check_end(tr_here, td_here)){
											if (this.cells[tr_here][td_here] === 0-this.turn){
												td_here += dir[0];
												tr_here += dir[1];
												continue;
											} else if (this.cells[tr_here][td_here] === this.turn){
												flag_mystone = true;
												break;
											} else{
												flag_mystone = false;
												break;
											};
										}
										// なかったら次の方向へ
										if (!flag_mystone){
											return;
										};

										// 相手の石がある確認
										td_here = td_num + dir[0];	
										tr_here = tr_num + dir[1];
										while (this.check_end(tr_here, td_here)){
											if (this.cells[tr_here][td_here] === 0-this.turn){
												// ひっくり返すの実行処理をする前に、このタイミングで、ひっくり返せますよフラグを立てておく。
												this.flag_cells[tr_here][td_here] = 1;
												td_here += dir[0];
												tr_here += dir[1];
											} else{
												break;
											};
										};
									});
								},
							},
							created() {
								this.init_field();
							}
						});
					</script>

				</form>
				
			</div>
		</div>
	</div>
</header>

<?php
include('_footer.php');