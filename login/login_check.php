<?php
session_start();

$host = 'mysql323.phy.lolipop.lan';
$dbname = 'LAA1607659-php';
$user = 'LAA1607659';
$pass = 'Pass0324';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['login_error'] = "DB接続エラー: " . $e->getMessage();
    header('Location: login.php');
    exit;
}

// フォームの値取得
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// データベース検索
$stmt = $pdo->prepare("SELECT * FROM user_pro WHERE M_adoresu = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


// パスワード照合
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['customer'] = [
        'user_id' => $user['user_id'],
        'name' => $user['name'],
        'M_adoresu' => $user['M_adoresu'],
        'admin_active' => $user['admin_active']
    ];
    header('Location: TOPindex.html');
    exit;
} else {
    $_SESSION['login_error'] = "メールアドレスまたはパスワードが違います。";
    header('Location: login.php');
    exit;
}
?>
