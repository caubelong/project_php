<?php
include_once ('lib/database.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $pro_id=$_POST['productId'];
    $sql = "DELETE FROM product ";
    $sql .= "WHERE productId='" .$pro_id. "' ";
    $result=mysqli_query($db,$sql);
    $_SESSION['new_product_sucsses'] = '<h2>'.'delete thanh cong'.'</h2>';
    dedirec_to('product_index.php');
} else {
    if(!isset($_GET['ProductId'])) {
        dedirec_to('product_index.php');
    }
    $id = $_GET['ProductId'];
    $sql="SELECT*FROM product WHERE productId ='".$id."'";
    $result = mysqli_query($db,$sql);
    $product=mysqli_fetch_assoc($result);
}

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Delete Book</title>
        <style>
            .label {
                font-weight: bold;
                font-size: large;
            }
        </style>
    </head>
    <body>
    <?php $_SESSION['check_action'] = ''; ?>
    <h1>Delete Book</h1>
    <h2>Are you sure you want to delete this book?</h2>
    <p><span class="label">Product Name: </span><?php echo $product['NAME']; ?></p>
    <p><span class="label">Price: </span><?php echo $product['Price']; ?></p>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        <input type="hidden" name="productId" value="<?php echo $product['ProductId']; ?>" >

        <input type="submit" name="submit" value="Delete Book">

    </form>

    <br><br>
    <a href="product_index.php">Back to index Product</a>
    </body>
    </html>

