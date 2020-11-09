<?php
// HTTP Status Codes
function HttpStatus($code) {
 $status = array(
        100 => 'Continue',  
        101 => 'Switching Protocols',  
        200 => 'OK',
        201 => 'Created',  
        202 => 'Accepted',  
        203 => 'Non-Authoritative Information',  
        204 => 'No Content',  
        205 => 'Reset Content',  
        206 => 'Partial Content',  
        300 => 'Multiple Choices',  
        301 => 'Moved Permanently',  
        302 => 'Found',  
        303 => 'See Other',  
        304 => 'Not Modified',  
        305 => 'Use Proxy',  
        306 => '(Unused)',  
        307 => 'Temporary Redirect',  
        400 => 'Bad Request',  
        401 => 'Unauthorized',  
        402 => 'Payment Required',  
        403 => 'Forbidden',  
        404 => 'Not Found',  
        405 => 'Method Not Allowed',  
        406 => 'Not Acceptable',  
        407 => 'Proxy Authentication Required',  
        408 => 'Request Timeout',  
        409 => 'Conflict',  
        410 => 'Gone',  
        411 => 'Length Required',  
        412 => 'Precondition Failed',  
        413 => 'Request Entity Too Large',  
        414 => 'Request-URI Too Long',  
        415 => 'Unsupported Media Type',  
        416 => 'Requested Range Not Satisfiable',  
        417 => 'Expectation Failed',  
        500 => 'Internal Server Error',  
        501 => 'Not Implemented',  
        502 => 'Bad Gateway',  
        503 => 'Service Unavailable',  
        504 => 'Gateway Timeout',  
        505 => 'HTTP Version Not Supported');
    
    // If code not exist, return 500
    return $status[$code] ? $status[$code] : $status[500];
}
 
// // Set header
// function SetHeader($code){
//     header("HTTP/1.1 ".$code." ".HttpStatus($code));
//     header("Content-Type: application/json; charset=utf-8");
// }
 
// Check username availability
function checkUserName($s) {
    $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
    $eng = array('s','s','i','i','g','g','u','u','o','o','c','c');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
    $s = preg_replace('/&.+?;/', '', $s);
    $s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = trim($s, '-');
 
    return $s;
}
?>