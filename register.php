<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $password =  htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    if (empty($username) || empty($password)) {
        $error = "ユーザー名とパスワードを入力して下さい";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $error = "ユーザー名は既に使われています";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->execute();
            $message = "登録が完了しました！";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <link rel="stylesheet" a href="register.css">
</head>

<body>
    <h1>新規登録</h1>
    <h3>任意のユーザー名とパスワードを入力して下さい</h3>
    <?php if (isset($error)) : ?>
        <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (isset($message)) : ?>
        <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" id="username"><br>
        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password"><br>
        <button class="submit" type="submit">登録</button>
    </form>
        <a href="index.php">戻る</a>
</body>

</html>