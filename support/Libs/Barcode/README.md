## Barcode Helper – `Barcode/Bardcode`

Generates 1D barcodes using Picqer\Barcode￼.

### Example Usage

```php
use Barcode\Barcode;

Barcode::new('123456789012')
    ->type('C128')
    ->width(2)
    ->height(60)
    ->showText(true)
    ->render();
```

### Methods
	•	new(string $data) – create a barcode instance
	•	type(string) – barcode type: C128, C39, C39+CHECK, EAN8, EAN13, UPC-A
	•	width(int) – barcode line width
	•	height(int) – barcode height
	•	showText(bool) – display value under barcode
	•	render() – outputs barcode in HTML

### Requirements
	•	PHP 8.0+
	•	picqer/php-barcode-generator