<?php
include_once "lib/database.php";
$err = [];
function checkForm()
{
    global $err;
    return count($err) == 0;
}

function formValidate() {
    if (empty($_POST['name'])) {
        $err[] = " product name is not empty";
    }
    if (empty($_POST['price'])) {
        $err[] = "price is not empty";
    }
    if (empty($_POST['categoryId'])) {
        $err[] = "categoryId is not empty";
    }
    if (empty($_POST['description'])) {
        $err[] = "description is not empty";
    }
    if (!is_numeric($_POST['price'])) {
        $err[] = "price is not text";
    }
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if ($_POST['categoryId'] == "Đồ cổ") {
        $_POST['categoryId'] = 1;
    } else if ($_POST['categoryId'] == "Đồ trang sức") {
        $_POST['categoryId'] = 2;
    } else if ($_POST['categoryId'] == "Đồ điện tử") {
        $_POST['categoryId'] = 3;
    } else if ($_POST['categoryId'] == "Đồ nội thất") {
        $_POST['categoryId'] = 4;
    } else {
        $_POST['categoryId'] = 5;
    }
    formValidate();
    if(checkForm()){
        $product=[];
        $product['ProductId']=$_POST['productId'];
        $product['name']=$_POST['name'];
        $product['categoryId']=$_POST['categoryId'];
        $product['descirption']=$_POST['description'];
        $product['price']=$_POST['price'];
        $product['picture']=$_FILES['fileUpload']['name'];
        $sql = "UPDATE product SET ";
        $sql .= "name='" . $product['name'] . "', ";
        $sql .= "price='" . $product['price'] . "', ";
        $sql .= "categoryId='" . $product['categoryId'] . "', ";
        $sql .= "description='" . $product['descirption'] . "', ";
        $sql .= "picture='" . $_FILES['fileUpload']['name']. "', ";
        $sql .= "price='" . $product['price'] . "'";
        $sql .= "WHERE productId='" . $product['ProductId'] . "' ";
        $sql .= "LIMIT 1";
        $result=mysqli_query($db,$sql);
        echo mysqli_error($db);
        $_SESSION['new_product_sucsses'] = '<h2>'.'edit thanh cong'.'</h2>';
        dedirec_to('product_index.php');
    }
}else{
    if(!isset($_GET['ProductId'])) {
        dedirec_to('product_index.php');
    }
    $id = $_GET['ProductId'];
    $sql="SELECT*FROM product WHERE productId ='".$id."'";
    $result = mysqli_query($db,$sql);
    $product=mysqli_fetch_assoc($result);
    $_SESSION['check_picture']="edit";
}
$link_img="";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
</head>
<body>
<?php if ($_SERVER['REQUEST_METHOD'] == "POST" && !checkForm()): ?>
    <div class="err">
        <span class="err">fix loi sau de tiep tuc</span>
        <ul>
            <?php
            foreach ($err as $key => $value) {
                if (!empty($value)) {
                    echo "<li>" . $value . "</li>";
                }
            }
            ?>
        </ul>
    </div> <?php endif; ?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <h3>UPDATE Product</h3>
        <input type="hidden" name="productId" value="<?php echo checkForm()?$product['ProductId']:$_POST['ProductId']?>">
        <label for="name">Product Name : </label>
        <input type="text" placeholder="product name" name="name"
               value="<?php echo checkForm() ? $product['NAME'] : $_POST['name'] ?>">
        <label for="price">Price :</label>
        <input type="text" placeholder="price" name="price"
               value="<?php echo checkForm() ? $product['Price'] : $_POST['price'] ?>">
        <label>Category : </label>
        <select name="categoryId">
            <option value="Đồ cổ"
            <?php
                if($product['CategoryID']==1){
                    echo "selected";
                    $link_img="project/Đồ%20cổ/";
                }
            ?>
            >Đồ cổ</option>
            <option value="Đồ trang sức"
                <?php
                if($product['CategoryID']==2){
                    echo "selected";
                    $link_img="project/Trang%20Sức/";
                }
                ?>>Đồ trang sức</option>
            <option value="Đồ điện tử"
                <?php
                if($product['CategoryID']==3){
                    echo "selected";
                    $link_img="project/Đồ%20điện%20tử/";
                }
                ?>>Đồ điện tử</option>
            <option value="Đồ nội thất"
                <?php
                if($product['CategoryID']==4){
                    echo "selected";
                    $link_img="project/Đồ%20nội%20thất/";
                }
                ?>>Đồ nội thất</option>
            <option value="Phương tiện"
                <?php
                if($product['CategoryID']==5){
                    echo "selected";
                    $link_img="project/Phương%20tiện/";
                }
                ?>>Phương tiện</option>
        </select>
        <label for="description">Description : </label>
        <input id="description" type="text" placeholder="description" name="description"
               value="<?php echo checkForm() ? $product['DESCRIPTION'] : $_POST['description'] ?>">
        <label>picture file : </label>
        <input type="file" name="fileUpload"
               value="<?php echo checkForm() ? "" : $_POST['fileUpload'] ?>">
        <img style="width: 250px;height: 150px" src="<?php echo $link_img?>/<?php echo $product['Picture'];?>">
        <input name="submit" value="submit" type="submit">
    </fieldset>
</form>
<a href="product_index.php">Back to index</a>
</body>
</html>