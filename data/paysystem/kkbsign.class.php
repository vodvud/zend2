<?php

	/* --------------------------------------------

		������ ��� ��������/�������� �������
		���������/��������� ������.

	    KKBSign class
		-------------
		by Kirsanov Anton (webcompass@list.ru)
		01.06.2006	


		^^^^^^^^^^^^^^^
		������ �������:

		// ---------------------------------------
		// �������� ���������� ����� � PEM ������� 

			load_private_key($file, $password); 

		// ---------------------------------------
		// �������� ������

			invert(); 			

		// ---------------------------------------
		// ������� ����������� ������ ������ $str

			sign($str);			

		// ---------------------------------------
		// ������� ����������� ������ ������ $str
		// � ����������� � Base64

			sign64($str); 

		// ---------------------------------------
		// �������� ��������� ������ $file, 
		// �������� �� ������ $str ����������� 
		// ��������� ������ ������� $data.
	
			check_sign($data, $str, $file);

		// ---------------------------------------
		// �������� ��������� ������ $file, 
		// �������� �� ������ $str � Base64
		// ����������� ��������� ������ ������� $data.

			check_sign($data, $str, $file);

	   ------------------------------------------*/



class KKBsign {

	// -----------------------------------------------------------------------------------------------

	function load_private_key($filename, $password = NULL){

		if(!is_file($filename))
		{

		echo "Key not found";
		return false;	

		}

		$c = file_get_contents($filename);

		if($password)

			$prvkey = openssl_get_privatekey($c, $password) or die(openssl_error_string());

		else 

			$prvkey = openssl_get_privatekey($c)  or die(openssl_error_string());


		if(is_resource($prvkey)){

			 $this->private_key = $prvkey;
 			 return $c;

		}

		return false;

	}

	// -----------------------------------------------------------------------------------------------
	// ��������� ����� ��������

	function invert(){

		$this->invert = 1;

	}


	// -----------------------------------------------------------------------------------------------
	// ������� �������� ������

	function reverse($str){

		return strrev($str);

	}


	// -----------------------------------------------------------------------------------------------

    
	function sign($str)
	{

		if($this->private_key)
		{

			openssl_sign($str, $out, $this->private_key);

			if($this->invert == 1) $out = $this->reverse($out);

			return $out;

		}

	}


	// -----------------------------------------------------------------------------------------------


	function sign64($str){

		return base64_encode($this->sign($str));

	}


	// -----------------------------------------------------------------------------------------------


	function check_sign($data, $str, $filename){

		if($this->invert == 1)  $str = $this->reverse($str);

		if(!is_file($filename)) return false;

		$pubkey = file_get_contents($filename);

		return openssl_verify($data, $str, $pubkey);

	}


	// -----------------------------------------------------------------------------------------------


	function check_sign64($data, $str, $filename){

		return $this->check_sign($data, base64_decode($str), $filename);

	}


}


?>