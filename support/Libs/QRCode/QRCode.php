<?php

namespace QRCode;

use chillerlan\QrCode\QRCode as PHPQRCode;
use chillerlan\QrCode\QROptions;
use Support\Vault\Sanctum\Log;

class QRCode {

    public int $version = 5;
    public int $scale = 8;
    public int $margin = 2;
    public string $eccLevel = 'M';
    public bool $imageBase64 = true;
    public string $bgColor = '#ffffff';
    public string $fgColor = '#000000';

    public string $qrData = 'quickframe.pieterapps.pl';

    public string $size = '100px';

    public static function new($data): self
    {
        $instance = new self();
        if (!empty($data)) {
            $instance->qrData = $data;
        }
        return $instance;
    }
    
    public function render()
    {
        $options = new QROptions([
            'version'     => $this->version,
            'scale'       => $this->scale,
            'margin'      => $this->margin,
            'eccLevel'    => $this->eccLevel,
            'imageBase64' => $this->imageBase64,
            'bgColor'     => $this->bgColor,
            'fgColor'     => $this->fgColor,
        ]);

        echo '<img style="width: '. $this->size .'; height: '. $this->size .'" src="'.(new PHPQRCode($options))->render($this->qrData).'" alt="QR Code" />';
    }

    public function scale($data) { 
        $this->scale = $data; 
        return $this; 
    }
    
    public function version($data) { 
        $this->version = $data; 
        return $this; 
    }
    
    public function margin($data) { 
        $this->margin = $data; 
        return $this; 
    }
    
    public function eccLevel($data) { 
        $this->eccLevel = $data; 
        return $this; 
    }
    
    public function imageBase64($data) { 
        $this->imageBase64 = $data; 
        return $this; 
    }
    
    public function bgColor($data) { 
        $this->bgColor = $data; 
        return $this; 
    }
    
    public function fgColor($data) { 
        $this->fgColor = $data; 
        return $this; 
    }

    public function size($data) { 
        $this->size = $data; 
        return $this; 
    }

}