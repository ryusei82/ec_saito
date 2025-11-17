<?php
// データベース接続設定
const SERVER = 'mysql323.phy.lolipop.lan';
const DBNAME = 'LAA1607659-php';
const USER = 'LAA1607659';
const PASS = 'Pass0324';

$connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';

// ユーザーIDは、実際にはログインセッションなどから取得します。
// ここでは、更新対象のレコードを特定するために仮に1とします。
$user_id = 1; 
$message = ''; // 処理結果メッセージ

// フォームがPOST送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    // フォームからデータを受け取る
    // 数字以外の文字（ハイフン、スペースなど）を削除して取得します
    $card_number = trim(filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_NUMBER_INT));
    $expiry_date_str = trim(filter_input(INPUT_POST, 'expiry_date', FILTER_SANITIZE_STRING)); 
    // セキュリティコードは機密情報のため、DBには登録しません

    // 入力値の基本的な検証
    if (empty($card_number) || empty($expiry_date_str)) {
        $message = "エラー: カード番号と有効期限を入力してください。";
    } else {
        // 有効期限の文字列をDBのDATE型(YYYY-MM-DD)に合わせるための処理
        // 例: '10/25' -> '2025-10-01'
        $expiry_date = null;
        $card_name = 'VISA'; // カード名入力欄がないため、仮に'VISA'とする
        $date_parts = explode('/', $expiry_date_str);
        
        // 月と年（下2桁）が正しく入力されているかチェック
        if (count($date_parts) === 2 && is_numeric($date_parts[0]) && is_numeric($date_parts[1])) {
            $month = str_pad($date_parts[0], 2, '0', STR_PAD_LEFT);
            $year = '20' . $date_parts[1]; // 下2桁を20XX年に変換
            $expiry_date = "{$year}-{$month}-01"; // 日を1日に設定
        }

        if ($expiry_date === null) {
            $message = "エラー: 有効期限の形式が不正です。 (例: MM/YY)";
        } else {
            try {
                // データベースに接続
                $pdo = new PDO($connect, USER, PASS);
                // エラーモードを例外に設定 (推奨)
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // データ登録用のSQL (プリペアドステートメントを使用)
                // user_proテーブルを更新します
                $sql = "
                    UPDATE user_pro 
                    SET 
                        card_number = :card_number, 
                        expiry_date = :expiry_date,
                        card_name = :card_name,
                        registered_at = NOW(),
                        is_active = TRUE
                    WHERE 
                        user_id = :user_id
                ";

                // SQLを準備
                $stmt = $pdo->prepare($sql);

                // 値をバインド
                $stmt->bindParam(':card_number', $card_number, PDO::PARAM_STR);
                $stmt->bindParam(':expiry_date', $expiry_date, PDO::PARAM_STR);
                $stmt->bindParam(':card_name', $card_name, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                // SQLを実行
                $stmt->execute();

                // 更新された行数を取得
                $count = $stmt->rowCount();

                if ($count > 0) {
                    $message = "✅ クレジットカード情報を登録・更新しました。";
                } else {
                    $message = "⚠️ クレジットカード情報の登録・更新に失敗しました。ユーザーID: {$user_id} のレコードが存在しない可能性があります。";
                }

            } catch (PDOException $e) {
                // 接続やSQL実行でエラーが発生した場合
                $message = "❌ データベースエラー: " . $e->getMessage();
            } finally {
                // 接続を閉じる
                $pdo = null;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>クレジットカード登録</title>
  <link rel="stylesheet" href="credit_card.css">
</head>
<body>
  <header class="header">
    <span class="back-arrow">＜</span>
    <h1 class="title">クレジットカード登録</h1>
  </header>

  <main class="content-area">
    <?php if ($message): ?>
      <p><?php echo $message; ?></p>
    <?php endif; ?>
    <p class="instruction-text">以下カードをご利用いただけます</p>

    <div class="card-logos">
      <img src="img/VISA.png" alt="VISA" class="logo">
      <img src="img/mastercard.png" alt="MasterCard" class="logo">
      <img src="img/JCB.png" alt="JCB" class="logo">
      <img src="img/Diners Club.png" alt="Diners Club" class="logo">
      <img src="img/AMERICAN EXPRESS.png" alt="American Express" class="logo">
    </div>
    
  <form action="" method="post">
    <div class="input-section">
      <label for="card-number">カード番号</label>
      <div class="input-group">
        <img src="img/Vector.png" alt="カード" class="logo-icon card-icon">
        <input type="text" id="card-number" name="card_number" placeholder="例：1234 5678 9012 3456" maxlength="16">
        <img src="img/Vector (1).png" alt="カメラ" class="logo-icon camera-icon">
      </div>
      <p class="note-text">※入力は半角数字のみ（ハイフン、スペースなし）</p>
    </div>

    <div class="expiry-security-group">
      <div class="input-section expiry-input-wrapper">
        <label for="expiry-date">有効期限</label>
        <div class="input-group">
          <input type="text" id="expiry-date" name="expiry_date" placeholder="例：10/22" maxlength="5">
        </div>
      </div>
      <div class="input-section security-input-wrapper">
        <label for="security-code">セキュリティコード</label>
        <div class="input-group security-input">
          <input type="text" id="security-code" name="security_code" placeholder="例：123" maxlength="4">
          <div class="help-icon">？</div>
        </div>
      </div>
    </div>

    <div class="security-info-box">
      <p>クレジットカード裏面に記載の3桁の数字です。</p>
      <p>※AMEXは表面右上方に記載の4桁の数字です。</p>
      <div class="info-content">
        <img src="img/security_code_example.png" alt="セキュリティコードの説明画像" class="security-image">
        <button type="button" class="close-btn">✖</button>
      </div>
    </div>
  </main>

  <div class="footer-area">
    <button type="submit" name="register" class="register-btn">
      <img src="img/lock.png" alt="セキュリティコードの説明画像" class="lock-icon">
      クレジットカードを登録
    </button>
    <a href="#" class="back-to-top">TOPに戻る</a>
  </div>
  </form>
</body>
</html>
