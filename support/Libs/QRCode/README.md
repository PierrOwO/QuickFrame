## PDF QRCode – `QRCode\QRCode`

Generates QR codes using chillerlan/php-qrcode￼.

### Example Usage

```php
use QRCode\QRCode;

QRCode::new('https://quickframe.pieterapps.pl')
    ->scale(4)
    ->margin(2)
    ->bgColor('#ffffff')
    ->fgColor('#000000')
    ->size('200px')
    ->render();
```

### Methods
	•	new(string $data) – creates a QR code instance
	•	scale(int) – size of each QR code module
	•	version(int) – QR version (1–40)
	•	margin(int) – margin in modules
	•	eccLevel(string) – error correction level (L, M, Q, H)
	•	imageBase64(bool) – render as base64 image
	•	bgColor(string) – background color
	•	fgColor(string) – foreground color
	•	size(string) – HTML <img> size
	•	render() – outputs QR code in HTML

### Requirements
	•	PHP 8.0+
	•	chillerlan/php-qrcode