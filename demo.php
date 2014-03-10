<?php
function post_request($url, $login, $pwd)
{
$params = array('http' =>
array(
'method' => 'POST',
'header' => array('Authorization: Basic ' . base64_encode($login.":".$pwd),'Content-Type: text/xml'),
'content' => '<message><service id="single" source="DEMO"/><to>+380500839929</to>
<body content-type="text/plain">Test from demo</body></message>'
));
 
#var_dump ($params);
 
 
$ctx = stream_context_create($params);
$fp=@fopen($url, 'rb', FALSE, $ctx);
if ($fp) {
$response = @stream_get_contents($fp);
return $response;
}else{
return FALSE;
}
}
 
$login = 'demo';
$password = 'demo';
$answ = post_request('https://api.life.com.ua/ip2sms/', $login, $password);
 
echo $answ;
exit;
?>