<?php
$Array = array(
	'a' => 1/8,
	'b' => 1/2,
);

$Chances = new Chances($Array);
$Result = array();
for ($i = 0; $i <= 1000; $i++){
	$index = $Chances->call();
	if (!isset($Result[$index])){
		$Result[$index] = 0;
	}
	$Result[$index]++;
}

echo '<pre>';
var_dump($Result);
echo '</pre>';

class Chances{

	private $__Data;

	private $__calls = 0;

	public function __construct($Data){
		if (empty($Data)){
			throw new Exception('Передан пустой массив');
		}

		$sum = array_sum($Data);
		foreach ($Data as $key => $chance){
			$this->__Data[$key] = array(
				'chance' => $chance,
				'calls' => 0,
				'percent' => $chance/$sum*100,
			);
		}
	}

	public function call(){
		$this->__calls++;
		foreach ($this->__Data as $key => $Data){
			if ($Data['calls'] < $this->__calls/100*$Data['percent']){
				$Result[] = $key;
			}
		}

		$index = $Result[rand(0, count($Result)-1)];
		$this->__Data[$index]['calls']++;
		return $index;
	}
}
?>