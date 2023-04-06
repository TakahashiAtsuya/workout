<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $record_id = $_POST["record_id"];

    $sql = "SELECT * FROM records WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $record_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>トレーニング記録編集</title>
    <link rel="stylesheet" a href="edit_record.css">
</head>

<body>
    <h1>トレーニング記録編集</h1>
    <form method="POST" action="update_record.php">
        <input type="hidden" name="record_id" value="<?php echo $record['id']; ?>">
        <label for="date">日付:</label>
        <input type="date" id="date" name="date" value="<?php echo $record['date']; ?>">
        <br>
        <label for="exercise">種目:</label>
        <input type="text" id="exercise" name="exercise" value="<?php echo $record['exercise']; ?>">
        <br>
        <label for="weight">重量(kg):</label>
        <input type="number" id="weight" name="weight" value="<?php echo $record['weight']; ?>" min="1">
        <br>
        <label for="reps">回数:</label>
        <input type="number" id="reps" name="reps" value="<?php echo $record['reps']; ?>" min="1">
        <br>
        <button class="submit" type="submit">更新</button>
        <br>
    </form>
    <div class="link">
        <a href="view_record.php">戻る</a>
    </div>
</body>

</html>