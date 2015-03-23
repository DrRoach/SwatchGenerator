<?php

class Generate
{
    public function __construct(array $params = [])
    {
        /**
         * Load in the autoloader
         */
        spl_autoload_register('self::autoload');

        /**
         * Check to make sure that all parameters are added
         */
        $die = self::validateParams($params);

        /**
         * If $die has been set, data is missing. Throw error and give message
         */
        if ($die !== false) {
            switch ($die) {
                case 'colour':
                    throw new Exception('You must provide a colour', 400);
                case 'width':
                    throw new Exception('You must provide a swatch width', 400);
                case 'height':
                    throw new Exception('You must provide a swatch height', 400);
                case 'image':
                    throw new Exception('You must provide a image', 400);
                case 'file':
                    throw new Exception('You must provide a swatch file name', 400);
                default:
                    throw new Exception('There are parameters missing', 400);
            }
        }

        /**
         * Parse the image to get the swatch coordinates
         */
        Image::findSwatch();

        Data::$COLOUR = $params['colour'];
    }

    /**
     * @param $params
     * @return false|string
     * @throws Exception
     */
    private static function validateParams($params)
    {
        $die = false;
        empty($params['colour']) ? $die = 'colour' : Data::$COLOUR = $params['colour'];
        empty($params['swatch']['width']) ? $die = 'width' : Data::$SWATCH['width'] = $params['swatch']['width'];
        empty($params['swatch']['height']) ? $die = 'height' : Data::$SWATCH['height'] = $params['swatch']['height'];
        empty($params['image']) ? $die = 'image' : Data::$IMAGE = $params['image'];
        empty($params['file']) ? $die = 'file' : Data::$FILE = $params['file'];
        empty($params['accuracy']) ? null : Data::$ACCURACY = $params['accuracy'];

        if (!file_exists(Data::$IMAGE)) {
            throw new Exception('The image you provided couldn\'t be found', 400);
        }

        return $die;
    }

    public function autoload($class)
    {
        require_once $class.'.php';
    }
}