  const $window = window;
  const $doc = document;

  const $btnGuest = $doc.getElementById('guest_button');

  const $txtUsername = $doc.getElementById('id_username');
  const $txtPassword = $doc.getElementById('id_password');

  $btnGuest.addEventListener('click', (e) => {
    //ゲスト(Guest)ボタンをクリックした時、
    //ゲスト用のユーザー名とパスワードを設定する。
    $txtUsername.value= 'guest';
    $txtPassword.value= 'guest1234';
  });
