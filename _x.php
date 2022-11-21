<?php

function _respond_json($message='', $status=200) {
    http_response_code($status);
    header('Content-Type: application/json');
    $res = is_array($message) ? $message : ['info' => $message];
    echo json_encode($res);
    exit();
}

function _respond_html($file_to_render, $status=200) {
    http_response_code($status);
    echo require_once $file_to_render;
    exit();
}

