<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>トップ画面</title>
  <link rel="stylesheet" href="TOP/top_style.css">
</head>
<body>
  <header>
  
     <img src="logo/TOPlogo.png" alt="DeckLab ロゴ" class="logo">

    <div class="menu">
      <div class = "login-menu">
      <a href = "login/login.php">ログイン・登録</a>
      </div>
      <div class="mypage-dropdown">
        <span>マイページ ▼</span>
        <div class="mypage-menu">
          <a href="rireki/rireki.php">購入履歴</a>
          <a href="#">住所登録</a>
          <a href="#">支払い方法</a>
          <a href="#">ログアウト</a>
        </div>
      </div>
      <a href = "cart/cart.php"><img src="https://cdn-icons-png.flaticon.com/512/34/34627.png" alt="cart" width="25"></a>
    </div>
  </header>

  <div class="search-bar">
    <form action = "product/product.php" method = "post">
    <input type="text" placeholder="キーワードを入力">
    <button>検索</button>
  </div>

  <div class="filters">
    <select><option>分類</option></select>
    <select><option>レアリティ</option></select>
    <select><option>シリーズ</option></select>
  </div>

  <div class="products">
    <div class="section-title">新着商品</div>
    <div class="card-grid">
      <div class="card">
        <img src="img/jarouda_sar.jpg" alt="card">
        <div>○○○○</div>
      </div>
      <div class="card">
        <img src="img/mirokarosu_sar.jpg" alt="card">
        <div>○○○○</div>
      </div>
    </div>

    <div class="brand-scroll">
      <img src="logo/hororaibu.png" alt="brand">
      <img src="logo/pokemon.png" alt="brand">
      <img src="logo/yuugiou.png" alt="brand">
      <img src="logo/pokemon.png" alt="brand">
    </div>

    <div class="card-grid">
      <div class="card">
        <img src="img/nanjamo_sar.jpg" alt="card">
        <div>○○○○</div>
      </div>
      <div class="card">
        <img src="img/resiramu.jpg" alt="card">
        <div>○○○○</div>
      </div>
    </div>
    <br>
    <div class="card-grid">
      <div class="card">
        <img src="img/saanaito.jpg" alt="card">
        <div>○○○○</div>
      </div>
      <div class="card">
        <img src="img/zekuromu.jpg" alt="card">
        <div>○○○○</div>
      </div>
    </div>
    <br>
    <div class="card-grid">
      <div class="card">
        <img src="img/gekkouga.jpg" alt="card">
        <div>○○○○</div>
      </div>
      <div class="card">
        <img src="img/riza-don.jpg" alt="card">
        <div>○○○○</div>
      </div>
    </div>

  </div>
</body>
</html>
