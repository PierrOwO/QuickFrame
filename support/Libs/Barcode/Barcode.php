<?php

namespace Barcode;

use Picqer\Barcode\BarcodeGeneratorPNG;

class Barcode {

    public string $data = '';
    public string $type = 'C128';
    public int $width = 2;
    public int $height = 60;
    public bool $showText = true;

    public static function new(string $data): self {
        $instance = new self();
        $instance->data = $data;
        return $instance;
    }

    public function type(string $type): self {
        $this->type = $type;
        return $this;
    }

    public function width(int $width): self {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): self {
        $this->height = $height;
        return $this;
    }

    public function showText(bool $showText): self {
        $this->showText = $showText;
        return $this;
    }

    public function render(): void {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($this->data, $this->resolveType(), $this->width, $this->height);

        $base64 = base64_encode($barcode);
        echo '<img src="data:image/png;base64,' . $base64 . '" alt="Barcode">';
    }

    protected function resolveType(): string {
        return match(strtoupper($this->type)) {
            'C39'        => BarcodeGeneratorPNG::TYPE_CODE_39,
            'C39+CHECK'  => BarcodeGeneratorPNG::TYPE_CODE_39_CHECKSUM,
            'EAN8'       => BarcodeGeneratorPNG::TYPE_EAN_8,
            'EAN13'      => BarcodeGeneratorPNG::TYPE_EAN_13,
            'UPC-A'      => BarcodeGeneratorPNG::TYPE_UPC_A,
            'C128'       => BarcodeGeneratorPNG::TYPE_CODE_128,
            default      => BarcodeGeneratorPNG::TYPE_CODE_128,
        };
    }
}