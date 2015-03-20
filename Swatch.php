<?php

class Swatch
{
    /**
     * @param resource $image
     */
    public static function create($image, $x, $y)
    {
        $swatch = imagecreatetruecolor(Data::$SWATCH['width'], Data::$SWATCH['height']);
        imagecopyresampled($swatch, $image, 0, 0, $x, $y, Data::$SWATCH['width'], Data::$SWATCH['height'], Data::$SWATCH['width'], Data::$SWATCH['height']);
        imagepng($swatch, Data::$FILE.'.png');
    }
}