<?php
$GITHUB_USERNAME = 'user_name';  // 用户名
$GITHUB_REPONAME = 'repo_name';  // Repository名
$GITHUB_BRANCHNAME = 'main';  // 分支名
$GITHUB_TOKEN = '';  // TOKEN

function callInterfaceCommon($URL, $type, $params, $headers)
{
    $ch = curl_init($URL);
    $timeout = 5;
    if ($headers != "") {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    } else {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    switch ($type) {
        case "GET" :
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "PUT" :
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "PATCH":
            curl_setopt($ch, CULROPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
    }
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Curl Error: ' . curl_error($ch);
    }
    curl_close($ch);
    return 'Success';
}

function upload_file_to_github($abs_filepath, $content)
{
    global $GITHUB_USERNAME, $GITHUB_TOKEN;
    global $GITHUB_REPONAME, $GITHUB_BRANCHNAME;
    $params = sprintf('{"message":"Upload New File", 
                        "branch": "%s", 
                        "content": "%s"
                }', $GITHUB_BRANCHNAME, $content);
    $url = sprintf('https://api.github.com/repos/%s/%s/contents/%s',
        $GITHUB_USERNAME, $GITHUB_REPONAME, $abs_filepath);
    $headers = array('User-Agent: ' . $GITHUB_USERNAME, 'Authorization:token ' . $GITHUB_TOKEN);
    $result = callInterfaceCommon($url, "PUT", $params, $headers);
    if ($result == 'Success') {
        $cdnURL = sprintf('https://cdn.jsdelivr.net/gh/%s/%s@%s/%s',
            $GITHUB_USERNAME, $GITHUB_REPONAME, $GITHUB_BRANCHNAME, $abs_filepath);
        $originURL = sprintf('https://raw.githubusercontent.com/%s/%s/%s/%s',
            $GITHUB_USERNAME, $GITHUB_REPONAME, $GITHUB_BRANCHNAME, $abs_filepath);
        return $cdnURL . ' ' . $originURL;
    } else {
        return $result;
    }
}

