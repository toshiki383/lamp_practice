<?php
// それぞれのページから関数を取得
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションを開始
session_start();

// トークンを生成
$token = get_csrf_token();

// iframe対策
header("X-FRAME-OPTIONS: DENY");

// ログインされていなければログインページに戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// データベースに接続
$db = get_db_connect();

// ユーザー情報の取得
$user = get_login_user($db);

// GETから情報を取得
$sort = get_get('sort');

// ランキングの取得
$ranks = get_rank($db);

// 公開されている商品情報の取得
if($sort === ''){
  $items = get_open_items($db);
}

// 取得した情報をもとに並び替え
if($sort === 'low'){
  $items = get_low_items($db);
}
if($sort === 'high'){
  $items = get_high_items($db);
}
if($sort === 'new'){
  $items = get_new_items($db);
}

// VIEWに出力
include_once VIEW_PATH . 'index_view.php';