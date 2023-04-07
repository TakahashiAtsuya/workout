<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: view_record.php");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    if (empty($username) || empty($password)) {
        $error = "ユーザー名とパスワードを入力してください。";
    } else {
        $sql = "SELECT id, password FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $hash = $user['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $user['id'];
                header("Location: view_record.php");
                exit;
            } else {
                $error = "ユーザー名またはパスワードが間違っています";
            }
        } else {
            $error = "ユーザー名またはユーザー名が間違っています";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta chaarset="UTF-8">
    <title>ログインページ</title>
    <link rel="stylesheet" a href="login.css">
</head>

<body>
    <h1>ログイン</h1>
    <h3>登録したユーザー名とパスワードを入力して下さい</h3>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" id="username"><br>
        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password"><br>
        <button class="submit" type="submit">ログイン</button>
    </form>
        <a href="index.php">戻る</a>
</body>

</html>
