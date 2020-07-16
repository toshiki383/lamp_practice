<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include VIEW_PATH . 'templates/head.php'; ?>
        <title>購入履歴</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
    </head>
    <body>
        <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
        <h1>購入履歴</h1>

        <div class="container">
            <?php include VIEW_PATH . 'templates/messages.php'; ?>
            <?php if(count($historys) > 0){ ?>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>注文番号</th>
                            <?php if(is_admin($user)){ ?>
                            <th>購入者ID</th>
                            <?php } ?>
                            <th>購入日時</th>
                            <th>合計金額</th>
                            <th>購入履歴明細</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($historys as $history){?>
                            <tr>
                                <td><?php print h($history['history_id']);?></td>
                                <?php if(is_admin($user)){ ?>
                                <td><?php print h($history['user_id']);?></td>
                                <?php } ?>
                                <td><?php print h($history['created']);?></td>
                                <td><?php print h(number_format($history['sum']));?></td>
                                <td>
                                    <a href="details.php?history_id=<?php print h($history['history_id']);?>">購入明細表示</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php  } else { ?>
                <p>購入履歴はありません。</p>
            <?php } ?>
        </div>
    </body>
</html>