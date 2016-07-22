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
        $this->validateInput($params);
	    
        /**
         * Store all of the data that we need to find our swatch
         */
        Data::$COLOUR = $params['colour'];
        Data::$SWATCH['width'] = $params['swatch']['width'];
        Data::$SWATCH['height'] = $params['swatch']['height'];
        Data::$IMAGE = $params['image'];
        Data::$FILE = $params['file'];
        Data::$ACCURACY = (!empty($params['accuracy']) ? $params['accuracy'] : null);
		
        /**
         * Parse the image to get the swatch coordinates
         */
        Image::findSwatch();
    }

    private function validateInput($params)
    {
        switch(true) {
	        case (empty($params['colour'])) :
                throw new Exception('You must provide a colour.', 400);
            break;
            case (empty($params['swatch']['width'])) :
                throw new Exception('You must provide a swatch width.', 400);
            break;
            case (empty($params['swatch']['height'])) :
                throw new Exception('You must provide a swatch height.', 400);
            break;
            case (empty($params['image'])) :
                throw new Exception('You must provide an image.', 400);
            break;
            case (empty($params['file'])) :
                throw new Exception('You must prove a swatch file name.', 400);
            break;
	    }

        return true;
    }

    public function autoload($class)
    {
        require_once $class.'.php';
    }
}
