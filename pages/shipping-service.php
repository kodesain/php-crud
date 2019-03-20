<?php

require_once('../connection.php');
require_once('../functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch (isset_var($_POST['action'])) {
        case 'create':
            echo create();
            break;
        case 'update':
            echo update();
            break;
        case 'delete':
            echo delete();
            break;
        default:
            echo read();
    }
}

function create() {
    global $conn;

    $message = array();
    $data = NULL;
    $status = 'failed';

    $ship_name = isset_var($_POST['ship_name']);
    $ship_description = isset_var($_POST['ship_description']);
    $ship_image = isset_var($_POST['ship_image']);

    if ($ship_name == '') {
        array_push($message, 'Shipping is required');
    }

    if ($ship_description == '') {
        array_push($message, 'Description is required');
    }

    if (empty($message)) {
        $upload = upload_file('../files/shipping', $_FILES['image_file'], array('gif', 'jpg', 'png'));
        if (!empty($upload)) {
            if ($upload['error'] == 0) {
                $ship_image = $upload['location'];
            } else {
                array_push($message, $upload['message']);
            }
        }
    }

    if (empty($message)) {
        try {
            $conn->exec('INSERT INTO `shipping` (`ship_name`, `ship_description`, `ship_image`) VALUES (
                    "' . $ship_name . '",
                    "' . $ship_description . '",
                    "' . str_replace("../", "", $ship_image) . '"
                );');

            $status = 'success';
            $message = 'Shipping has been successfully saved';
        } catch (PDOException $e) {
            $message = $e->getMessage();
        }
    }

    return json_encode(array(
        'status' => $status,
        'data' => $data,
        'message' => $message
    ));
}

function update() {
    global $conn;

    $message = array();
    $data = NULL;
    $status = 'failed';

    $ship_id = isset_var($_POST['ship_id']);
    $ship_name = isset_var($_POST['ship_name']);
    $ship_description = isset_var($_POST['ship_description']);
    $ship_image = isset_var($_POST['ship_image']);

    if ($ship_name == '') {
        array_push($message, 'Shipping is required');
    }

    if ($ship_description == '') {
        array_push($message, 'Description is required');
    }

    if (empty($message)) {
        $upload = upload_file('../files/shipping', $_FILES['image_file'], array('gif', 'jpg', 'png'));
        if (!empty($upload)) {
            if ($upload['error'] == 0) {
                $ship_image = $upload['location'];
            } else {
                array_push($message, $upload['message']);
            }
        }
    }

    if (empty($message)) {
        try {
            $conn->exec('UPDATE `shipping` SET
                    `ship_name` = "' . $ship_name . '",
                    `ship_description` = "' . $ship_description . '",
                    `ship_image` = "' . str_replace("../", "", $ship_image) . '"
                WHERE `ship_id` = "' . $ship_id . '";');

            $status = 'success';
            $message = 'Shipping has been successfully updated';
        } catch (PDOException $e) {
            $message = $e->getMessage();
        }
    }

    return json_encode(array(
        'status' => $status,
        'data' => $data,
        'message' => $message
    ));
}

function delete() {
    global $conn;

    $message = array();
    $data = NULL;
    $status = 'failed';

    if (empty($message)) {
        try {
            $conn->exec('DELETE FROM `shipping` WHERE `ship_id` = "' . isset_var($_POST['ship_id']) . '";');

            $status = 'success';
            $message = 'Shipping has been successfully deleted';
        } catch (PDOException $e) {
            $message = $e->getMessage();
        }
    }

    return json_encode(array(
        'status' => $status,
        'data' => $data,
        'message' => $message
    ));
}

function read() {
    global $conn;

    $message = array();
    $data = NULL;
    $status = 'failed';

    if (isset_var($_POST['ship_id']) != '') {
        $data = $conn->query('SELECT * FROM `shipping` WHERE `ship_id` = "' . isset_var($_POST['ship_id']) . '";')->fetch(PDO::FETCH_ASSOC);
        $status = 'success';
        $message = NULL;
    } else {
        $data = $conn->query('SELECT * FROM `shipping` ORDER BY `ship_name` ASC;')->fetchAll(PDO::FETCH_ASSOC);
        $status = 'success';
        $message = NULL;
    }

    return json_encode(array(
        'status' => $status,
        'data' => $data,
        'message' => $message
    ));
}

?>