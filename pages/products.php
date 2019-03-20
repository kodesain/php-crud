<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$message = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($message)) {
        try {
            $conn->exec('DELETE FROM `products` WHERE `prod_id` = "' . isset_var($_POST['prod_id']) . '";');

            $_SESSION['message'] = 'Product has been successfully deleted';

            redirect('?show=products');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    $message = isset_var($_SESSION['message']);
    unset($_SESSION['message']);
}
?>

<div class="card">
    <div class="card-header">
        Products
    </div>
    <div class="card-body">
        <?php if (!empty($message)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Category</th>
                    <th scope="col" class="text-center">Price</th>
                    <th scope="col">Image File</th>
                    <th scope="col" width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conn->query('SELECT a.*, b.`cat_name` FROM `products` AS a LEFT JOIN `categories` AS b ON a.`cat_id` = b.`cat_id` ORDER BY a.`prod_name` ASC;') as $row) { ?>
                    <tr>
                        <td><?php echo $row['prod_name']; ?></td>
                        <td><?php echo $row['cat_name']; ?></td>
                        <td class="text-right"><?php echo $row['prod_price']; ?></td>
                        <td><?php if ($row['prod_image'] != '') { ?><img src="<?php echo $row['prod_image']; ?>" width="100"><?php } ?></td>
                        <td>
                            <a href="?show=product-edit&id=<?php echo $row['prod_id']; ?>" class="btn btn-primary btn-sm float-left mr-1" role="button"><i class="fas fa-pen"></i> Edit</a>
                            <form method="post">
                                <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-success" onclick="window.location.href = '?show=product-add';"><i class="fas fa-plus"></i> Add Product</button>
    </div>
</div>