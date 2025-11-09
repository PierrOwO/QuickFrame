## TCPDFWrapper\PDF Helper – `TCPDFWrapper\PDF`

Based on [TCPDF](https://tcpdf.org). Allows generating A4 PDF documents with HTML and CSS content.

### Example Usage

```php
use TCPDFWrapper\PDF;

$html = '<h1>Monthly Report</h1><p>This is a sample PDF.</p>';

PDF::new()
    ->author('XYZ')
    ->title('A4 Report')
    ->addPage('P', 'A4')   // P - portrait, L - landscape
    ->content($html)
    ->output('report.pdf', 'd'); // 'd' = download, 'i' = inline
```

### Methods
	•	new() – creates a new PDF instance
	•	author(string) – sets the document author
	•	title(string) – sets the document title
	•	addPage(string $orientation, string $size) – adds a page
	•	content(string $html) – sets HTML content
	•	output(string $filename, string $dest) – generates the PDF (d = download, i = inline)

### Requirements
	•	PHP 8.0+
	•	TCPDF library (tecnickcom/tcpdf)