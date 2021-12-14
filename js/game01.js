
  const words = [
    'age','afternoon','apple','aunt','bag','baseball','basketball','bed','bank','bird',
    'box','boy','bread','breakfast','brother','boat','book','bus','cake','camera',
    'cap','car','cat','chair','chance','church','citizen','class','clerk','color',
    'cook','country','cow','cup','danger','daughter','desk','diary','dinner','doctor',
    'dog','doll','door','family','father','field','fish','floor','flower','friend',
    'fruit','garden','gate','girl','glass','hand','homework','hospital','hotel','house',
    'kitchen','left','letter','library','line','lot','lunch','mail','man','map',
    'meal','meter','milk','mitt','morning','mother','night','noon','notebook','nurse',
    'office','orange','parent','park','pen','pencil','piano','picture','pilot','place',
    'plane','player','pot','present','racket','right','room','rose','science','season',
  ];


  let word = words[Math.floor(Math.random() * words.length)];

  let loc = 0;
  let score = 0;
  let miss = 0;

  let TimeLimit = 20 * 1000; // ミリ秒なので1000倍し、20秒に設定
  let startTime = 0; // ゲームスタート時刻を保持するための変数
  let isPlaying = false; // 一度スタートボタンを押したら、時間終了までボタンは実行できなくする。


  const $window = window;
  const $doc = document;

  //スコア更新ボタンは、初期値は非活性に変更する。
  const $btnUpd = $doc.getElementById('btnUpd');
  $btnUpd.disabled  = true;
  const $btnStart = $doc.getElementById('start_button');
  const $barProg = $doc.getElementById('game_progress');

  const $txtScore = $doc.getElementById('game_score');

  const $lblTargetLeft = $doc.getElementById('game_targetLeft');
  const $lblTarget = $doc.getElementById('game_target');
  const $lblTimer = $doc.getElementById('game_timer');
  const $lblSuccess = $doc.getElementById('game_success');
  const $lblMiss = $doc.getElementById('game_miss');
  const $lblScore = $doc.getElementById('game_lblscore');
  const $lblHighScore = $doc.getElementById('game_lblhighscore');



  $btnStart.addEventListener('click', (e) => {
    //STARTボタンをクリックした時

    //スコア更新を非活性に変更する。
    $btnUpd.disabled = true;

    if (isPlaying === true) { // isPlaying が true なら
      return; // 以下の処理をせずにreturn
    }
    isPlaying = true; // isPlaying を true へ


    //全てのラベルテキストと変数を初期化
    word = words[Math.floor(Math.random() * words.length)]; // 別の問題を選択する
    $lblTarget.textContent = word;
    $lblTargetLeft.textContent = '';
    loc = 0; // locを0に初期化

    score = 0;
    $lblSuccess.textContent = score;

    miss = 0;
    $lblMiss.textContent = miss;

    //タイマーカウント
    startTime = Date.now(); // 現在時刻を代入
    func_updTimer(); // 残り時間表示関数
  });


  function updateTargetColor() {
    // 正解した文字の色を変える

    // loc番目までは'*'、loc番目以降はそのまま表示
    $lblTargetLeft.textContent = word.substring(0,loc);
    $lblTarget.textContent = word.substring(loc);
  };


  function updateTarget() {
    // 正解した文字を * に変換させる

    let placeholder = ''; // '*'を格納するための空の変数

    for (let i = 0; i < loc; i++) { 
      placeholder += '*'; // 呼び出された数だけ'*'を連結する
    }

    // loc番目までは'*'、loc番目以降はそのまま表示
    $lblTarget.textContent = placeholder + word.substring(loc);
  };



  $window.addEventListener('keydown', e => {
  // キーボード入力イベント

    if (isPlaying !== true) { // タイプ時に isPlaying が true じゃなかったら return する
      // wordも初期化する。
      $lblTargetLeft.textContent = '';
      $lblTarget.textContent = 'click to start!';

      return;
    }

    if (e.key === word[loc]) {
     // 正解
     // 打ったキー(eは変数名)がwordのloc番目の文字と同じなら
      loc++; // 次の文字へ

      if (loc === word.length) {
       // locが問題の文字列数と一致したら
        word = words[Math.floor(Math.random() * words.length)]; // 別の問題を選択する
        loc = 0; // locを0に初期化
      }

//      updateTarget(); // 正解した文字を * に変換させる
      updateTargetColor(); // 正解した文字の色を変える
      score++;

      // 正解数を表示
      $lblSuccess.textContent = score;

    } else {
     // 失敗（ミス）
      miss++;

      // ミス数を表示
      $lblMiss.textContent = miss;

    }
  });



  function func_updTimer() {

    const timeLeft = startTime + TimeLimit - Date.now(); // 残り時間を計算

    // タイマーラベルに秒で表示
    $lblTimer.textContent = '制限時間：' + (timeLeft / 1000).toFixed(2) + '秒';

    // 制限時間の進捗バーを更新
    $barProg.value = (timeLeft / 1000).toFixed(2) * 100;

    if (timeLeft <= 0) {
      // 残り時間が0以下になったら

      isPlaying = false; // ゲームが終了したので isPlaying を false へ
      func_showResult(); // 正解率表示関数を呼び出す

      //ハイスコア登録ボタンを活性化
      $btnUpd.disabled = false;

      clearTimeout(timeoutId); // timeoutIdを解除する
    }

    const timeouId = setTimeout(() => {
                       // func_updTimerを呼んだ10ミリ秒後に
      func_updTimer(); // func_updTimerを呼び出す = func_updTimerを繰り返す
    }, 10);
  };



  function func_showResult() {
    // 正答率を計算
    const accuracy = score + miss === 0 ? 0 : score / (score + miss) * 100;
    const highscore = parseInt($lblHighScore.textContent);

    // 正解率を表示
    $lblTimer.textContent = '正答率：' + accuracy.toFixed() + '％（成功数：' + score + '／総数：' + (score + miss) + '）';

    if ( (score * 10) > highscore ) {
      // 今回のスコアが、前回のハイスコアより大きい場合はスコアを更新する。
    
      // スコアのテキストボックスに結果を代入。
      // スコア…正解数×１０倍
      $txtScore.value= score * 10;
      $lblHighScore.textContent= (score * 10);
    }
      $lblScore.textContent= (score * 10);
  };
