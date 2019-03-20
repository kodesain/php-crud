<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$message = array();
$cat_name = '';
$cat_description = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_name = isset_var($_POST['cat_name']);
    $cat_description = isset_var($_POST['cat_description']);

    if ($cat_name == '') {
        array_push($message, 'Category is required');
    }

    if ($cat_description == '') {
        array_push($message, 'Description is required');
    }

    if (empty($message)) {
        try {
            $conn->exec('INSERT INTO `categories` (`cat_name`, `cat_description`) VALUES (
                "' . $cat_name . '",
                "' . $cat_description . '"
            );');

            $_SESSION['message'] = 'Category has been successfully saved';

            redirect('?show=categories');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        Add Category
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
        <form method="post">
            <div class="form-group">
                <label for="cat_name">Category</label>
                <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $cat_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="cat_description">Description</label>
                <input type="text" class="form-control" id="cat_description" name="cat_description" value="<?php echo $cat_description; ?>" required>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Create Category</button>
                <button type="button" class="btn btn-success" onclick="window.location.href = '?show=categories';"><i class="fas fa-arrow-left"></i> Back</button>
            </div>
        </form>
    </div>
</div>