<?php

	//Create JSON string. Improvements will be made here: generate array and use json_decode later
	$string = "[";
	$n = 500000; // $n -> the number of addresses you want to add in the JSON

	for ($i=1; $i <=$n; $i++)
	{
		$string .= '{"email":"'  . $i . '@sink.sendgrid.net"}'; 
		if ($i != $n) {
			$string .= ",";
		} else {
			$string .= "]";
		}
		 
	}
	//If you want to save the string in a file, add the line below as well:
		file_put_contents('filename.csv', $string, FILE_APPEND);

	//Make API call using cURL to add the addresses to MC's ALL CONTACTS list:
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.sendgrid.com/v3/contactdb/recipients",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $string,
	  CURLOPT_HTTPHEADER => array(
	    "authorization: Bearer XXXXXXXXXXXXXXXXXX", // SendGrid API key
	    "cache-control: no-cache",
	    "content-type: application/json",
	    "postman-token: 11111111-2222-3333-4444-555555555555"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}

?>
