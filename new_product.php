<?php
include_once "lib/database.php";
$err = [];
function checkForm()
{
    global $err;
    return count($err) == 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Product</title>
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
<?php
$sql = "SELECT *FROM category";
$result = mysqli_query($db, $sql);
$_product = mysqli_fetch_assoc($result);
?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <h3>Create new product</h3>
        <label for="name">Product Name : </label>
        <input type="text" placeholder="product name" name="name"
               value="<?php echo checkForm() ? "" : $_POST['name'] ?>">
        <label for="price">Price :</label>
        <input type="text" placeholder="price" name="price"
               value="<?php echo checkForm() ? "" : $_POST['price'] ?>">
        <label>Category : </label>
        <select name="categoryId">
            <option value="Đồ cổ">Đồ cổ</option>
            <option value="Đồ trang sức">Đồ trang sức</option>
            <option value="Đồ điện tử">Đồ điện tử</option>
            <option value="Đồ nội thất">Đồ nội thất</option>
            <option value="Phương tiện">Phương tiện</option>
        </select>
        <label for="description">Description : </label>
        <input id="description" type="text" placeholder="description" name="description"
               value="<?php echo checkForm() ? "" : $_POST['description'] ?>">
        <label>picture file : </label>
        <input type="file" name="fileUpload"
               value="<?php echo checkForm() ? "" : $_POST['fileUpload'] ?>">
        <input name="submit" value="submit" type="submit">
    </fieldset>
</form>
<?php if ($_SERVER['REQUEST_METHOD'] == "POST" && checkForm()): ?>
    <?php
    $_product = [];
    $name = $_product['name'] = mysqli_real_escape_string($db, $_POST['name']);
    $price = (float)$_product['name'] = mysqli_real_escape_string($db, $_POST['price']);
    $description = $_product['name'] = mysqli_real_escape_string($db, $_POST['description']);
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
    $sql = "INSERT INTO product(Name,description,categoryId,price,picture)";
    $sql .= "VALUES(";
    $sql .= "'" . $name . "',";
    $sql .= "'" . $description . "',";
    $sql .= "'" . $_POST['categoryId'] . "',";
    $sql .= "'" . $price . "',";
    $sql .= "'" . $_FILES['fileUpload']['name'] . "'";
    $sql .= ")";
    $resul = mysqli_query($db, $sql);
    echo "<h3>" . "Crete new product Name :" . $name . " price : " . $price . "</h3>";
    echo mysqli_error($db);
endif; ?>
<a href="product_index.php">Back to index</a>
</body>
</html>