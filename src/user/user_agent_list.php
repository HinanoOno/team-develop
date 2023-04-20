<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <title>エージェント検索一覧</title>
</head>

<body>
  <?php include(dirname(__FILE__) . '/../components/header.php'); ?>
  <section class="">
    <div>
      <h1>SEARCH</h1>
      <span>-エージェント検索-</span>
    </div>
    <div>
      <img src="" alt="shopping_cart">
    </div>
  </section>

  <main class="grid grid-cols-2">
    <div class="m-8">
      <div class="major">
        <!-- font-awsomeで入れてく--->
        <h2>専攻</h2>
        <input type="checkbox" id="major1" class="check-label" value="">
        <label for="major1" class="label-hover">文系</label>
        <input type="checkbox" id="major2">
        <label for="major2">理系</label>
      </div>
      <div class="contact">
        <h2>面談方法</h2>
        <input type="checkbox" id="contact1">
        <label for="contact1">メール</label>
        <input type="checkbox" id="contact1">
        <label for="contact1">電話</label>
        <input type="checkbox" id="contact1">
        <label for="contact1">オフライン</label>
      </div>
      <div class="area">
        <h2>エリア</h2>
        <input type="checkbox" id="area1">
        <label for="area1">東京</label>
        <input type="checkbox" id="area2">
        <label for="area2">大阪</label>
        <input type="checkbox" id="area3">
        <label for="area3">名古屋</label>
        <input type="checkbox" id="area4">
        <label for="area4">福岡</label>
      </div>
      <button class="btn-big blue">検索</button>
    </div>
    <div>
      <h3><span>1</span>件ヒット</h3>
      <!-- dbからエージェント一覧もってきてリストに追加 -->
      <div class="agent-list">
        <!-- ダミーとしてマイナビ新卒紹介 -->
        <div>
          <div class="top">
            <img src="" alt="エージェント画像">
            <div>
              <h2>マイナビ新卒紹介</h2>
              <div>
                <h3>業界最高峰の求人数</h3>
                <p>様々な分野に挑戦してみたい、選考対策まで行って欲しい人におすすめです</p>
              </div>
            </div>
          </div>
          <div class="buttom">
            <div class="labels">
              <span>文系</span>
              <span>オンライン</span>
              <span>東京</span>
            </div>
            <div class="block">
              <button class="btn-big blue">カートに追加する</button>
              <button class="btn-big blue">詳細を見る→</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
