<?php session_start(); 

include 'connect.php';
	
			
		?>
		<?php
			if(!isset($_SESSION['cart'])){
				$_SESSION['cart']=array();
			}	
			?>
			
				
			
			<a href="./cartt.php?action=">สินค้าในตะกร้า (<?=sizeof($_SESSION['cart'])?>)</a>
			<div style="display:flex">	
			<?php
				$stmt = $pdo->prepare("SELECT * FROM product");
				$stmt->execute();
				while ($row = $stmt->fetch()) { 
			?>
				<div style="padding: 15px; text-align: center" class="product">
					<a href="">
						<img src='../../csshop/pphoto/<?=$row["pid"]?>.jpg' width='100'></a><br>
					<?=$row ["pname"]?><br><?=$row ["price"]?> บาท<br>	
					<form method="post" action="./cartt.php?action=add&pid=<?=$row["pid"]?>&pname=<?=$row["pname"]?>&price=<?=$row["price"]?>">
						<input type="number" name="qty" value="1" min="1" max="9">
                        
						<input type="submit" value="ซื้อ">	   
					</form>
				</div>
			<?php } ?>
            
			</div>