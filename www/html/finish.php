<?php
// それぞれのページから関数を取得
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

// セッションを開始
session_start();

// iframe対策
header("X-FRAME-OPTIONS: DENY");

// ログインされていなければログインページに戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// POSTからトークンを取得
$token = get_post('csrf_token');

// sessionからトークンを取得
$session = get_session('csrf_token');

// トークンが適正であれば以下を実行
if(is_valid_csrf_token($token, $session) === true){

  // データベースに接続
  $db = get_db_connect();

  // ユーザー情報の取得
  $user = get_login_user($db);

  // ユーザーのカートない情報を取得
  $carts = get_user_carts($db, $user['user_id']);

  // 購入ができなければエラーを表示してカートページに戻る
  if(purchase_carts($db, $carts) === false){
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
  } 

  // 合計金額
  $total_price = sum_carts($carts);

// 不正アクセスの場合
}else{
  // エラーを表示
  set_error('不正なアクセスです。');
}

// VIEWの読み込み
include_once '../view/finish_view.php';