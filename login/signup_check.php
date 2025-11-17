<?php
session_start();

// ========================
// 1. DB接続情報（ロリポップ用）
// ========================
$host = 'mysql323.phy.lolipop.lan';          // ロリポップは実際は "localhost" ではなくこの指定
$dbname = 'LAA1607659-php';                  // データベース名
$user = 'LAA1607659';                        // ユーザー名
$pass = 'Pass0324';                          // パスワード

try {
    // ❌ $dsn, $password → 誤り
    // ✅ 正しい形式でPDO接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "DB接続エラー: " . $e->getMessage();
    exit;
}

// ========================
// 2. POSTデータ取得
// ========================
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password_input = $_POST['password'] ?? '';

// 入力チェック
if (empty($name) || empty($email) || empty($password_input)) {
    $_SESSION['signup_error'] = '全ての項目を入力してください。';
    header('Location: signup.php');
    exit;
}

// パスワードをハッシュ化
$password_hashed = password_hash($password_input, PASSWORD_DEFAULT);

// ========================
// 3. 仮データの設定（未入力カラムのため）
// ========================
$user_id = uniqid('user_', true);
$birthdate = '2000-01-01';
$address = '';
$payment_methods = '';
$card_number = '';
$expiry_date = '2099-12-31';
$registered_at = date('Y-m-d H:i:s');
$is_active = 1;
$admin_active = 0;

// ========================
// 4. データベース登録
// ========================
try {
    $sql = "INSERT INTO user_pro 
    (user_id, password, birthdate, address, name, payment_methods, card_number, expiry_date, registered_at, is_active, M_adoresu, admin_active)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $password_hashed,
        $birthdate,
        $address,
        $name,
        $payment_methods,
        $card_number,
        $expiry_date,
        $registered_at,
        $is_active,
        $email,
        $admin_active
    ]);

    // 登録完了メッセージをセッションに格納 → ログイン画面へ遷移
    $_SESSION['signup_success'] = '登録が完了しました！ログインしてください。';
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $_SESSION['signup_error'] = 'このメールアドレスは既に登録されています。';
        header('Location: signup.php');
        exit;
    } else {
        echo "エラー: " . $e->getMessage();
        exit;
    }
}
?>
