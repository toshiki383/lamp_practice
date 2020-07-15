<?php
// それぞれのページから情報を取得
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'history.php';

// セッションを開始
session_start();

// ログインが実行されなればログインページ戻る
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}

// データベースに接続
$db = get_db_connect();

// ユーザ情報の取得
$user = get_login_user($db);

// GETから情報を取得
$history_id = get_get('history_id');

// 指定した購入履歴の取得
$history = select_history($db, $user['user_id'], $history_id);

// 購入明細の取得
$details = select_details($db, $history_id);

// 管理者もしくは該当のユーザーでなければログインページに移動
if(is_admin($user) || ($user['user_id'] === $history['user_id']) === true){

    // VIEWに出力
    include_once VIEW_PATH . 'details_view.php';
} else{
    redirect_to(LOGIN_URL);
}