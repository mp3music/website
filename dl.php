<?php
header("Content-type: octet/stream");
header("Content-disposition: attachment; filename=" . $_GET['name']);
readfile(urldecode($_GET['link']));
exit;