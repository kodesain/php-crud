<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$message = array();
$cat_id = '';
$prod_name = '';
$prod_description = '';
$prod_price = '';
$prod_image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_id = isset_var($_POST['cat_id']);
    $prod_name = isset_var($_POST['prod_name']);
    $prod_description = isset_var($_POST['prod_description']);
    $prod_price = isset_var($_POST['prod_price']);

    if ($prod_name == '') {
        array_push($message, 'Product is required');
    }

    if ($prod_description == '') {
        array_push($message, 'Description is required');
    }

    $upload = upload_file('files/products', $_FILES['image_file'], array('gif', 'jpg', 'png'));
    if (!empty($upload)) {
        if ($upload['error'] == 0) {
            $prod_image = $upload['location'];
        } else {
            array_push($message, $upload['message']);
        }
    }

    if (empty($message)) {
        try {
            $conn->exec('INSERT INTO `products` (`cat_id`, `prod_name`, `prod_description`, `prod_price`, `prod_image`, `prod_created`) VALUES (
                "' . $cat_id . '",
                "' . $prod_name . '",
                "' . $prod_description . '",
                "' . $prod_price . '",
                "' . $prod_image . '",
                "' . date('Y-m-d H:i:s') . '"
            );');

            $_SESSION['message'] = 'Product has been successfully saved';

            redirect('?show=products');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        Add Product
    </div>
    <div class="card-body">
        <?php if (!empty($message)) { ?>
            <div class="alert alert-danger" role="alert">
                <ul class="m-0">
                    <?php
                    foreach ($message as &$msg) {
                        echo '<li>' . $msg . '</li>';
                    }
                    ?>
                </ul>
            </div>
        <?php } ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="prod_name">Product</label>
                <input type="text" class="form-control" id="prod_name" name="prod_name" value="<?php echo $prod_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="cat_id">Category</label>
                <select class="form-control" id="cat_id" name="cat_id">
                    <?php foreach ($conn->query('SELECT * FROM `categories` ORDER BY `cat_name` ASC;') as $row) { ?>
                        <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prod_description">Description</label>
                <input type="text" class="form-control" id="prod_description" name="prod_description" value="<?php echo $prod_description; ?>" required>
            </div>
            <div class="form-group">
                <label for="prod_price">Price</label>
                <input type="number" class="form-control text-right" id="prod_price" name="prod_price" value="<?php echo $prod_price; ?>" required>
            </div>
            <div class="form-group">
                <label for="image_file">Image File</label>
                <input type="file" class="form-control" id="image_file" name="image_file">
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn btn-danger" onclick="window.location.href = '?show=products';"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Create Product</button>
            </div>
        </form>
    </div>
</div>