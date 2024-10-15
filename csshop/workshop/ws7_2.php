<?php include "../connect.php" ?>

<!doctype html>
<html lang="en">


  <head>
    <meta charset="utf-8">
    <title>CS Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../mcss.css" rel="stylesheet" type="text/css" />
    <script src="../mpage.js"></script>
    <style>
            table,th,td {
                border:1px solid black;
                padding : 2px;
            }
        </style>
  </head>

  <body>

    <header>
      <div class="logo">
        <img src="../cslogo.png" width="200" alt="Site Logo">
      </div>
      
    </header>

    <div class="mobile_bar">
      <a href="#"><img src="responsive-demo-home.gif" alt="Home"></a>
      <a href="#" onClick='toggle_visibility("menu"); return false;'><img src="responsive-demo-menu.gif" alt="Menu"></a>
    </div>

    <main>
      <article>
        <h1>Workshop7 add member</h1>
        <?php 
            $stmt = $pdo->prepare("INSERT INTO member  VALUES (?,?,?,?,?,?)");
            $stmt->bindParam(1,$_POST["username"]);
            $stmt->bindParam(2,$_POST["password"]);
            $stmt->bindParam(3,$_POST["name"]);
            $stmt->bindParam(4,$_POST["address"]);
            $stmt->bindParam(5,$_POST["mobile"]);
            $stmt->bindParam(6,$_POST["email"]);
            $stmt->execute();

            $username = $_POST["username"];


        ?>
        <div>
        เพิ่มสมาชิกสำเร็จ username คือ <?=$username?>
        </div>
      </article>
      <nav id="menu">
        <h2>Navigation</h2>
        <ul class="menu">
        <li class="dead"><a href="../index.php">Home</a></li>
          <li><a href="../product_php/display_products.php">All Products</a></li>
          <li><a href="../product_php/table_product.php">Table of All Products</a></li>
          <li><a href="../cart/store.php">Buy Products</a></li>
          <li><a href="../cart/cart.php">Cart</a></li>
          <li><a href="../member_php/member.php">All Member</a></li>
          <li><a href="../insert_product.php">Insert Products</a></li>
          <li><a href="../insert_member.php">Insert Member</a></li>
          <li><a href="../member_php/edit_member.php">Delete/edit Member</a></li>
          <li><a href="../product_php/edit_product.php">Delete/edit product</a></li>
          <li><a href="./ws1.php">Workshop1</a></li>
          <li><a href="./ws2.php">Workshop2</a></li>
          <li><a href="./ws3.php">Workshop3</a></li>
          <li><a href="./ws4.php">Workshop4</a></li>
          <li><a href="./ws5.php">Workshop5</a></li>
          <li><a href="./ws6.php">Workshop6</a></li>
          <li><a href="./ws7.php">Workshop7</a></li>
          <li><a href="./ws8.php">Workshop8</a></li>
          <li><a href="./ws9.php">Workshop9</a></li>
          <li><a href="../lab7.php">Lab7</a></li>
          <li><a href="../labAjax_json/json/hospital.html">hospital</a></li>
          <li><a href="../labAjax_json/json//Lab_JSON_12_1.html">Lab_JSON_12_1</a></li>
          <li><a href="../labAjax_json/AJAX/LabAJAXno1/ws1.html">LabAJAXno1</a></li>
          <li><a href="../labAjax_json/AJAX/LabAJAXno2/search.html">LabAJAXno2</a></li>
          <li><a href="../labAjax_json/AJAX/LectureP14-18_registry/registry.html">LectureP14-18_registry</a></li>
        </ul>
      </nav>
      <aside>
      <h2>จัดทำโดย</h2>
      <p>6504062663061</p>
      <p>นายจิรัฐกาญจน์ ชูจันทร์</p>
      <p>CSB</p>
    </aside>
    </main>
    <footer>
      <a href="#">Sitemap</a>
      <a href="#">Contact</a>
      <a href="#">Privacy</a>
    </footer>
  </body>
</html>












