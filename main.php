<?php
require "githubapi.php";
$name = '';
$username = '';
$email = '';
$token = '';
$repo = '';

$data = file_get_contents("php://input");
$index = strpos($data,",");
$indexExs = strpos($data,".");
$indexExe = strpos($data," ");
$fileEx = substr($data,$indexExs,$indexExe-$indexExs);
$dataPure = substr($data, $index+1);

$rv = foo($fileEx, $dataPure, $name, $email, $username, $token, $repo);
echo $rv;