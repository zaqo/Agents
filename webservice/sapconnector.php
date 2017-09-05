<?php
function SAP_connector()
{

	include_once("login_avia.php");
	ini_set("soap.wsdl_cache_enabled", "0");


	$locale = 'ru';
	$content='';

	$client = new SoapClient($wsdlurl, array('login'          => $SAP_user,
                                         'password'       => $SAP_password)); 

	 // Формирование заголовков SOAP-запроса
	$client->__setSoapHeaders(
	array(
		new SoapHeader('API', 'user', $SAP_user, false),
		new SoapHeader('API', 'password', $SAP_password, false)
		)
	);

	// Входные данные запроса
	// will be substituted by function's input data
	$params = array(
		'PBilldt' => '2017-07-13',
		'PMenge' => '30',
		'PMode' => 'SO_CR',
		'PPrice' => '30',
		'PRefdoc' => '0040000019',
		'PRfdcit' => '000010',
		'Return2' => ''   
	);


	// Выполнение запроса к серверу SAP ERP
	$result = $client->ZsdOrderCrud($params);
	
	$content.=$result->Return2;
	//$result = $client->ZsdOrderCrud($PBilldt, $PMenge,$PMode,$PPrice,$PRefdoc,$PRfdcit,$Return2);

	// Вывод запроса и ответа
	echo "Запрос:<pre>".htmlspecialchars($client->__getLastRequest()) ."</pre>";
	echo "Ответ:<pre>".htmlspecialchars($client->__getLastResponse())."</pre>";

	// Вывод отладочной информации в случае возникновения ошибки
	if (is_soap_fault($result)) 
	{ 
		echo("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring}, detail: {$result->detail})"); 
	}

	
	return $content;
}
?>