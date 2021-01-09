<?php
require 'api.php';
$content = $_POST['content'];
$filename = $_POST['filename'];
$todayDate = date('Ymd');
$abs_filepath = $filename.'/'.$filename;
echo upload_file_to_github($abs_filepath, $content);
