# SwatchGenerator
Automatically generate a image swatches using a basic set colour.

###Example

```PHP
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
```

###Available Colours
- [x] Red
- [x] Green
- [x] Blue
- [x] Cyan
- [x] Purple
- [x] Yellow
- [x] White
- [x] Black
- [x] Grey
- [ ] Orange
- [ ] Pink

###TODO
- [ ] Improve the colour finding accuracy
- [ ] Improve loading speed on larger images
- [ ] Improve code quality
- [ ] Allow choice between png and jpg swatches
- [ ] Allow user to decide swatch quality
- [ ] Add more colours
