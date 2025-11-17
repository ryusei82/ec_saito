<?php
// --- DB接続設定（ロリポップ新設定） ---
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

// --- フォーム入力 ---
$name     = isset($_GET['name'])     ? trim($_GET['name'])     : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$rarity   = isset($_GET['rarity'])   ? trim($_GET['rarity'])   : '';
$series   = isset($_GET['series'])   ? trim($_GET['series'])   : '';

// --- SQL組み立て（部分一致検索） ---
$sql = "SELECT card_name, category, rarity, title, url FROM product_pro WHERE 1";
$params = [];

if ($name !== '') {
    $sql .= " AND card_name LIKE ?";
    $params[] = "%{$name}%";
}
if ($category !== '' && $category !== '分類') {
    $sql .= " AND category LIKE ?";
    $params[] = "%{$category}%";
}
if ($rarity !== '' && $rarity !== 'レアリティ') {
    $sql .= " AND rarity LIKE ?";
    $params[] = "%{$rarity}%";
}
if ($series !== '' && $series !== 'シリーズ') {
    $sql .= " AND title LIKE ?";
    $params[] = "%{$series}%";
}

// --- 実行 ---
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('クエリエラー: ' . $e->getMessage());
}
?>

<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DeckLab</title>
  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background-color: #f4f4f4;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      padding: 10px 40px;
      border-bottom: 2px solid #ddd;
      position: relative;
    }
    .logo img {
      width: 220px;
      height: auto;
    }
    .menu {
      display: flex;
      align-items: center;
      gap: 25px;
      font-size: 14px;
    }
    .mypage-dropdown {
      position: relative;
      cursor: pointer;
    }
    .mypage-menu {
      display: none;
      position: absolute;
      top: 25px;
      right: 0;
      background-color: #fff;
      border: 1px solid #ccc;
      flex-direction: column;
      width: 140px;
    }
    .mypage-dropdown:hover .mypage-menu {
      display: flex;
    }
    .mypage-menu a {
      padding: 8px 10px;
      text-decoration: none;
      color: #333;
    }
    .mypage-menu a:hover {
      background-color: #f2f2f2;
    }
    .menu img {
      width: 35px;
      height: auto;
    }
    .search-bar {
      background-color: #ddd;
      padding: 20px 0;
      display: flex;
      justify-content: center;
    }
    .search-bar input {
      width: 40%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
    }
    .filters {
      background-color: #ddd;
      padding: 15px 0;
      display: flex;
      justify-content: center;
      gap: 20px;
    }
    .filters select {
      padding: 10px;
      font-size: 15px;
    }
    .products {
      background-color: #f9f9f9;
      padding: 30px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 40px;
    }
    .section-title {
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .card-grid {
      display: flex;
      justify-content: center;
      gap: 60px;
      flex-wrap: wrap;
    }
    .card {
      background-color: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      width: 300px;
      text-align: center;
      transition: transform 0.2s;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card img {
      width: 100%;
      height: auto;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="/2025/開発/img/logo.png" alt="logo">
    </div>
    <div class="menu">
      <span>ログイン・登録</span>
      <div class="mypage-dropdown">
        <span>マイページ ▼</span>
        <div class="mypage-menu">
          <a href="#">購入履歴</a>
          <a href="#">住所登録</a>
          <a href="#">支払い方法</a>
          <a href="#">ログアウト</a>
        </div>
      </div>
      <img src="/2025/開発/img/cart.jpg" alt="cart">
    </div>
  </header>

  <form method="GET" action="" class="search-bar" role="search" aria-label="検索">
    <input type="text" name="name" placeholder="キーワードを入力" value="<?= htmlspecialchars($name) ?>">
  </form>

  <div class="filters">
    <form method="GET" action="" style="display:flex; gap:20px; align-items:center;">
      <select name="category">
        <option <?= $category === '' ? 'selected' : '' ?>>分類</option>
        <option value="ポケモン" <?= $category === 'ポケモン' ? 'selected' : '' ?>>ポケモンカード</option>
        <option value="遊戯王" <?= $category === '遊戯王' ? 'selected' : '' ?>>遊戯王カード</option>
        <option value="デュエル・マスターズ" <?= $category === 'デュエル・マスターズ' ? 'selected' : '' ?>>デュエル・マスターズ</option>
      </select>
      <select name="rarity">
        <option <?= $rarity === '' ? 'selected' : '' ?>>レアリティ</option>
        <option value="ノーマル" <?= $rarity === 'ノーマル' ? 'selected' : '' ?>>ノーマル</option>
        <option value="レア" <?= $rarity === 'レア' ? 'selected' : '' ?>>レア</option>
        <option value="スーパーレア" <?= $rarity === 'スーパーレア' ? 'selected' : '' ?>>スーパーレア</option>
      </select>
      <select name="series">
        <option <?= $series === '' ? 'selected' : '' ?>>シリーズ</option>
        <option value="ソード＆シールド" <?= $series === 'ソード＆シールド' ? 'selected' : '' ?>>ソード＆シールド</option>
        <option value="サン＆ムーン" <?= $series === 'サン＆ムーン' ? 'selected' : '' ?>>サン＆ムーン</option>
      </select>
      <button type="submit" style="padding:10px 14px; border:none; border-radius:4px; background:#333; color:#fff; cursor:pointer;">検索</button>
    </form>
  </div>

  <div class="products">
    <div class="section-title">検索結果</div>
    <div class="card-grid">
      <?php
        if (empty($cards)) {
            echo '<div style="color:#666; text-align:center; width:100%;">該当するカードが見つかりません。</div>';
        } else {
            foreach ($cards as $c) {
                $img = htmlspecialchars($c['url']);
                $title = htmlspecialchars($c['card_name']);
                echo '<div class="card">';
                echo    '<img src="' . $img . '" alt="' . $title . '">';
                echo    '<div>' . $title . '</div>';
                echo '</div>';
            }
        }
      ?>
    </div>
  </div>
</body>
</html>
