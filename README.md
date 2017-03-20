# SwatchGenerator
Automatically generate an image swatches using a basic set colour.

Take an image and create a smaller swatch / thumbnail of it automatically depending on a given "simple" colour. You can set the size of the new swatch and set it's name too.

### Example

```PHP
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
```

##### Original Image:
![Original snorkel]
(http://i.imgur.com/L7C2CQP.png)

##### Generated Swatch:
![Generated swatch]
(http://i.imgur.com/i0Ei7te.png)

##### Time taken:
2.4309871196747 seconds

### Parameters

##### image
The name of your image.

##### swatch
###### width
The width of the swatch.

###### height
The height of the swatch.

##### colour
The colour that you want to base the swatch on.

##### file
The name of the outputted swatch.

##### accuracy (optional)
The colour finding accuracy in pixels.

### Available Colours
- [x] Red
- [x] Green
- [x] Blue
- [x] Cyan
- [x] Purple
- [x] Yellow
- [x] White
- [x] Black
- [x] Grey
- [x] Orange
- [ ] Pink

### TODO
- [ ] Improve loading speed on larger images
- [ ] Improve code quality
- [ ] Allow choice between png and jpg swatches
- [ ] Allow user to decide swatch quality
- [ ] Add more colours
