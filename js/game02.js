const quiz = [
  {
    question: '年齢',
    answers: ['aga','age','agi','ago'],
    correct: 'age'
  }, {
    question: '午後',
    answers: ['afterpoon','afternon','afternoon','afteroon'],
    correct: 'afternoon'
  }, {
    question: '蟻',
    answers: ['ent','int','ont','ant'],
    correct: 'ant'
  }, {
    question: 'りんご',
    answers: ['apple','appla','applo','apply'],
    correct: 'apple'
  }, {
    question: '軍隊',
    answers: ['armiy','army','armin','ormy'],
    correct: 'army'
  }, {
    question: 'カバン',
    answers: ['beg','bug','bag','bog'],
    correct: 'bag'
  }, {
    question: '野球',
    answers: ['basball','baseball','baseboll','buseball'],
    correct: 'baseball'
  }, {
    question: 'バスケットボール',
    answers: ['besketball','baskatball','basketboll','basketball'],
    correct: 'basketball'
  }, {
    question: 'ベッド',
    answers: ['bet','bad','but','bed'],
    correct: 'bed'
  }, {
    question: '鳥',
    answers: ['bord','bird','bidd','bard'],
    correct: 'bird'
  }, {
    question: 'ケーキ',
    answers: ['cake','cako','caki','ceke'],
    correct: 'cake'
  }, {
    question: 'カメラ',
    answers: ['camira','comera','camera','camara'],
    correct: 'camera'
  }, {
    question: '自動車',
    answers: ['cer','car','cor','cir'],
    correct: 'car'
  }, {
    question: '猫',
    answers: ['cit','catt','cat','cot'],
    correct: 'cat'
  }, {
    question: 'いす',
    answers: ['cheir','chair','choir','chiar'],
    correct: 'chair'
  }, {
    question: '危険',
    answers: ['danger','dangger','denger','dangerr'],
    correct: 'danger'
  }, {
    question: '日記',
    answers: ['diery','diary','diari','dairy'],
    correct: 'diary'
  }, {
    question: '医者',
    answers: ['docter','dactor','doctar','doctor'],
    correct: 'doctor'
  }, {
    question: '犬',
    answers: ['dogg','dogy','dog','dogyy'],
    correct: 'dog'
  }, {
    question: '人形',
    answers: ['dolly','dall','doll','doly'],
    correct: 'doll'
  }, {
    question: '簡単',
    answers: ['eesy','easy','easi','eassy'],
    correct: 'easy'
  }, {
    question: '食べる',
    answers: ['eat','eato','eet','aat'],
    correct: 'eat'
  }, {
    question: '卵',
    answers: ['eggo','eg','egu','egg'],
    correct: 'egg'
  }, {
    question: 'エルフ',
    answers: ['elff','alf','elf','elfe'],
    correct: 'elf'
  }, {
    question: 'エネルギー',
    answers: ['enelgy','emergy','energy','anergy'],
    correct: 'energy'
  }, {
    question: '家族',
    answers: ['family','famuly','fomily','familly'],
    correct: 'family'
  }, {
    question: '父親',
    answers: ['fother','father','fater','fathar'],
    correct: 'father'
  }, {
    question: '魚',
    answers: ['fissh','fish','fishu','fash'],
    correct: 'fish'
  }, {
    question: '花',
    answers: ['flawer','flowar','flower','flowor'],
    correct: 'flower'
  }, {
    question: '友人',
    answers: ['frend','friendo','friende','friend'],
    correct: 'friend'
  }, {
    question: 'ゲーム',
    answers: ['game','gam','geme','gamu'],
    correct: 'game'
  }, {
    question: '庭',
    answers: ['gorden','gardden','gaden','garden'],
    correct: 'garden'
  }, {
    question: '門',
    answers: ['gote','gete','gate','gute'],
    correct: 'gate'
  }, {
    question: '少女',
    answers: ['garl','gerl','girl','girle'],
    correct: 'girl'
  }, {
    question: 'ゴール',
    answers: ['goal','gool','gole','goll'],
    correct: 'goal'
  }, {
    question: '手',
    answers: ['hando','hand','haund','hannd'],
    correct: 'hand'
  }, {
    question: '宿題',
    answers: ['homework','homewoak','homwork','homewoak'],
    correct: 'homework'
  }, {
    question: '病院',
    answers: ['hospitale','hospital','hospitel','hospitol'],
    correct: 'hospital'
  }, {
    question: '家',
    answers: ['house','hause','hausu','hous'],
    correct: 'house'
  }, {
    question: 'ミカン',
    answers: ['oranga','orango','orange','orangi'],
    correct: 'orange'
  }
];


  let score = 0;
  let miss = 0;

  let TimeLimit = 20 * 1000; // ミリ秒なので1000倍し、20秒に設定
  let startTime = 0; // ゲームスタート時刻を保持するための変数
  let isPlaying = false; // 一度スタートボタンを押したら、時間終了までボタンは実行できなくする。

  const quizLen = quiz.length; // 用意してる問題数
  let quizNo = 0; // クイズの問題番号


  const $window = window;
  const $doc = document;

  //スコア更新ボタンは、初期値は非活性に変更する。
  const $btnUpd = $doc.getElementById('btnUpd');
  $btnUpd.disabled  = true;
  const $btnStart = $doc.getElementById('start_button');

  const $btnSel1 = $doc.getElementById('btnjs1');
  $btnSel1.disabled  = true;
  const $btnSel2 = $doc.getElementById('btnjs2');
  $btnSel2.disabled  = true;
  const $btnSel3 = $doc.getElementById('btnjs3');
  $btnSel3.disabled  = true;
  const $btnSel4 = $doc.getElementById('btnjs4');
  $btnSel4.disabled  = true;

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

    //スコア更新ボタンを非活性に変更する。
    $btnUpd.disabled = true;
    //選択ボタンは使えるように変更する。
    $btnSel1.disabled  = false;
    $btnSel2.disabled  = false;
    $btnSel3.disabled  = false;
    $btnSel4.disabled  = false;

    if (isPlaying === true) { // isPlaying が true なら
      return; // 以下の処理をせずにreturn
    }
    isPlaying = true; // isPlaying を true へ

    // 問題を設定
    quizNo = Math.floor(Math.random() * quiz.length);
    func_init(); // 問題と選択ボタンのテキストを変更する

    score = 0;
    $lblSuccess.textContent = score;

    miss = 0;
    $lblMiss.textContent = miss;

    //タイマーカウント
    startTime = Date.now(); // 現在時刻を代入
    func_updTimer(); // 残り時間表示関数
  });



const func_init = () => {
  // 初期化処理

  if (isPlaying === false) {
    // 初期画面の設定
    // 問題を設定
    $lblTarget.textContent = "click to start!";

    // 回答も各ボタンに設定
    $btnSel1.value = "word01";
    $btnSel2.value = "word02";
    $btnSel3.value = "word03";
    $btnSel4.value = "word04";

  } else {
    // 問題を設定
    $lblTarget.textContent = quiz[quizNo].question;

    // 回答も各ボタンに設定
    $btnSel1.value = quiz[quizNo].answers[0];
    $btnSel2.value = quiz[quizNo].answers[1];
    $btnSel3.value = quiz[quizNo].answers[2];
    $btnSel4.value = quiz[quizNo].answers[3];
  }
};


const func_checkSel = () => {
  // 該当するボタンイベントで、クイズの質問と回答のチェック

  $btnSel1.addEventListener('click', (e) => {
  // 選択ボタン１を回答とチェック
    if($btnSel1.value === quiz[quizNo].correct) {
      score++;
      $lblSuccess.textContent = score; // 正解数を表示
      func_goToNext(); // 次の問題へ
    } else {
      // 失敗（ミス）
      miss++;
      $lblMiss.textContent = miss; // ミス数を表示
    }
  });

  $btnSel2.addEventListener('click', (e) => {
  // 選択ボタン２を回答とチェック
    if($btnSel2.value === quiz[quizNo].correct) {
      score++;
      $lblSuccess.textContent = score; // 正解数を表示
      func_goToNext(); // 次の問題へ
    } else {
      // 失敗（ミス）
      miss++;
      $lblMiss.textContent = miss; // ミス数を表示
    }
  });

  $btnSel3.addEventListener('click', (e) => {
  // 選択ボタン３を回答とチェック
    if($btnSel3.value === quiz[quizNo].correct) {
      score++;
      $lblSuccess.textContent = score; // 正解数を表示
      func_goToNext(); // 次の問題へ
    } else {
      // 失敗（ミス）
      miss++;
      $lblMiss.textContent = miss; // ミス数を表示
    }
  });

  $btnSel4.addEventListener('click', (e) => {
  // 選択ボタン４を回答とチェック
    if($btnSel4.value === quiz[quizNo].correct) {
      score++;
      $lblSuccess.textContent = score; // 正解数を表示
      func_goToNext(); // 次の問題へ
    } else {
      // 失敗（ミス）
      miss++;
      $lblMiss.textContent = miss; // ミス数を表示
    }
  });
};




const func_goToNext = () => {
  // 次の問題へ
  quizNo = Math.floor(Math.random() * quiz.length);
//  quizNo++;

  // 次の問題と回答ボタンを再設定する。
  func_init();
};



const func_updTimer = () => {

  const timeLeft = startTime + TimeLimit - Date.now(); // 残り時間を計算

  // タイマーラベルに秒で表示
  $lblTimer.textContent = '制限時間：' + (timeLeft / 1000).toFixed(2) + '秒';

  // 制限時間の進捗バーを更新
  $barProg.value = (timeLeft / 1000).toFixed(2) * 100;

  if (timeLeft <= 0) {
    // 残り時間が0以下になったら

    //選択ボタンは非活性に変更する。
    $btnSel1.disabled  = true;
    $btnSel2.disabled  = true;
    $btnSel3.disabled  = true;
    $btnSel4.disabled  = true;

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



const func_showResult = () => {
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



// 初期化
func_init();

// 回答チェック
func_checkSel();
