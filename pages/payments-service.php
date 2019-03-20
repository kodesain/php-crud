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

    $pay_name = isset_var($_POST['pay_name']);
    $pay_description = isset_var($_POST['pay_description']);

    if ($pay_name == '') {
        array_push($message, 'Payment is required');
    }

    if ($pay_description == '') {
        array_push($message, 'Description is required');
    }

    if (empty($message)) {
        try {
            $conn->exec('INSERT INTO `payments` (`pay_name`, `pay_description`) VALUES (
                    "' . $pay_name . '",
                    "' . $pay_description . '"
                );');

            $status = 'success';
            $message = 'Payment has been successfully saved';
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

    $pay_id = isset_var($_POST['pay_id']);
    $pay_name = isset_var($_POST['pay_name']);
    $pay_description = isset_var($_POST['pay_description']);

    if ($pay_name == '') {
        array_push($message, 'Payment is required');
    }

    if ($pay_description == '') {
        array_push($message, 'Description is required');
    }

    if (empty($message)) {
        try {
            $conn->exec('UPDATE `payments` SET
                    `pay_name` = "' . $pay_name . '",
                    `pay_description` = "' . $pay_description . '"
                WHERE `pay_id` = "' . $pay_id . '";');

            $status = 'success';
            $message = 'Payment has been successfully updated';
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
            $conn->exec('DELETE FROM `payments` WHERE `pay_id` = "' . isset_var($_POST['pay_id']) . '";');

            $status = 'success';
            $message = 'Payment has been successfully deleted';
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

    if (isset_var($_POST['pay_id']) != '') {
        $data = $conn->query('SELECT * FROM `payments` WHERE `pay_id` = "' . isset_var($_POST['pay_id']) . '";')->fetch(PDO::FETCH_ASSOC);
        $status = 'success';
        $message = NULL;
    } else {
        $data = $conn->query('SELECT * FROM `payments` ORDER BY `pay_name` ASC;')->fetchAll(PDO::FETCH_ASSOC);
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