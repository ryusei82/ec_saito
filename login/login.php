<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>DeckLab ログイン</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #e6f0e6;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    @supports (-webkit-touch-callout: none) {
      html, body {
        height: -webkit-fill-available;
      }
    }

    .container {
      width: 90%;
      max-width: 400px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px 25px;
      text-align: center;
      position: relative;
    }

    /* ロゴ */
    .logo {
      width: 60%;
      max-width: 180px;
      height: auto;
      margin-bottom: 15px;
    }

    h1 {
      color: #e64628;
      font-size: 26px;
      margin-bottom: 20px;
    }

    label {
      display: block;
      text-align: left;
      font-size: 15px;
      color: #333;
      margin: 10px 0 4px 5px;
    }

    .input-field {
      width: 100%;
      padding: 12px;
      margin-bottom: 12px;
      border: 2px solid #e64628;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
      transition: 0.2s;
    }

    .input-field:focus {
      outline: none;
      border-color: #ff7f50;
      box-shadow: 0 0 4px rgba(230,70,40,0.3);
    }

    .btn {
      width: 100%;
      background-color: #5a8cff;
      color: white;
      border: none;
      padding: 14px;
      font-size: 17px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 8px;
      transition: 0.2s;
    }

    .btn:hover {
      background-color: #4978e8;
    }

    .link {
      margin-top: 18px;
      color: #0066cc;
      cursor: pointer;
      font-size: 15px;
    }

    .link:hover {
      text-decoration: underline;
    }

    /* メッセージ */
    .message {
      text-align: center;
      font-weight: bold;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      animation: fadeOut 4s forwards;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    @keyframes fadeOut {
      0% { opacity: 1; }
      80% { opacity: 1; }
      100% { opacity: 0; display: none; }
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 22px;
      }
      .container {
        padding: 25px 18px;
      }
      .input-field {
        font-size: 15px;
      }
      .btn {
        font-size: 16px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="img/rogo.png" class="logo" alt="DeckLab ロゴ">
    <h1>ログイン</h1>

    <!-- ✅ メッセージ表示部分 -->
    <?php
    if (isset($_SESSION['signup_success'])) {
        echo '<div class="message success">'.$_SESSION['signup_success'].'</div>';
        unset($_SESSION['signup_success']);
    }

    if (isset($_SESSION['signup_error'])) {
        echo '<div class="message error">'.$_SESSION['signup_error'].'</div>';
        unset($_SESSION['signup_error']);
    }

    if (isset($_SESSION['login_error'])) {
        echo '<div class="message error">'.$_SESSION['login_error'].'</div>';
        unset($_SESSION['login_error']);
    }
    ?>

    <form action="login_check.php" method="post">
      <label>メールアドレス</label>
      <input type="email" name="email" placeholder="example@mail.com" class="input-field" required>

      <label>パスワード</label>
      <input type="password" name="password" placeholder="password" class="input-field" required>

      <button type="submit" class="btn">ログイン</button>
    </form>

    <div class="link" onclick="location.href='signup.php'">新規登録はこちら</div>
  </div>

</body>
</html>
