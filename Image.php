<?php

class Image
{
    private static $IMAGE;
    private static $X;
    private static $Y;
    private static $MOVE = 'r';
    private static $COUNT = 0;
    private static $COLOURS;

    public static function findSwatch()
    {
        /**
         * Create the image as a resource
         * TODO:
         * This can be quite slow at the minute. Runnning 'Example.php', this function
         * takes 0.3s to load, Nearly a third of the total load time. After further looking,
         * `imagecreatefrompng()` takes about 0.3s to load. There is nothing that can
         * be done about this unfortunately.
         */
        ini_set('memory_limit', '-1');
        self::createResource(Data::$IMAGE);

        self::$COLOURS = json_decode(file_get_contents('Colours.json'), 1);

        /**
         * Parse the image
         * TODO:
         * This can take a long time to load, this needs to be improved as it is the biggest
         * bottleneck in the system at the minute. Running 'Example.php', it takes around 0.8s
         * to load.
         */
        self::imageParse();

        /**
         * Create the swatch
         * This takes no time to run, cannot be improved for efficiency
         */
        Swatch::create(self::$IMAGE, self::$X, self::$Y);
    }

    private static function createResource($image)
    {
        /**
         * Get the Image file extension
         */
        $s = microtime(true);
        $extension = substr($image, strripos($image, '.') + 1);

        /**
         * Create the image resource depending on the extension
         */
        $s = microtime(true);
        switch ($extension) {
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
        $previousColours = [];
        //Add one to keep in image bounds
        while (self::$X + 1 < imagesx(self::$IMAGE) && self::$Y + 1 < imagesy(self::$IMAGE)) {
            /**
             * If the last five colours are the same, just a block
             */
            $pos = sizeof($previousColours) - 1;
            if ($pos > 5) {
                $same = true;
                for (; $pos > 0; $pos--) {
                    if ($colour != $previousColours[$pos]) {
                        $same = false;
                    }
                }
                if ($same == true) {
                    self::$COUNT += (Data::$ACCURACY * 3);
                    switch(self::$MOVE) {
                    case 'r':
                        self::$X += self::$COUNT;
                        self::$MOVE = 'd';
                        break;
                    case 'd':
                        self::$Y += self::$COUNT;
                        self::$MOVE = 'l';
                        break;
                    case 'l':
                        self::$X -= self::$COUNT;
                        self::$MOVE = 'u';
                        break;
                    case 'u':
                        self::$Y -= self::$COUNT;
                        self::$MOVE = 'r';
                        break;
                    }
                }
            }

            /**
             * Get next pixel
             */
            self::nextPixel();
            $rgb = self::getPixelColour(self::$X, self::$Y);
            $colour = self::getColourValue($rgb);
            if ($colour == strtoupper(Data::$COLOUR)) {
                break;
            }
            $previousColours[] = $colour;
        }
        if (empty($colour)) {
            throw new Exception("The colour that you entered couldn't be found", 500);
        }
    }

    private static function nextPixel()
    {
        if (empty(self::$X) || empty(self::$Y)) {
            //Use the centre of the image
            self::$X = imagesx(self::$IMAGE) / 2;
            self::$Y = imagesy(self::$IMAGE) / 2;
            return;
        }
        switch (self::$MOVE) {
            case 'r':
                self::$COUNT += Data::$ACCURACY;
                self::$X += self::$COUNT;
                self::$MOVE = 'd';
                break;
            case 'd':
                self::$Y += self::$COUNT;
                self::$MOVE = 'l';
                break;
            case 'l':
                self::$COUNT += Data::$ACCURACY;
                self::$X -= self::$COUNT;
                self::$MOVE = 'u';
                break;
            case 'u':
                self::$Y -= self::$COUNT;
                self::$MOVE = 'r';
                break;
        }
        if (self::$X >= imagesx(self::$IMAGE)) {
            self::$X = imagesx(self::$IMAGE) - 1;
        }
        if (self::$Y >= imagesy(self::$IMAGE)) {
            self::$Y = imagesy(self::$IMAGE) - 1;
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
        /**
         * Narrow down the list of colours
         */
        $result = self::$COLOURS;
        $diff = 15;
        while (sizeof($result) > 1) {
            if ($diff <= 0) {
                break;
            }
            foreach ($result as $key => $c) {
                if ($rgb['r'] < $c['x'] - $diff || $rgb['r'] > $c['x'] + $diff) {
                    unset($result[$key]);
                    continue;
                }
                if ($rgb['g'] < $c['y'] - $diff || $rgb['g'] > $c['y'] + $diff) {
                    unset($result[$key]);
                    continue;
                }
                if ($rgb['b'] < $c['z'] - $diff || $rgb['b'] > $c['z'] + $diff) {
                    unset($result[$key]);
                    continue;
                }
            }
            $diff--;
        }

        foreach ($result as $r) {
            unset($result);
            $result = $r['label'];
            break;
        }

        if (is_array($result)) {
            return null;
        }

        $colour = self::parseColourName($result);

        return strtoupper($colour);
    }

    private static function parseColourName($colour)
    {
        $words = explode(' ', $colour);
        foreach ($words as $w) {
            switch (strtolower($w)) {
                case 'red':
                    return 'RED';
                case 'green':
                    return 'GREEN';
                case 'blue':
                    return 'BLUE';
                case 'purple':
                    return 'PURPLE';
                case 'cyan':
                    return 'CYAN';
                case 'yellow':
                    return 'YELLOW';
                case 'white':
                    return 'WHITE';
                case 'grey':
                    return 'GREY';
                case 'black':
                    return 'BLACK';
                case 'orange':
                    return 'ORANGE';
            }
        }
    }
}
