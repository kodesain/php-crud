<?php
require_once('connection.php');
require_once('functions.php');
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Simple CRUD Application</title>

        <!-- StyleSheet -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

        <style type="text/css">
            main {
                margin-top: 0;
            }
            .toggle-button {
                cursor: pointer;
            }

            .sidebar {
                min-width: 250px;
                max-width: 250px;
                min-height: calc(100vh - 56px);
                transition: all 0.3s;
            }
            .sidebar.toggled {
                margin-left: -250px;
            }

            .content {
                width: 100%;
            }

            @media (max-width: 768px) {
                .sidebar {
                    margin-left: -250px;
                }
                .sidebar.toggled {
                    margin-left: 0;
                }
            }
        </style>

        <!-- JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".toggle-button").on("click", function () {
                    $(".sidebar").toggleClass("toggled");
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-success">
            <a class="toggle-button text-light mr-3"><i class="fa fa-bars"></i></a>
            <a class="navbar-brand" href="<?php echo BASEPATH; ?>">CRUD APP</a>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                            <i class="fa fa-user"></i> ADMIN
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="?show=account"><i class="fas fa-user-cog"></i> Account Settings</a>
                            <a class="dropdown-item" href="?show=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="d-flex">
            <nav class="sidebar sidebar-nav bg-light p-2 shadow">
                <div class="list-group">
                    <a href="?show=dashboard" class="list-group-item list-group-item-action"><i class="fas fa-home"></i> Dashboard</a>
                    <a href="?show=categories" class="list-group-item list-group-item-action"><i class="fab fa-delicious"></i> Categories</a>
                    <a href="?show=products" class="list-group-item list-group-item-action"><i class="fas fa-box"></i> Products</a>
                    <a href="?show=payments" class="list-group-item list-group-item-action"><i class="far fa-credit-card"></i> Payments</a>
                    <a href="?show=shipping" class="list-group-item list-group-item-action"><i class="fas fa-shipping-fast"></i> Shipping</a>
                    <a href="?show=account" class="list-group-item list-group-item-action"><i class="fas fa-user-cog"></i> Account Settings</a>
                    <a href="?show=logout" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>

            <div class="content p-5">
                <?php
                $file = 'pages/' . isset_var($_GET['show'], 'dashboard') . '.php';

                if (file_exists($file)) {
                    include_once($file);
                } else {
                    include_once('pages/404.php');
                }
                ?>
            </div>
        </main>
    </body>
</html>