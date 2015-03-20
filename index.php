<h1>SWATCHINATOR</h1>

<?php
require_once 'SwatchGenerator/Generate.php';
new Generate([
    'image' => 'snorkel.jpg',
    'swatch' => [
        'width' => 200,
        'height' => 200
    ],
    'colour' => 'blue',
    'file' => 'swatch'
]);