<?php 
  include "connect.php"; 
  session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>CS Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="mobile-web-app-capable" content="yes">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="mcss.css" rel="stylesheet" type="text/css" />
  <script src="mpage.js"></script>
  <style>
    table {
      margin: auto;
      width: 80%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #4caf50;
      color: white;
    }

    

    .order {
      color: blue;
    }

   

    .no-results {
      text-align: center;
      color: red;
    }

    .logout, .login {
      border: 1px solid black;
      border-radius: 5px;
      padding: 5px 10px;
      background-color: lawngreen;
      color: black;
      text-decoration: none;
    }

    
    .LI_LO_button {
      position: absolute;
      top: 70px;
      right: 20px;
    }

    .product_search{
       
       margin: 10px;
       border: 1px black solid;
       border-radius: 3px;
       background-color: darkseagreen;
     }
     .product_search a{
       color: black;
      
     }
  </style>
</head>

<body>

  <header>
    <div class="logo">
      <img src="cslogo.png" width="200" alt="Site Logo">
    </div>
    <div class="search">
      <form method="get" action="">
        <input type="text" name="keyword" placeholder="search products">
        <input type="submit" value="ค้นหา">
      </form>
    </div>
    <div class="LI_LO_button">

      <?php 

        if (!isset($_SESSION['username'])) {
          echo "<a class='login' href='./cart/login-form.php'>เข้าสู่ระบบ</a>";
        } else {
          echo "<a class='logout' href='./cart/logout.php'>ออกจากระบบ</a>";
        }
      ?>
    </div>
  </header>

  <main>
    <article>
      <?php
      // Check if a search keyword is submitted
      if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = '%' . $_GET['keyword'] . '%';

        // Query to search for products
        $stmt = $pdo->prepare("SELECT * FROM product WHERE pname LIKE ?");
        $stmt->bindParam(1, $keyword); 
        $stmt->execute();
        $products = $stmt->fetchAll();

        // If search results are available, display them
        if ($products):
      ?>
          <h2>ผลการค้นหาสินค้า</h2>
          <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <?php foreach ($products as $product): ?>
              <div style="padding: 15px; text-align: center;" class="product_search">
                <a href="./product_php/detailproduct.php?pid=<?= htmlspecialchars($product["pid"]) ?>">
                  <img src='./pphoto/<?= htmlspecialchars($product["pid"]) ?>.jpg' width='100'><br>
                  <?= htmlspecialchars($product["pname"]) ?><br>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="no-results">ไม่พบสินค้าที่ตรงกับการค้นหา</p>
        <?php endif; ?>

      <?php 
      } else {
        // If no search keyword, display the original content
        session_start();

        $username = $_SESSION['username'];
      
        // Query to get the user type (admin or customer)
        $stmt = $pdo->prepare("SELECT type FROM member WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
      
        // Check user type
        if ($user['type'] == 'admin') {
          // If user is admin, show orders from all users
          $stmt = $pdo->prepare("SELECT o.ord_id, o.username, o.ord_date, p.pname, i.quantity, p.price 
                                  FROM orders o
                                  JOIN item i ON o.ord_id = i.ord_id
                                  JOIN product p ON i.pid = p.pid
                                  ORDER BY o.username");
          $stmt->execute();
          $orders = $stmt->fetchAll();
          $title = "คำสั่งซื้อทั้งหมด";
        } else {
          // If user is a customer, show only their orders
          $stmt = $pdo->prepare("SELECT o.ord_id, o.username, o.ord_date, p.pname, i.quantity, p.price 
                                  FROM orders o
                                  JOIN item i ON o.ord_id = i.ord_id
                                  JOIN product p ON i.pid = p.pid
                                  WHERE o.username = :username");
          $stmt->execute(['username' => $username]);
          $orders = $stmt->fetchAll();
          $title = "รายการสั่งซื้อของคุณ";
        }
      ?>

          <div style="margin:auto">
          
          <h1>Welcome</h1>
          <div>
            <h1 style="margin:auto">ยินดีต้อนรับ, <?= htmlspecialchars($username) ?>!</h1>
          </div>

          <h2><?$title?></h2>
          
          <table border="1">
            <thead>
              <tr>
                <th>หมายเลขคำสั่งซื้อ</th>
                <th>username</th>
                <th>วันที่</th>
                <th>ชื่อสินค้า</th>
                <th>จำนวน</th>
                <th>ราคา</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($orders) > 0): ?>
                <?php foreach ($orders as $order): ?>
                  <tr>
                    <td><?= htmlspecialchars($order['ord_id']) ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['ord_date']) ?></td>
                    <td><?= htmlspecialchars($order['pname']) ?></td>
                    <td><?= htmlspecialchars($order['quantity']) ?></td>
                    <td><?= htmlspecialchars($order['price'] * $order['quantity']) ?> บาท</td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6">ไม่มีรายการสั่งซื้อ</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      <?php } ?>

    </article>

    <nav id="menu">
      <h2>Navigation</h2>
      <ul class="menu">
      <li class="dead"><a href="./index.php">Home</a></li>
          <li><a href="./product_php/display_products.php">All Products</a></li>
          <li><a href="./product_php/table_product.php">Table of All Products</a></li>
          <li><a href="./cart/store.php">Buy Products</a></li>
          <li><a href="./cart/cart.php">Cart</a></li>
          <li><a href="./member_php/member.php">All Member</a></li>
          <li><a href="./insert_product.php">Insert Products</a></li>
          <li><a href="./insert_member.php">Insert Member</a></li>
          <li><a href="./member_php/edit_member.php">Delete/edit Member</a></li>
          <li><a href="./product_php/edit_product.php">Delete/edit product</a></li>
          <li><a href="./workshop/ws1.php">Workshop1</a></li>
          <li><a href="./workshop/ws2.php">Workshop2</a></li>
          <li><a href="./workshop/ws3.php">Workshop3</a></li>
          <li><a href="./workshop/ws4.php">Workshop4</a></li>
          <li><a href="./workshop/ws5.php">Workshop5</a></li>
          <li><a href="./workshop/ws6.php">Workshop6</a></li>
          <li><a href="./workshop/ws7.php">Workshop7</a></li>
          <li><a href="./workshop/ws8.php">Workshop8</a></li>
          <li><a href="./workshop/ws9.php">Workshop9</a></li>
          <li><a href="./lab7.php">Lab7</a></li>
          <li><a href="./labAjax_json/json/hospital.html">hospital</a></li>
          <li><a href="./labAjax_json/json//Lab_JSON_12_1.html">Lab_JSON_12_1</a></li>
          <li><a href="./labAjax_json/AJAX/LabAJAXno1/ws1.html">LabAJAXno1</a></li>
          <li><a href="./labAjax_json/AJAX/LabAJAXno2/search.html">LabAJAXno2</a></li>
          <li><a href="./labAjax_json/AJAX/LectureP14-18_registry/registry.html">LectureP14-18_registry</a></li>
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
