<?php
class commonFunction{
    function callInterfaceCommon($URL,$type,$params,$headers){
        $ch = curl_init($URL);
        $timeout = 5;
        if($headers!=""){
            curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        }else {
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        switch ($type){
            case "GET" : curl_setopt($ch, CURLOPT_HTTPGET, true);break;
            case "POST": curl_setopt($ch, CURLOPT_POST,true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
            case "PUT" : curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
            case "PATCH": curl_setopt($ch, CULROPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);break;
            case "DELETE":curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
        }
        $file_contents = curl_exec($ch);
		if(curl_errno($ch)) {
			echo 'Curl error: ' . curl_error($ch);
		}
        curl_close($ch);
        return $file_contents;
    }
}

function foo($fileEx, $content, $name, $email, $username, $token, $repo) {
	$params="{\"message\": \"init\",\"branch\": \"master\",\"committer\": {\"name\": \"".$name."\",\"email\": \"".$email."\"},\"content\": \"".$content."\"}";
	date_default_timezone_set('PRC');
	$filename = date('Ymdhis', time()).md5($content).$fileEx;
	$url='https://api.github.com/repos/'.$username.'/'.$repo.'/contents/'.$filename;
	$cf = new commonFunction();
	$headers=array('User-Agent: '.$username, 'Authorization:token '.$token);
	$action="PUT";
	$strResult = $cf->callInterfaceCommon($url, $action, $params, $headers);
	return "https://cdn.jsdelivr.net/gh/".$username."/".$repo."@master/".$filename;
}