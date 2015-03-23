<!--
This is an example of using the SwatchGenerator tool.
-->

<h1>Swatch Generator</h1>

<?php
$start = microtime(true);
require_once 'Generate.php';
new Generate([
    'image' => 'rgb.png',
    'swatch' => [
        'width' => 100,
        'height' => 100
    ],
    'colour' => 'red',
    'file' => 'swatch',
    'accuracy' => 1
]);
$end = microtime(true);
echo 'Total = ' . ($end - $start);