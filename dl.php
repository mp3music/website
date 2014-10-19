<?php
$file = urldecode($_GET['link']);
$filename = $_GET['name'];
header("Content-type: octet/stream");
header("Content-disposition: attachment; filename=" . $filename . "");
readfile($file);
exit;