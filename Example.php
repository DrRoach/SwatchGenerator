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
        'width' => 200,
        'height' => 200
    ],
    'colour' => 'blue',
    'file' => 'swatch',
    'accuracy' => 20
]);
$end = microtime(true);
echo 'Total = ' . ($end - $start);