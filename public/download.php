<?php
    $url = $_REQUEST['file_url'];
    $filename = basename($url);
    $filetype = filetype($url);
    header('Content-Disposition: attachment; filename=' . $filename);
    header("Content-type: " . $filetype); // act as image with right MIME type
    ob_clean();
    flush();
    readfile($url);
exit;