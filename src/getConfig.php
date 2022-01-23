<?php
    // 用来获取最新的 config.js
    // url 后面加上时间戳
    $url = "config.js?ts=".time();
    header("Location: $url");
    exit();
?>