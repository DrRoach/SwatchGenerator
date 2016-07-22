<!--
This is an example of using the SwatchGenerator tool.
-->

<h1>Swatch Generator</h1>

<?php
$start = microtime(true);

/**
 * Only code required to generate a swatch
 */
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


/**
 * Benchmarking to see how image creation is performing. The dream is for a swatch to
 * be generated in < 0.5s even when accuracy is set to `1`. At the moment, `imagecreatefrompng()`
 * takes 0.3s to load so that would leave 0.2s for everything else to happen.
 */
$end = microtime(true);
echo 'Total = '.($end - $start);

echo '<br><br><img src="swatch.png">';
