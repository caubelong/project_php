<?php
include_once "lib/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
if (isset($_SESSION['new_product_sucsses']))
{
    echo $_SESSION['new_product_sucsses'];
}
?>
<a href="new_product.php">Create New Product</a>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post">
    <table class="list">
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Description</th>
            <th>Picture</th>
            <th>&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;</th>
        </tr>
        <?php
        $sql="SELECT * FROM product";
        $result=mysqli_query($db,$sql);
        $count=mysqli_num_rows($result);
        $link_img="";
        for($i=0;$i<$count;$i++):
            $product= mysqli_fetch_assoc($result);
        if ($product['CategoryID']==1){
            $product['CategoryID']="Đồ cổ";
            $link_img="project/Đồ%20cổ/";
        }else if($product['CategoryID']==2){
            $product['CategoryID']="Đồ trang sức";
            $link_img="project/Trang%20Sức/";
        }else if($product['CategoryID']==3){
            $product['CategoryID']="Đồ điện tử";
            $link_img="project/Đồ%20điện%20tử/";
        }else if($product['CategoryID']==4){
            $product['CategoryID']="Đồ nội thất";
            $link_img="project/Đồ%20nội%20thất/";
        }
        else{
            $product['CategoryID']="Phương tiện";
            $link_img="project/Phương%20tiện/";
        }
            ?>
            <tr>
                <td><?php echo $product['NAME']; ?></td>
                <td><?php echo $product['CategoryID']; ?></td>
                <td><?php echo $product['Price']; ?></td>
                <td><?php echo $product['DESCRIPTION']; ?></td>
                <td style="width:200px"><img style="width: 200px;height: 150px" src="<?php echo $link_img.$product['Picture'];?>"</td>
                <td>&nbsp;</td>
                <td><a href="<?php echo 'edit_product.php?ProductId='.$product['ProductId'];?>">Edit</a></td>
                <td><a href="<?php echo 'delete_product.php?ProductId='.$product['ProductId'];?>">delete</a></td>
            </tr>
        <?php
        endfor;
        mysqli_free_result($result);
        ?>
    </table>
    <br>
</form>
<script>
    window.addEventListener('beforeunload', function(e) {
        <?php  $_SESSION['new_product_sucsses'] = '' ?>;
    });

</script>
</body>
</html>
