<?php

session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/user_agent_filter.php');

if (isset($_SESSION['clients'])) {
  $count = count($_SESSION['clients']);
  $clients = $_SESSION['clients'];
}

$pdo = Database::get();
$labels = $pdo->query("SELECT * FROM labels")->fetchAll(PDO::FETCH_ASSOC);
$agent_labels = $pdo->query("SELECT * FROM label_client_relation INNER JOIN labels ON label_client_relation.label_id = labels.label_id")->fetchAll(PDO::FETCH_ASSOC);


$agents = $pdo->query("SELECT * FROM clients WHERE ended_at >= CURDATE() AND exist=1")->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../user/assets/styles/badge.css
  ">
  <link rel="stylesheet" href="../user/assets/styles/search.css">
  <link rel="stylesheet" href="../user/assets/styles/header.css">
  <link rel="stylesheet" href="../user/assets/styles/modal.css
  ">
  <link rel="stylesheet" href="../user/assets/styles/form.css
  ">
  <script src="./assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="./assets/js/filter.js" defer></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer></script>

    <!--Google Fonts読み込み-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&amp;family=Plus+Jakarta+Sans:wght@400;700&amp;display=swap" rel="stylesheet">

  <title>エージェント検索一覧</title>
</head>

<body>
  <!-- <header>
    <div class="header_wrapper">
      <div class="header_upper">
        <div class="craft_logo">CRAFT</div>
        <div class="boozer_logo"><img src="../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
      </div>
  </header> -->

  <section class="search">
    <div class="title-wrapper">
      <h1 class="search-title">エージェント検索</h1>
      <span class="search-title-jpn">-SEARCH-</span>
      <div class="search-title-border"></div>
    </div>
    <div class="cart relative">
      <? if (isset($clients)) {
        foreach ($clients as $client) { ?>
          <input type="hidden" class="input" name="agents[]" value="<?= $client['agent'] ?>">
        <? }
      } ?>
      <div class="notifier new">
        <div class="cart-badge badge num">
          <?php if (isset($count)) { ?>
            <?= $count ?>
          <?php } else{?>
            0
          <?php }?>
        </div>
        <div class="search-title-cart-border">
          <a href="./user_cartlook.php">
            <img class="search-title-cart" src="../user/assets/img/728.png" alt="shopping_cart">
          </a>
        </div>
      </div>
    </div>
  </section>
  <div class="overlay" id="js-overlay"></div>

  <div id="modal-content" class="modal-content">
    <div class="check-message">
      <div class="check-circle">
        <div class="check"></div>
      </div>
      <div class="message">カートに追加しました</div>
    </div>
    <div class="modal-cart">
      <div class="cart-link modal-button">
        <a href="./user_cartlook.php">
          <p class="link-message">カート一覧へ</p>
        </a>
      </div>
      <div class="maru">
        <span class="maru-num">
          <?php if (isset($count)) { ?>
            <?= $count ?>
          <?php }else{ ?>
            0
          <?php }?>
        </span>
      </div>
    </div>
  </div>


  <main class="grid grid-cols-2">
    <form method="post" action="" class="m-8 w-3">
      <div class="major">
        <div class="major-container">
          <img class="major-pencil-img" src="../user/assets/img/1263.png" alt="鉛筆の画像">
          <h2 class="major-txt">専攻</h2>
        </div>
        <?php for ($i = 1; $i <= 2; $i++) { ?>
          <div class="checkbox-item">
            <input type="checkbox" id="major<?= $i ?>" class="check-label" name="filter" value="<?= $labels[$i - 1]["label_id"] ?>">
            <!-- <label for="major<?= $i ?>" class="label-hover<?= $i ?>"><?= $labels[$i - 1]["label_name"] ?> </label> -->
            <label for="major<?= $i ?>" class="label-hover"><?= $labels[$i - 1]["label_name"] ?> </label>
          </div>
        <?php } ?>
        <!-- <div class="major-border"></div> -->
      </div>
      <div class="contact">
        <div class="contact-container">
          <img class="contact-mail-img" src="../user/assets/img/550.png" alt="メールの画像">
          <h2 class="contact-txt">面談方法</h2>
        </div>
        <div class="contact-checkbox">
          <?php for ($i = 3; $i <= 5; $i++) { ?>
            <div class="checkbox-item">
              <input type="checkbox" id="contact<?= $i ?>" class="check-label contact-checkbox" name="filter" value="<?= $labels[$i - 1]["label_id"] ?>">
              <label for="contact<?= $i ?>" class="label-hover"><?= $labels[$i - 1]["label_name"] ?> </label><br>
            </div>
          <?php } ?>
          <!-- <div class="contact-border"></div> -->
        </div>
      </div>
      <div class="area">
        <div class="area-wrapper">
          <img class="area-point-img" src="../user/assets/img/686.png" alt="ピンの写真">
          <h2 class="area-txt"> エリア </h2>
        </div>
        <div class="area-container">
        <?php for ($i = 6; $i <= 9; $i++) { ?>
          <div class="checkbox-item">
            <input type="checkbox" id="area<?= $i ?>" class="check-label" name="filter" value="<?= $labels[$i - 1]["label_id"] ?>">
            <label for="area<?= $i ?>" class="label-hover"><?= $labels[$i - 1]["label_name"] ?></label><br>
          </div>
        <?php } ?>
        </div>
        <!-- <div class="contact-border"></div> -->
      </div>
    </form>
    <div class="my-16 ">

    <div class="results">
      <img class="results-img" src="./assets/img/629.png" alt="虫眼鏡の画像">
      <p class="results-txt"><span class="results-number"><?= count($agents) ?></span>件ヒット</p>
    </div>
    <div>
        <?php foreach ($agents as $key => $agent) { ?>
          <div class="results-wrapper">
            <div class="agent-item" data-options="<?php foreach ($agent_labels as $agent_label) {
                                                    if ($agent_label['client_id'] == $agent['client_id']) {
                                                      echo htmlspecialchars($agent_label['label_id']) . ' ';
                                                    }
                                                  } ?>">
              <input type="hidden" value="<?= $agent['client_id'] ?> " class="client_id">
              <div class="top agent-list">
                <img class="agent-img" src="<?= $agent["logo_img"] ?>" alt="エージェント画像">
                <div class="list-right">
                  <h2 class="top-title"><?= $agent["service_name"] ?></h2>
                  <div class="top-title-border"></div>
                  <div class="top-description">
                    <h3 class="top-description-title"><?= $agent["catchphrase"] ?></h3>
                    <p><?= $agent["recommend_point1"] ?></p>
                    <p><?= $agent["recommend_point2"] ?></p>
                    <p><?= $agent["recommend_point3"] ?></p>
                  </div>
                </div>
              </div>
              <div class="top-description-border"></div>
              <div class="bottom">
                <div class="labels">
                  <?php foreach ($agent_labels as $agent_label) { ?>
                    <?php if ($agent_label["client_id"] == $agent["client_id"]) { ?>
                      <span class="label-major">
                        <?= $agent_label["label_name"] ?>　
                      </span>
                      &nbsp;
                    <?php } ?>
                  <?php } ?>
                </div>
                <div class="block">
                  <button class="btn-big red add-button" id="cart<?= $key + 1 ?>" value="<?= $key ?>">カートに追加する</button>
                  <button class="btn-big blue see-details" id="agent<?= $key + 1 ?>"><a href="http://localhost:8080/user/user_agent_list_disp.php?id=<?= $agent["client_id"] ?>&&client_id=<?=$key?>">詳細を見る→</a></button>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
  </div>

  </main>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(function() {
      //ボタン灰色
      const inputs = $('.input').each(function(index, element) {
        $index = element.value
        $('.add-button').eq($index - 1).prop("disabled", true);
        $('.add-button').eq($index - 1).removeClass("red");
        $('.add-button').eq($index - 1).css('background-color', 'gray');
      })
      //スクロールすると上部に固定させるための設定を関数でまとめる
      function FixedAnime() {
        var headerH = $('.search').outerHeight(true);
        var scroll = $(window).scrollTop();
        if (scroll + 73 >= headerH) { //headerの高さ以上になったら
          $('.search').addClass('move'); //fixedというクラス名を付与
        } else { //それ以外は
          $('.search').removeClass('move'); //fixedというクラス名を除去
        }
      }
      // 画面をスクロールをしたら動かしたい場合の記述
      $(window).scroll(function() {
        FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
      });
      // ページが読み込まれたらすぐに動かしたい場合の記述
      $(window).on('load', function() {
        FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
      });
      $('.add-button').on('click', function(event) {
        $index = this.value
        console.log($index)
        $.ajax({
          type: "POST",
          url: "./user_cartin.php",
          data: {
            id: $index,
            client_id: $('.client_id').eq($index).val(),
          },
          dataType: "json",
          scriptCharset: 'utf-8'
        }).done(function(data) {
          console.log(data);
          $('.modal-content').fadeIn();
          $('.overlay').fadeIn();
          // クリックイベント全てに対しての処理
          $(document).on('click touchend', function(event) {
            // 表示したポップアップ以外の部分をクリックしたとき
            if (!$(event.target).closest('.modal-content').length) {
              $('.modal-content').fadeOut();
              $('.overlay').fadeOut();
            }
          });
          $('.cart-badge').text(data)
          $('.add-button').eq($index).prop("disabled", true);
          $('.add-button').eq($index).removeClass("red");
          $('.add-button').eq($index).css('background-color', 'gray');
          $('.maru-num').text(data)
          //背景グレーとか調整する
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
          alert(errorThrown);
        });
      })
    })
  </script>

</body>

</html>
