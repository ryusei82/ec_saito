<?php
// ===== データベース接続設定 =====
const SERVER = 'mysql323.phy.lolipop.lan';
const DBNAME = 'LAA1607659-php';
const USER = 'LAA1607659';
const PASS = 'Pass0324';

try {
  $pdo = new PDO("mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8mb4", USER, PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("DB接続に失敗しました: " . $e->getMessage());
}

// ===== 販売履歴を取得（log_proテーブルから） =====
$sql = "SELECT purchase_date, price, model_number FROM log_pro ORDER BY purchase_date DESC";
$stmt = $pdo->query($sql);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>販売履歴</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #e9f0e6;
      margin: 0;
      padding: 0;
    }

    header {
      display: flex;
      align-items: center;
      padding: 20px 40px;
      background-color: #e9f0e6;
    }

    header img {
      width: 160px;
      height: auto;
    }

    main {
      width: 80%;
      max-width: 900px;
      margin: 40px auto;
      text-align: center;
    }

    h1 {
      background-color: #e0e0e0;
      display: inline-block;
      padding: 8px 40px;
      border-radius: 4px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th {
      background-color: #1565c0;
      color: white;
      padding: 12px;
      font-size: 16px;
    }

    td {
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 15px;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
      border-bottom: 2px solid #000;
      transition: 0.2s;
    }

    .back-link:hover {
      color: #1565c0;
      border-color: #1565c0;
    }

    footer {
      text-align: center;
      padding: 30px;
      background-color: #e9f0e6;
    }
  </style>
</head>
<body>

  <header>
    <img src="img/logo.png" alt="DeckLabロゴ">
  </header>

  <main>
    <h1>販売履歴</h1>

    <table>
      <tr>
        <th>日付</th>
        <th>金額</th>
        <th>型番</th>
      </tr>

      <?php if (count($sales) > 0): ?>
        <?php foreach ($sales as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['purchase_date']) ?></td>
            <td><?= htmlspecialchars(number_format($row['price'])) ?></td>
            <td><?= htmlspecialchars($row['model_number']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="3">販売履歴がありません。</td></tr>
      <?php endif; ?>
    </table>

    <a href="index.php" class="back-link">Topへ戻る</a>
  </main>

  <footer></footer>

</body>
</html>
