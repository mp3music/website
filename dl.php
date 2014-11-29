<?php
header("Content-type: octet/stream");
header("Accept-Ranges:bytes");
header("Content-disposition: attachment; filename=" . $_GET['name']);
readfile($_GET['link']);
exit;