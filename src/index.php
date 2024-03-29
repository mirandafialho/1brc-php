<?php

$handle = fopen('/home/mirandafialho/Projects/1brc-php/data/measurements_100000.txt', 'r');

$measurements = [];

if ($handle) {
	while (!feof($handle)) {
		$line = fgets($handle);
		$data = explode(';', $line);

		if (array_key_exists($data[0], $measurements)) {
			$measurements[$data[0]] = $measurements[$data[0]] . ';' . $data[1];
		} else {
			$measurements[$data[0]] = array_key_exists(1, $data) ? $data[1] : '0';
		}
	}
}

echo "{\n";
foreach ($measurements as $key => $value) {
	$data = explode(';', $value);
	$min = 0;
	$max = 0;
	$sum = 0;
	$avg = 0;

	foreach ($data as $temperature) {
		if ($min > $temperature) {
			$min = $temperature;
		}

		if ($max < $temperature) {
			$max = $temperature;
		}

		$sum = $sum + $temperature;
	}

	$avg = round($sum / count($data), 1);

	echo "\t" . $key . ' => (min:' . $min . ',avg:' . $avg . ',max:' . $max . ')';
}
echo "\n}";

