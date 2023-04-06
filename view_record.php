<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

$sql = "SELECT * FROM records WHERE user_id = ? ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>トレーニング記録</title>
    <link rel="stylesheet" a href="view_record.css">
</head>

<body>
    <h1>トレーニング記録</h1>
    <table>
        <tr>
            <th>日付</th>
            <th>種目</th>
            <th>重量(kg)</th>
            <th>回数</th>
            <th>編集</th>
            <th>削除</th>
        </tr>

        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['exercise']; ?></td>
                <td><?php echo $row['weight']; ?></td>
                <td><?php echo $row['reps']; ?></td>
                <td>
                    <form method="POST" action="edit_record.php">
                        <input type="hidden" name="record_id" value="<?php echo $row['id']; ?>">
                        <button class="edit" type="submit">編集</button>
                    </form>
                </td>
                <td>
                <form method="POST" action="delete_record.php" onsubmit="return confirm('本当に削除しますか？');">
                        <input type="hidden" name="record_id" value="<?php echo $row['id']; ?>">
                        <button class="delete" type="submit">削除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="add_record.php">記録を追加する</a>
    <br>
    <a href="logout.php">ログアウトする</a>
</body>

</html>