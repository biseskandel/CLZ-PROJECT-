<?php
session_start();
if (!isset($_SESSION['islogin'])) {
    $_SESSION['msg'] = "Invalid Request";
    header('location: index.php');
    exit();
}

include 'includes/dbconnection.php';

try {
    if (isset($_POST['cart_id'])) {
        // Order placement logic
        $cart_id = filter_var($_POST['cart_id'], FILTER_VALIDATE_INT);
        if (!$cart_id) {
            throw new Exception("Invalid cart ID");
        }

        $conn->begin_transaction();

        // Fetch cart details
        $qrycart = $conn->prepare("SELECT * FROM carts WHERE id = ?");
        $qrycart->bind_param("i", $cart_id);
        $qrycart->execute();
        $resultcart = $qrycart->get_result();

        if ($resultcart->num_rows === 0) {
            throw new Exception("Cart not found");
        }
        $rowcart = $resultcart->fetch_assoc();

        // Fetch product details
        $qryprd = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $qryprd->bind_param("i", $rowcart['product_id']);
        $qryprd->execute();
        $resultprd = $qryprd->get_result();

        if ($resultprd->num_rows === 0) {
            throw new Exception("Product not found");
        }
        $rowprd = $resultprd->fetch_assoc();

        if ($rowprd['stock'] < $rowcart['quantity']) {
            throw new Exception("Insufficient stock for this product");
        }

        // Insert order
        $user_id = $_SESSION['userid'];
        $product_id = $rowprd['id'];
        $order_date = date('Y-m-d');
        $quantity = $rowcart['quantity'];
        $status = "Pending";
        $price = $rowprd['price'];

        $qryorder = $conn->prepare("INSERT INTO orders (user_id, product_id, order_date, price, quantity, status) VALUES (?, ?, ?, ?, ?, ?)");
        $qryorder->bind_param("iisdis", $user_id, $product_id, $order_date, $price, $quantity, $status);
        $qryorder->execute();

        // Delete from cart
        $qrydel = $conn->prepare("DELETE FROM carts WHERE id = ?");
        $qrydel->bind_param("i", $cart_id);
        $qrydel->execute();

        // Update stock
        $new_stock = $rowprd['stock'] - $quantity;
        $qrystock = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $qrystock->bind_param("ii", $new_stock, $product_id);
        $qrystock->execute();

        $conn->commit();
        $_SESSION['msg'] = "Order placed successfully";
    } elseif (isset($_GET['deleteid'])) {
        // Order deletion logic
        $deleteid = filter_var($_GET['deleteid'], FILTER_VALIDATE_INT);
        if (!$deleteid) {
            throw new Exception("Invalid order ID");
        }

        $qrydelete = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $qrydelete->bind_param("i", $deleteid);
        $qrydelete->execute();

        if ($qrydelete->affected_rows > 0) {
            
            $_SESSION['msg'] = "Order deleted successfully.";
        } else {
            throw new Exception("Failed to delete the order");
        }
    } else {
        throw new Exception("Invalid action");
    }
} catch (Exception $e) {
    $_SESSION['msg'] = "Error: " . $e->getMessage();
} finally {
    $conn->close();
    $redirect_url = isset($_POST['cart_id']) ? 'carts.php' : 'myorders.php';
    header("Location: $redirect_url");
    exit();
}

