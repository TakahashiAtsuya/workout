<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $record_id = $_POST["record_id"];
    $date = $_POST["date"];
    $exercise = $_POST["exercise"];
    $weight = $_POST["weight"];
    $reps = $_POST["reps"];

    $sql = "UPDATE records SET date=?, exercise=?, weight=?, reps=? WHERE id=? AND user_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $date, PDO::PARAM_STR);
    $stmt->bindParam(2, $exercise, PDO::PARAM_STR);
    $stmt->bindParam(3, $weight, PDO::PARAM_INT);
    $stmt->bindParam(4, $reps, PDO::PARAM_INT);
    $stmt->bindParam(5, $record_id, PDO::PARAM_INT);
    $stmt->bindParam(6, $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    header("Location: view_record.php");
    exit;
}

?>