<?php
session_start();
include 'connect.php'; // Include the database connection




// Check the user type and set $isMember
if (!isset($_SESSION['usertype'])) {
    $_SESSION['usertype'] = ''; 
}



// Function to fetch products from the database
function getProducts($conn) {
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to calculate total and determine free product eligibility
function calculateFreeProduct($isMember, $cart, $products) {
    $total = 0;
    $cheapest = PHP_INT_MAX;

    foreach ($cart as $pid => $quantity) {
        foreach ($products as $product) {
            if ($product['pid'] == $pid) {
                $price = $product['price'];
                $total += $price * $quantity;
                if ($price < $cheapest) {
                    $cheapest = $price;
                }
            }
        }
    }

    // Members always get a free product, non-members if total > 500 baht
    if ($isMember == 'cus' || $total > 500) {
        return $cheapest;  // Return the value of the cheapest product
    }
    return 0;
}

// Fetch available products from the database
$products = getProducts($conn);

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle actions (add, update, delete)
if (isset($_GET["action"])) {
    $pid = $_GET["pid"];
    
    if ($_GET["action"] == "add") {
        // Add to cart
        $qty = (int)$_POST["qty"];
        $pid = (int)$_GET["pid"];
        
        // Check stock
        $stmt = $conn->prepare("SELECT stock FROM product WHERE pid = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if (!$product) {
            echo "Product not found!";
            exit();
        }
    
        $stock = $product['stock'];
    
        if ($qty > $stock) {
            echo "Quantity exceeds stock!";
            exit();
        }
    
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] += $qty;
        } else {
            $_SESSION['cart'][$pid] = $qty;
        }
    
        echo "Product added to cart successfully.";
    }elseif ($_GET["action"] == "update") {
        // Update cart quantity
        $qty = $_POST["qty"];

        // Check stock
        $stmt = $conn->prepare("SELECT stock FROM product WHERE pid = :pid");
        $stmt->execute(['pid' => $pid]);
        $product = $stmt->fetch();
        $stock = $product['stock'];

        if ($qty > $stock) {
            echo "Quantity exceeds stock!";
            exit();
        }

        $_SESSION['cart'][$pid] = $qty;

    } elseif ($_GET["action"] == "delete") {
        // Remove item from cart
        unset($_SESSION['cart'][$pid]);
    }
}

// Calculate free product eligibility
$freeProductValue = calculateFreeProduct($_SESSION['usertype'], $_SESSION['cart'], $products);

// Handle customer choice to use or not use the free product
$useFreeProduct = isset($_POST['use_free_product']) ? true : false;

// Display the shopping cart
$total = 0;
echo "<h3>Shopping Cart</h3>";

if (!empty($_SESSION['cart'])) {
    echo "<h3>Shopping Cart</h3>";
    foreach ($_SESSION["cart"] as $pid => $quantity) {
        foreach ($products as $product) {
            if ($product['pid'] == $pid) {
                echo "<p>" . htmlspecialchars($product['pname']) . " - " . $quantity . " x " . number_format($product['price'], 2) . " baht</p>";
                $total += $product['price'] * $quantity;
            }
        }
    }
    echo "<p>Total: " . number_format($total, 2) . " baht</p>";

    if ($freeProductValue > 0) {
        echo "<form method='post'>";
        echo "<label><input type='checkbox' name='use_free_product' value='1' " . ($useFreeProduct ? "checked" : "") . "> Use free product worth " . $freeProductValue . " baht</label><br>";
        echo "<input type='submit' value='Update Free Product Option'>";
        echo "</form>";

        if ($useFreeProduct) {
            $total -= $freeProductValue; // Apply free product value
            echo "<p>Free product applied: -" . $freeProductValue . " baht</p>";
        }
    } else {
        echo "<p>No free product for this purchase.</p>";
    }

    echo "<p>Total after discount (if applicable): " . $total . " baht</p>";

} else {
    echo "<p>Your cart is empty.</p>";
}

// Close the database connection
$conn->close();
?>
