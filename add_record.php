<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $exercise = $_POST["exercise"];
    $weight = $_POST["weight"];
    $reps = $_POST["reps"];

    if (empty($date) || empty($exercise) || empty($weight) || empty($reps)) {
        $error = "全てのフィールドを入力してください";
    } else {
        $sql = "INSERT INTO records (user_id, date, exercise, weight, reps) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $date, PDO::PARAM_STR);
        $stmt->bindParam(3, $exercise, PDO::PARAM_STR);
        $stmt->bindParam(4, $weight, PDO::PARAM_INT);
        $stmt->bindParam(5, $reps, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: view_record.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>記録追加</title>
    <link rel="stylesheet" a href="add_record.css">
</head>

<body>
    <h1>記録追加</h1>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="date">日付：</label>
        <input type="date" name="date" id="date"><br>
        <label for="exercise">種目：</label>
        <input type="text" name="exercise" id="exercise"><br>
        <label for="weight">重量(kg)：</label>
        <input type="number" name="weight" id="weight" min="1"><br>
        <label for="reps">回数：</label>
        <input type="number" name="reps" id="reps" min="1"><br>
        <button class="submit" type="submit">記録追加</button>
    </form>
    <div class="link">
        <a href="view_record.php">戻る</a>
    </div>
</body>

</html>