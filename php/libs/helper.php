<?php

function getParam($key, $default_val, $is_post = true) {
    $arry = $is_post ? $_POST : $_GET;
    return $arry[$key] ?? $default_val;
}

function redirect($path) {
    if($path === GO_HOME) {
        $path = getUrl('');
    } elseif ($path === GO_REFERER) {
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = getUrl($path);
    }
    header("Location: {$path}");
    die();
}

function theUrl($path) {
    if($path === GO_HOME) {
        $path = '';
    }
    echo getUrl($path);
}

function getUrl($path) {
    return BASE_CONTEXT_PATH . trim($path, '/');
}

function isAlnum($val) {
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}

function escape($data) {
    if(is_array($data)) {
        foreach($data as $prop => $val) {
            $data[$prop] = escape($val);
        }
        return $data;
    } elseif (is_object($data)) {
        foreach($data as $prop => $val) {
            $data->$prop = escape($val);
        }
        return $data;
    } else {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
