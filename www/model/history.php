<?php
// 関数の取得
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'cart.php';

// DB利用

// 全てのユーザーの購入履歴を全て取得
function select_all_historys($db){
  $sql = "
    SELECT
      history.history_id,
      history.user_id,
      history.created,
      SUM(price * amount) AS sum 
    FROM 
      history 
    JOIN 
      details 
    ON 
      history.history_id = details.history_id 
    GROUP BY 
      details.history_id
  ";
  $params = array();

  return fetch_all_query($db, $sql, $params);
}

// 特定のユーザーの購入履歴を全て取得
function select_historys($db, $user_id){
  $sql = "
    SELECT
      history.history_id,
      history.user_id,
      history.created,
      SUM(price * amount) AS sum 
    FROM 
      history 
    JOIN 
      details 
    ON 
      history.history_id = details.history_id 
    WHERE
      history.user_id = ? 
    GROUP BY 
      details.history_id
  ";
  $params = array($user_id);

  return fetch_all_query($db, $sql, $params);
}

// 特定のユーザーの指定した購入履歴を取得
function select_history($db, $user_id, $history_id){
  $sql = "
    SELECT
      history.history_id,
      history.user_id,
      history.created,
      SUM(price * amount) AS sum 
    FROM 
      history 
    JOIN 
      details 
    ON 
      history.history_id = details.history_id 
    WHERE
      history.user_id = ? AND history.history_id = ?
    GROUP BY 
      details.history_id
  ";
  $params = array($user_id ,$history_id);

  return fetch_query($db, $sql, $params);
}

// 指定した購入明細を全て取得
function select_details($db, $history_id){
  $sql = "
    SELECT
      details.item_id,
      items.name,
      details.price,
      details.amount,
      details.history_id
    FROM 
      details
    JOIN 
      items
    ON 
      details.item_id = items.item_id
    WHERE
      details.history_id = ?
  ";
  $params = array($history_id);

  return fetch_all_query($db, $sql, $params);
}

// 購入履歴のインサート関数
function insert_history($db, $user_id){
  $sql = "
  INSERT INTO 
    history(
      user_id, 
      created
    )
  VALUES (?, CURRENT_TIMESTAMP);
  ";

  $params = array($user_id);

  return execute_query($db, $sql, $params);
}

// 購入明細のインサート関数
function insert_details($db, $item_id, $price, $amount, $history_id){

  $sql = "
    INSERT INTO 
      details(
        item_id, 
        price, 
        amount, 
        history_id
      ) 
    VALUES(?, ?, ?, ?);
  ";

  $params = array($item_id, $price, $amount, $history_id);

  return execute_query($db, $sql, $params);
}