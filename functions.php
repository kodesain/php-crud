<?php

function isset_var(&$var, $val = '') {
    return isset($var) ? trim($var) : $val;
}

function redirect($url) {
    echo '<script type="text/javascript">window.location.href = \'' . $url . '\';</script>';
}

function upload_file($_dir, array $_file, array $_ext = array()) {
    if (!is_dir($_dir)) {
        mkdir($_dir, 0777, true);
    }

    if (is_uploaded_file($_file['tmp_name'])) {
        $filename = $_dir . '/' . basename($_file['name']);

        if (!empty($_ext)) {
            if (!in_array(strtolower(pathinfo($_file['name'], PATHINFO_EXTENSION)), $_ext)) {
                return array(
                    'error' => 1,
                    'message' => 'Invalid extension'
                );
            }
        }

        if (move_uploaded_file($_file['tmp_name'], $filename)) {
            $_file['location'] = $filename;

            return $_file;
        } else {
            return array(
                'error' => 1,
                'message' => 'File uploading failed'
            );
        }
    } else {
        return NULL;
    }
}

?>