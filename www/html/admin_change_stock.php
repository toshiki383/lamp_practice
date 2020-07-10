<?php
// それぞれのページから関数を取得
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションを開始
session_start();

// iframe対策
header("X-FRAME-OPTIONS: DENY");

// ログインがされていなければログインページにに戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// データベースに接続
$db = get_db_connect();

// ログイン情報の取得
$user = get_login_user($db);

// 管理者でなければログインページに移動
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// POSTから情報を取得
$item_id = get_post('item_id');
$stock = get_post('stock');

// 在庫数の変更
if(update_item_stock($db, $item_id, $stock)){
  set_message('在庫数を変更しました。');
} else {
  set_error('在庫数の変更に失敗しました。');
}
// adminページに戻る
redirect_to(ADMIN_URL);