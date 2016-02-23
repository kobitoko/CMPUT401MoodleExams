<?php
	include_once "phpqrcode/qrlib.php";
	include_once "php-qrcode-detector-decoder/QrReader.php";

	class MME_QRcode {

		private $data = "";
		private $path = "";

		#Public Constructor. both parameters are optional.
		public function __construct($str="",$path=""){
			$this->data = $str;
			$this->path = $path;
		}

		#Generic Get/Setters
		public function get_data(){
			return $this->data;
		}

		public function set_data($data){
			$this->data = $data;
		}

		public function get_path(){
			return $this->path;
		}

		public function set_path($path){
			$this->path = $path;
		}

		#Reads data from the qrcode and returns the value.
		#TODO: Handle cases where image in the specified path doesn't exist
		#TODO: Handle cases where the image is not a valid QR Code
		public function get_data_from_QRcode(){
			$qrcode = new QrReader($this->path);
			$this->set_data($qrcode->text());
		}

		#Generates the QRcode containing $data to $path.png
		public function generate_QRcode(){
			QRcode::png($this->data,$this->path,'L',4,2);
		}

	}

	$qr = new MME_QRcode('test','test.png');

	echo "<b>Some examples before we add unit tests later.</b></br>";
	echo "<b>data = 'test', path = 'test.png'.</b></br>";

	echo "<b>Echo get_path()</b></br>";
	echo $qr->get_path();
	echo "</br><b>Echo get_data()</b></br>";
	echo $qr->get_data();

	echo "</br><b>Generate and display qr code</b></br>";
	$qr->generate_QRcode();
	echo "<img src='test.png'></br>";

	echo "<b>Echo data from QRcode</b></br>";
	$qr->get_data_from_QRcode();
	echo $qr->get_data();

?>

