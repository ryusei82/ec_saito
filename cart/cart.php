<?php
// ==============================
// データベース接続（ロリポップ用設定）
// ==============================
const SERVER = 'mysql323.phy.lolipop.lan';
const DBNAME = 'LAA1607659-php';
const USER = 'LAA1607659';
const PASS = 'Pass0324';

try {
    $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8mb4', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// ==============================
// 商品情報取得（product_proテーブル）
// ==============================
$sql = "SELECT model_number, card_name, status, price, quantity, url 
        FROM product_pro";
$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品一覧 - DeckLab</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #e9f0e6;
      margin: 0;
      padding: 0;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 60px;
      background-color: #e9f0e6;
    }

    .header-left img.logo {
      width: 220px;
      height: auto;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .header-right img {
      width: 60px;
      height: auto;
    }

    header a {
      text-decoration: none;
      color: #333;
      font-size: 16px;
    }

    main {
      background-color: #e9f0e6;
      max-width: 900px;
      margin: 0 auto;
      padding: 20px 30px 40px;
    }

    h1 {
      font-size: 30px;
      font-weight: bold;
      margin: 0 0 15px 0;
      color: #333;
    }

    h3 {
      font-size: 20px;
      margin: 20px 0 10px 0;
      color: #333;
    }

    .item {
      display: flex;
      align-items: flex-start;
      gap: 25px;
      background: #f7f7f7;
      border-radius: 10px;
      padding: 15px 20px;
      margin-top: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .item img {
      width: 150px;
      border-radius: 8px;
      object-fit: cover;
    }

    .item-info {
      flex: 1;
    }

    .item-info p {
      margin: 5px 0;
      font-size: 15px;
      color: #333;
    }

    .item-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
    }

    .item-actions button {
      border: none;
      background: #f4f4f4;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      font-size: 16px;
      cursor: pointer;
      transition: 0.2s;
    }

    .item-actions button:hover {
      background-color: #ddd;
    }

    .delete-btn {
      background-color: #fff;
      border: 1px solid #ccc;
      color: #d33;
    }

    .item-actions span {
      min-width: 20px;
      text-align: center;
      font-weight: bold;
      font-size: 15px;
    }

    .cart-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .cart-buttons button {
      flex: 1;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      border: none;
      margin: 0 10px;
      transition: 0.3s;
    }

    .continue-btn {
      background-color: #fff;
      border: 2px solid #888;
      color: #333;
    }

    .continue-btn:hover {
      background-color: #f3f3f3;
    }

    .checkout-btn {
      background-color: #5a4fcf;
      color: white;
    }

    .checkout-btn:hover {
      background-color: #463eb5;
    }
  </style>
</head>
<body>

  <header>
    <div class="header-left">
      <img src="img/logo.png" alt="DeckLab" class="logo">
    </div>

    <div class="header-right">
      <img src="img/cart.jpg" alt="カートアイコン" />
      <div>
        <a href="#">ログイン・登録</a><br>
        <a href="#">マイページ</a>
      </div>
    </div>
  </header>

  <main>
    <h1>商品一覧</h1>

    <?php if (empty($items)): ?>
      <p>商品が登録されていません。</p>
    <?php else: ?>
      <?php $index = 1; ?>
      <?php foreach ($items as $item): ?>
        <h3><?= $index ?>点目</h3>
        <div class="item">
          <img src="<?= htmlspecialchars($item['url']) ?>" alt="カード画像">
          <div class="item-info">
            <p><strong><?= htmlspecialchars($item['card_name']) ?></strong></p>
            <p>型番：<?= htmlspecialchars($item['model_number']) ?></p>
            <p>状態：<?= htmlspecialchars($item['status']) ?></p>
            <p>価格：¥ <?= number_format($item['price']) ?></p>
            <p>在庫数：<?= htmlspecialchars($item['quantity']) ?></p>
          </div>
        </div>
        <?php $index++; ?>
      <?php endforeach; ?>
    <?php endif; ?>

    <div class="cart-buttons">
      <button class="continue-btn">買い物を続ける</button>
      <button class="checkout-btn">購入へ進む</button>
    </div>
  </main>

</body>
</html>
