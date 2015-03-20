<?php

class Image
{
    private static $IMAGE;
    private static $X;
    private static $Y;
    private static $MOVE = 'r';
    private static $COUNT = 0;

    public static function findSwatch()
    {
        /**
         * Create the image as a resource
         */
        ini_set('memory_limit', '-1');
        self::createResource(Data::$IMAGE);

        /**
         * Parse the image
         */
        self::imageParse();

        /**
         * Create the swatch
         */
        Swatch::create(self::$IMAGE, self::$X, self::$Y);
    }

    private static function createResource($image)
    {
        /**
         * Get the Image file extension
         */
        $extension = substr($image, strripos($image, '.') + 1);

        /**
         * Create the image resource depending on the extension
         */
        switch($extension) {
            case 'png':
                self::$IMAGE = imagecreatefrompng($image);
                break;
            case 'jpg':
            case 'jpeg':
                self::$IMAGE = imagecreatefromjpeg($image);
                break;
        }
    }

    private static function imageParse()
    {
        $pixels = imagesx(self::$IMAGE) * imagesy(self::$IMAGE);
        $count = 0;
        while($count < $pixels) {
            /**
             * Get next pixel
             */
            self::nextPixel();
            $rgb = self::getPixelColour(self::$X, self::$Y);
            $colour = self::getColourValue($rgb);
            if($colour == strtoupper(Data::$COLOUR)) {
                break;
            }
            $count++;
        }
    }

    private static function nextPixel()
    {
        if(empty(self::$X) || empty(self::$Y)) {
            //Use the centre of the image
            self::$X = imagesx(self::$IMAGE) / 2;
            self::$Y = imagesy(self::$IMAGE) / 2;
            return;
        }
        switch(self::$MOVE) {
            case 'r':
                self::$X += ++self::$COUNT;
                self::$MOVE = 'd';
                break;
            case 'd':
                self::$Y += self::$COUNT;
                self::$MOVE = 'l';
                break;
            case 'l':
                self::$X -= ++self::$COUNT;
                self::$MOVE = 'u';
                break;
            case 'u':
                self::$Y -= self::$COUNT;
                self::$MOVE = 'r';
                break;
        }
    }

    private static function getPixelColour($x, $y)
    {
        $rgb = imagecolorat(self::$IMAGE, $x, $y);
        $r = ($rgb >> 16) & 0xff;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    private static function getColourValue($rgb)
    {
        if($rgb['r'] > $rgb['g'] + 50) {
            if($rgb['r'] > $rgb['b'] + 50) {
                return 'RED';
            } else {
                return 'PURPLE';
            }
        }
        if($rgb['r'] > $rgb['b'] + 50) {
            if($rgb['r'] > $rgb['g'] + 50) {
                return 'RED';
            } else {
                return 'YELLOW';
            }
        }
        if($rgb['g'] > $rgb['r'] + 50) {
            if($rgb['g'] > $rgb['b'] + 50) {
                return 'GREEN';
            } else {
                return 'CYAN';
            }
        }
        if($rgb['g'] > $rgb['b'] + 50) {
            if($rgb['g'] > $rgb['r'] + 50) {
                return 'GREEN';
            }
        }
        if($rgb['b'] > $rgb['r'] + 50) {
            if($rgb['b'] > $rgb['g'] + 50) {
                return 'BLUE';
            }
        }
        //Check for black
        if($rgb['r'] < 40 && $rgb['g'] < 40 && $rgb['b'] < 40) {
            return 'BLACK';
        }
        //Check for white
        if($rgb['r'] > 240 && $rgb['g'] > 240 && $rgb['b'] > 240) {
            return 'WHITE';
        }
        return 'GREY';
    }
}