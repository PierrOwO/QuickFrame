<?php

namespace TCPDFWrapper;

require_once base_path('support/Libs/TCPDF-main/tcpdf.php');

use TCPDF as BaseTCPDF;

class PDF {

    protected BaseTCPDF $pdf;
    protected string $html = '';

    public function __construct()
    {
        $this->pdf = new BaseTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Admin');
        $this->pdf->SetTitle('Title of the file');
        $this->pdf->SetSubject('Subject of the file');
        $this->pdf->SetKeywords('TCPDF, PDF, przykład');

        $this->pdf->SetMargins(5, 5, 5);
        $this->pdf->SetHeaderMargin(5);
        $this->pdf->SetFooterMargin(5);
        $this->pdf->SetAutoPageBreak(true, 20);
        $this->pdf->SetFont('dejavusans', '', 12);
    }

    public static function new(): self
    {
        return new self();
    }

    public function author(string $author): self
    {
        $this->pdf->SetAuthor($author);
        return $this;
    }

    public function title(string $title): self
    {
        $this->pdf->SetTitle($title);
        return $this;
    }

    public function subject(string $subject): self
    {
        $this->pdf->SetSubject($subject);
        return $this;
    }

    public function keywords(string $keywords): self
    {
        $this->pdf->SetKeywords($keywords);
        return $this;
    }

    public function margins(int $left, int $top, int $right): self
    {
        $this->pdf->SetMargins($left, $top, $right);
        return $this;
    }

    public function headerMargin(int $margin): self
    {
        $this->pdf->SetHeaderMargin($margin);
        return $this;
    }

    public function footerMargin(int $margin): self
    {
        $this->pdf->SetFooterMargin($margin);
        return $this;
    }

    public function autoPageBreak(bool $auto, int $bottomMargin): self
    {
        $this->pdf->SetAutoPageBreak($auto, $bottomMargin);
        return $this;
    }

    public function font(string $family, string $style = '', int $size = 12): self
    {
        $this->pdf->SetFont($family, $style, $size);
        return $this;
    }

    public function addPage(string $orientation = 'P', string $format = 'A4'): self
    {
        $this->pdf->AddPage($orientation, $format);
        return $this;
    }

    public function content(string $html): self
    {
        $this->html = $html;
        $this->pdf->writeHTML($html, true, false, true, false, '');
        return $this;
    }

    public function output(string $filename = 'document.pdf', string $dest = 'I'): void
    {
        $this->pdf->Output($filename, $dest); // 'I' = inline, 'D' = download
    }
}