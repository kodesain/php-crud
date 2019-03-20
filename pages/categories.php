<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$message = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($message)) {
        try {
            $conn->exec('DELETE FROM `categories` WHERE `cat_id` = "' . isset_var($_POST['cat_id']) . '";');

            $_SESSION['message'] = 'Category has been successfully deleted';

            redirect('?show=categories');
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
        Categories
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
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col" width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conn->query('SELECT * FROM `categories` ORDER BY `cat_name` ASC;') as $row) { ?>
                    <tr>
                        <td><?php echo $row['cat_name']; ?></td>
                        <td><?php echo $row['cat_description']; ?></td>
                        <td>
                            <a href="?show=category-edit&id=<?php echo $row['cat_id']; ?>" class="btn btn-primary btn-sm float-left mr-1" role="button"><i class="fas fa-pen"></i> Edit</a>
                            <form method="post">
                                <input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-success" onclick="window.location.href = '?show=category-add';"><i class="fas fa-plus"></i> Add Category</button>
    </div>
</div>