<?php
const SERVER = 'mysql323.phy.lolipop.lan';
const DBNAME = 'LAA1607659-php';
const USER = 'LAA1607659';
const PASS = 'Pass0324';

$connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細画面</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
<?php
    $product_price = "???"; // 取得できなかった場合のデフォルト値
    $product_quantity_display = "n個"; // 取得できなかった場合のデフォルト値
    $stock_max = 1; // 取得できなかった場合のデフォルト値

    try {
        // データベースへ接続
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // SQL文の準備
        // product_proテーブルの最初の1件を取得する
        $sql = "SELECT price, quantity FROM product_pro LIMIT 1";
        $stmt = $pdo->prepare($sql);
        
        // SQLの実行
        $stmt->execute();
        
        // 結果の取得
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // データを取得できたら価格と在庫数を更新
            $product_price = number_format($row['price']) . "円";
            $product_quantity = number_format($row['quantity']) . "個";
            $stock_max = (int)$row['quantity'];
        }
    } catch (PDOException $e) {
        // データベース接続またはSQLエラーが発生した場合
        echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px; background-color: #fee;'>";
        echo "🚨 **データベース接続またはSQLエラー**<br>";
        echo "メッセージ: **" . htmlspecialchars($e->getMessage()) . "**";
        echo "</div>";
    } finally {
        // 接続を閉じる (PDOオブジェクトをnullにする)
        $pdo = null;
    }
?>
    <header>
  
     <img src="../logo/TOPlogo.png" alt="DeckLab ロゴ" class="logo-image">

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
      <img src="https://cdn-icons-png.flaticon.com/512/34/34627.png" alt="cart" width="25">
    </div>
  </header>

    <div class="search-bar">
        <input type="text" placeholder="何をお探しですか。">
        <button type="submit"><img src="../img/search.png" alt="DeckLab Logo" class="logo-image2"></a></button>
    </div>

    <nav class="breadcrumb">
        <a href="#">Home</a>
        <span>&gt;</span>
        <a href="#">ポケモンカードゲーム</a>
        <span>&gt;</span>
        <span>ゼクロム</span>
    </nav>

    <main class="product-detail">
        <p class="product-category-text">トレカ/ポケモンカードゲーム/ポケモンカードゲーム</p>
        <h1 class="product-title">159/BW-P ゼクロムEX</h1>

        <div class="product-image-container">
            <img src="../img/zekuromu.jpg" alt="159/BW-P ゼクロムEXのカード画像" class="product-image">
        </div>

        <div class="product-info">
            <p class="price-stock-info">価格:<?php echo $product_price; ?></p>
            <p class="price-stock-info">在庫数:<?php echo $product_quantity; ?></p>
        </div>

        <div class="quantity-control">
            <label for="quantity">数量</label>
            <div class="quantity-input-group">
                <button class="quantity-btn minus-btn" aria-label="数量を減らす" id="minus-btn">−</button>
                <input type="number" id="quantity" value="1" min="1" max="<?php echo $stock_max; ?>" class="quantity-input">
                <button class="quantity-btn plus-btn" aria-label="数量を増やす" id="plus-btn">＋</button>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn buy-btn">購入へ進む</button>
            <button class="btn add-to-cart-btn">カートに追加</button>
        </div>
    </main>
    <script>
        const quantityInput = document.getElementById('quantity');
        const minusBtn = document.getElementById('minus-btn');
        const plusBtn = document.getElementById('plus-btn');

        const minVal = parseInt(quantityInput.getAttribute('min'));
        const maxVal = parseInt(quantityInput.getAttribute('max'));

        function updateQuantity(delta) {
            let currentValue = parseInt(quantityInput.value);
            let newValue = currentValue + delta;
            if (newValue >= minVal && newValue <= maxVal) {
                quantityInput.value = newValue;
            } else if (newValue < minVal) {
                console.log(`数量は${minVal}未満にできません。`);
            } else if (newValue > maxVal) {
                console.log(`数量は${maxVal}を超えられません。`);
            }
        }

        minusBtn.addEventListener('click', () => {
            updateQuantity(-1); // -1で数量を減らす
        });

        plusBtn.addEventListener('click', () => {
            updateQuantity(1); // +1で数量を増やす
        });

        quantityInput.addEventListener('change', (event) => {
            let val = parseInt(event.target.value);
            if (isNaN(val) || val < minVal) {
                event.target.value = minVal;
            } else if (val > maxVal) {
                event.target.value = maxVal;
            }
        });
    </script>
</body>
</html>