<?php
$from="demo"; //Ваше альфаимя!
$to="380500839929";//Номер получателя
$text="Тестовое сообщение";
$login='demo';//Логин 
$password='demo';//Пароль
$url='http://sms.businesslife.com.ua/clients.php';//URL для отправки сообщений
$xml="<message><service id='single' source='$from'/><to>$to</to><body content-type='text/plain' encoding='plain'>$text</body></message>";

$answ=post_request($xml, $url, $login, $password);

echo "$answ\n";
var_dump($answ);

function post_request($data, $url, $login, $pwd)
{
        $credent = sprintf('Authorization: Basic %s',base64_encode($login.":".$pwd) );
        $params=array('http'=>array('method'=>'POST','content'=>$data, 'header'=>$credent));
        $ctx = stream_context_create($params);
        $fp=@fopen($url, 'rb', FALSE, $ctx);
        if ($fp)
        {
                $response = @stream_get_contents($fp);
                return $response;
        }
        else return FALSE;
}
#Ошибки при создании рассылок по протоколу IP2SMS.
/*
Ошибки передаваемые не в XML:
401 Unauthorized – ошибка авторизации
Request not recognized - xml parse failed. Request text: … -- некорректный XML.

Ошибки передаваемые в XML:
<status date=''><state error='uniq_key dupe'>Rejected</state></status> -- не уникальный ключ рассылки
state error='Unknown operator code {kod}'>Rejected</state> -- не верный/неподдерживаемый оператор
<state error='Message text not found'>Rejected</state>
<state error='Invalid abonent number'>Rejected</state>
<state error='Prepaid messages limit exceed'>Rejected</state> -- Если клиент подключен по prepaid, нет средств на счету
<state error='Prepaid bill error'>Rejected</state> -- Если клиент подключен по prepaid,  ошибка биллинга (например, не назначен тариф)
<state error='Text don`t match allowed templates'>Rejected</state></status>
<state error='2 or more numbers required for bulk or individual mode'>Rejected</state> -- В режиме bulk и individual нельзя отправлять сообщение одному абоненту.
<state error='Invalid source number'>Rejected</state> -- альфимя не корректно или запрещено/не активировано.
*/
?>
