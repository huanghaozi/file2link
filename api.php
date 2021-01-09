<?php
require 'api_func.php';
$data = json_decode(file_get_contents("php://input"));
$content = $data->content;
$suffix = array_slice(explode('.', $data->filename), -1, 1)[0];
$hashValue = md5($content);
$filename = $hashValue.'.'.$suffix;
$todayDate = date('Ymd');
$abs_filepath = $todayDate.'/'.$hashValue.'/'.$filename;
echo upload_file_to_github($abs_filepath, $content);

