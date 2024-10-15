
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
      .product {
        
        margin: 10px;
        border: 1px black solid;
        border-radius: 3px;
        background-color: darkseagreen;
      
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
        <img src="../cslogo.png" width="200" alt="Site Logo">
      </div>
      <div class="search">
      <form method="get" action="">
        <input type="text" name="keyword" placeholder="search products">
        <input type="submit" value="ค้นหา">
      </form>
    </div>
    </header>

    <div class="mobile_bar">
      <a href="#"><img src="responsive-demo-home.gif" alt="Home"></a>
      <a href="#" onClick='toggle_visibility("menu"); return false;'><img src="responsive-demo-menu.gif" alt="Menu"></a>
    </div>

    <main>
      <article>
        <h1>Products</h1>
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
          <div style="display: flex ; justify-content: center;" >
            <?php foreach ($products as $product): ?>
              <div style="padding: 15px; text-align: center;" class="product_search">
                <a href="./detailproduct.php?pid=<?= htmlspecialchars($product["pid"]) ?>">
                  <img src='../pphoto/<?= htmlspecialchars($product["pid"]) ?>.jpg' width='100'><br>
                  <?=$product["pname"]?><br>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="no-results">ไม่พบสินค้าที่ตรงกับการค้นหา</p>
        <?php endif; ?>

      <?php 
      } else {
      ?>
        <div style="display:flex" >
        <?php
            $stmt = $pdo->prepare("SELECT * FROM product");
            $stmt->execute();

            $extensions = ['jpg','png','jpeg'];
        ?>
        <?php while ($row = $stmt->fetch()) : 
            
            $imagePath = '';

            foreach ($extensions as $ext){
                if(file_exists("../pphoto/{$row['pid']}.$ext")){
                    $imagePath = "../pphoto/{$row['pid']}.$ext";
                    break;
                }
            }

            if($imagePath == ''){
                $imagePath = "../pphoto/default-image.jpg";
            }
        ?>
            <div style="padding: 15px; text-align: center" class="product">
                <a href="detailproduct.php?pid=<?=$row["pid"]?>">
                    <img src='../pphoto/<?=$row["pid"]?>' width='100'>
                </a><br>
                <?=$row ["pname"]?><br><?=$row ["price"]?> บาท
            </div>
        <?php endwhile; ?>
        <?php } ?>
      </article>
      <nav id="menu">
        <h2>Navigation</h2>
        <ul class="menu">
        <li class="dead"><a href="../index.php">Home</a></li>
          <li><a href="./display_products.php">All Products</a></li>
          <li><a href="./table_product.php">Table of All Products</a></li>
          <li><a href="../cart/store.php">Buy Products</a></li>
          <li><a href="../cart/cart.php">Cart</a></li>
          <li><a href="../member_php/member.php">All Member</a></li>
          <li><a href="../insert_product.php">Insert Products</a></li>
          <li><a href="../insert_member.php">Insert Member</a></li>
          <li><a href="../member_php/edit_member.php">Delete/edit Member</a></li>
          <li><a href="./edit_product.php">Delete/edit product</a></li>
          <li><a href="../workshop/ws1.php">Workshop1</a></li>
          <li><a href="../workshop/ws2.php">Workshop2</a></li>
          <li><a href="../workshop/ws3.php">Workshop3</a></li>
          <li><a href="../workshop/ws4.php">Workshop4</a></li>
          <li><a href="../workshop/ws5.php">Workshop5</a></li>
          <li><a href="../workshop/ws6.php">Workshop6</a></li>
          <li><a href="../workshop/ws7.php">Workshop7</a></li>
          <li><a href="../workshop/ws8.php">Workshop8</a></li>
          <li><a href="../workshop/ws9.php">Workshop9</a></li>
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