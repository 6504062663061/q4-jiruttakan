<?php
include "connect.php";

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    
 
    $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ?");
    $stmt->bindValue(1, $username);
    $stmt->execute();
    $members = $stmt->fetchAll();

    
    if ($members) {
        foreach ($members as $member) {
            $name = htmlspecialchars($member['name']);
            $img =  htmlspecialchars($member['username']);

            echo "<div>";
            echo "<img src='./memphoto/$img' alt='Profile Image' width='100' height='100'>";
            echo "<p>$name</p>";
            echo "</div>";
        }
    } else {
        echo "<p>ไม่พบสมาชิก</p>";
    }
}
?>
