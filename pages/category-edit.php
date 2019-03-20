<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$message = array();
$cat_id = '';
$cat_name = '';
$cat_description = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_id = isset_var($_POST['cat_id']);
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
            $conn->exec('UPDATE `categories` SET
                    `cat_name` = "' . $cat_name . '",
                    `cat_description` = "' . $cat_description . '"
                WHERE `cat_id` = "' . $cat_id . '";');

            $_SESSION['message'] = 'Category has been successfully updated';

            redirect('?show=categories');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    if (isset_var($_GET['id']) != '') {
        $row = $conn->query('SELECT * FROM `categories` WHERE `cat_id` = "' . isset_var($_GET['id']) . '";')->fetch();

        $cat_id = $row['cat_id'];
        $cat_name = $row['cat_name'];
        $cat_description = $row['cat_description'];
    }
}
?>

<div class="card">
    <div class="card-header">
        Edit Category
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
            <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
            <div class="form-group">
                <label for="cat_name">Category</label>
                <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $cat_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="cat_description">Description</label>
                <input type="text" class="form-control" id="cat_description" name="cat_description" value="<?php echo $cat_description; ?>" required>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Update Category</button>
                <button type="button" class="btn btn-success" onclick="window.location.href = '?show=categories';"><i class="fas fa-arrow-left"></i> Back</button>
            </div>
        </form>
    </div>
</div>