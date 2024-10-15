<?php 
include "connect.php"; 

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    
    $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ?");
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $row = $stmt->fetch();

    
    if (!$row) {
        echo "okay";
    } else {
        echo "denied";
    }
}
?>
