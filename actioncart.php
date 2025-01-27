<?php 
session_start();
if(!isset($_SESSION['islogin']))
{
    $_SESSION['msg'] = "Please Login First";
    header('location: login.php');
}

if(isset($_POST['quantity']))
{
    $user_id = $_SESSION['userid'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $qrycheck = "SELECT * FROM carts WHERE user_id = $user_id AND  product_id = $product_id";
    include 'includes/dbconnection.php';
    $resultcheck = mysqli_query($conn, $qrycheck);
    include 'includes/closeconnection.php';
    if(mysqli_num_rows($resultcheck)>0)
    {
        $_SESSION['msg'] = "product Already in cart";
        header ('location: viewproduct.php?id='.$product_id);
    }
    else{
        $qry = "INSERT INTO carts (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        include 'includes/dbconnection.php';
        $result = mysqli_query($conn, $qry);
        include 'includes/closeconnection.php';
        if($result)
        {
            $_SESSION['msg'] = "Product Added to Cart";
            header('location: viewproduct.php?id='.$product_id);
        }
        else{
            $_SESSION['msg'] = "Failed to Add Products to cart";
            header('location: viewproduct.php?id='.$product_id);
        }
    }
}
if(isset($_GET['deleteid']))
{
    $id = $_GET['deleteid'];
    $qry = "DELETE FROM carts WHERE id = $id";
    include 'includes/dbconnection.php';
    $result = mysqli_query($conn, $qry);
    include 'includes/closeconnection.php';
    if($result)
    {
        $_SESSION['msg'] = "Product Removed from Cart";
        header('location: carts.php');
    }
    else
    {
        $_SESSION['msg'] = "Failed to Remove Product from Cart";
        header('location: carts.php');
    }
}
?>
