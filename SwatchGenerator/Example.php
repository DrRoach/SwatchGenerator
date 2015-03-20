<!--
This is an example of using the SwatchGenerator tool.
-->

<h1>Swatch Generator</h1>

<?php
require_once 'Generate.php';
new Generate([
    'image' => 'snorkel.jpg',
    'swatch' => [
        'width' => 200,
        'height' => 200
    ],
    'colour' => 'blue',
    'file' => 'swatch'
]);