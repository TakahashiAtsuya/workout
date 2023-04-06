<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $record_id = $_POST["record_id"];

    $sql = "DELETE FROM records WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $record_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    header("Location: view_record.php");
    exit;
}
