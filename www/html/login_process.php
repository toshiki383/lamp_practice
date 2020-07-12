<?php
// それぞれのページから情報を取得
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

// セッションを開始
session_start();

// iframe対策
header("X-FRAME-OPTIONS: DENY");

// ログインされていればホームページに移動
if(is_logined() === true){
  redirect_to(HOME_URL);
}

// POSTから情報を取得
$name = get_post('name');
$password = get_post('password');

// POSTからトークンを取得
$token = get_post('csrf_token');

// sessionからトークンを取得
$session = get_session('csrf_token');

// トークンが適正であれば以下を実行
if(is_valid_csrf_token($token, $session) === true){

  // データベースに接続
  $db = get_db_connect();

  // ログインを実行
  $user = login_as($db, $name, $password);

  // ユーザー情報が正しくなければエラーメッセージを表示してログインページに戻る
  if( $user === false){
    set_error('ログインに失敗しました。');
    redirect_to(LOGIN_URL);
  }
  // ログインメッセージの表示
  set_message('ログインしました。');
  if ($user['type'] === USER_TYPE_ADMIN){
    redirect_to(ADMIN_URL);
  }
  // ホームページに移動
  redirect_to(HOME_URL);

// 不正アクセスの場合
}else{
  // エラーを表示
  set_error('不正なアクセスです。');

  // ホームページに戻る
  redirect_to(HOME_URL);
}