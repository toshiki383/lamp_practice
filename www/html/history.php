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

// 管理者であれば全ての購入履歴を取得
if(is_admin($user)){
    $historys = select_all_historys($db);

// 一般ユーザーであれば特定の購入履歴の取得
}else if(is_nomal($user)){
    $historys = select_historys($db, $user['user_id']);
}

// VIEWに出力
include_once VIEW_PATH . 'history_view.php';