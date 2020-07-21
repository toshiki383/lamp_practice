<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
  
    <title>商品一覧</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
  </head>
  <body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

    <div class="container">
      <div style="display : flex; justify-content: space-between;">
        <h1>商品一覧</h1>
        <form method="get">
          <select name="sort">
            <option value="">標準</option>
            <option value="low" <?php if($sort === 'low'){ ?>selected <?php }?>>価格が安い順</option>
            <option value="high" <?php if($sort === 'high'){ ?>selected <?php }?>>価格が高い順</option>
            <option value="new" <?php if($sort === 'new'){ ?>selected <?php }?>>新着順</option>
          </select>
          <input type="submit" value="並び替え">
        </form>
      </div>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>

      <div class="card-deck">
        <div class="row">
          <?php foreach($items as $item){ ?>
            <div class="col-6 item">
              <div class="card h-100 text-center">
                <div class="card-header">
                  <?php print h(($item['name'])); ?>
                </div>
                <figure class="card-body">
                  <img class="card-img" src="<?php print h((IMAGE_PATH . $item['image'])); ?>">
                  <figcaption>
                    <?php print h((number_format($item['price']))); ?>円
                      <?php if($item['stock'] > 0){ ?>
                        <form action="index_add_cart.php" method="post">
                          <input type="hidden" name="csrf_token" value="<?=$token?>">
                          <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                          <input type="hidden" name="item_id" value="<?php print h(($item['item_id'])); ?>">
                        </form>
                      <?php } else { ?>
                      <p class="text-danger">現在売り切れです。</p>
                    <?php } ?>
                  </figcaption>
                </figure>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <h2>人気ランキング</h2>
      <div class="card-deck">
        <div class="row">
          <?php foreach($ranks as $key => $rank){ ?>
            <div class="col-6 item">
              <div class="card h-100 text-center">
                <div>
                <p style="color:red;">人気No.<?php print $key + 1;?>!<p>
                </div>
                  
                <div class="card-header">
              
                  <?php print h(($rank['name'])); ?>
                </div>
                <figure class="card-body">
                  <img class="card-img" src="<?php print h((IMAGE_PATH . $rank['image'])); ?>">
                  <figcaption>
                    <?php print h((number_format($rank['price']))); ?>円
                      <?php if($rank['stock'] > 0){ ?>
                        <form action="index_add_cart.php" method="post">
                          <input type="hidden" name="csrf_token" value="<?=$token?>">
                          <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                          <input type="hidden" name="item_id" value="<?php print h(($rank['item_id'])); ?>">
                        </form>
                      <?php } else { ?>
                      <p class="text-danger">現在売り切れです。</p>
                    <?php } ?>
                  </figcaption>
                </figure>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </body>
</html>