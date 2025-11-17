<?php
session_start();

// --- ロリポップのDB接続設定 ---
$host = 'mysql323.phy.lolipop.lan';
$dbname = 'LAA1607659-php';
$user = 'LAA1607659';
$pass = 'Pass0324';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// --- フォームからのデータ取得 ---
$email = $_POST['M_adoresu'] ?? '';
$password = $_POST['password'] ?? '';

// --- 入力チェック ---
if (empty($email) || empty($password)) {
    exit('メールアドレスとパスワードを入力してください。<br><a href="login.php">戻る</a>');
}

// --- ユーザー情報をDBから取得 ---
$sql = $pdo->prepare("SELECT * FROM users WHERE M_adoresu = ?");
$sql->execute([$email]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

// --- ログイン判定 ---
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
        'user_id' => $user['user_id'],
        'name' => $user['name'],
        'M_adoresu' => $user['M_adoresu'],
        'admin_active' => $user['admin_active']
    ];

    // ログイン成功 → Topページへ
    header('Location: Top.php');
    exit();
} else {
    echo "<p>メールアドレスまたはパスワードが違います。</p>";
    echo '<a href="login.php">戻る</a>';
}
?>
