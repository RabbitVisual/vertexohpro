<?php

namespace Modules\Library\Services;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class WatermarkService
{
    public function apply(string $pdfPath, string $watermarkText): string
    {
        // Check if Fpdi class exists, if not we might be missing FPDF
        if (!class_exists(Fpdi::class)) {
            throw new \Exception('FPDI library not found.');
        }

        $pdf = new Fpdi();

        // Handle file path or content. FPDI needs a path usually.
        // Assuming $pdfPath is a local filesystem path.
        if (!file_exists($pdfPath)) {
            throw new \Exception("File not found: {$pdfPath}");
        }

        $pageCount = $pdf->setSourceFile($pdfPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            // Add page with same size/orientation
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Set font
            $pdf->SetFont('Helvetica', 'I', 8);
            $pdf->SetTextColor(150, 150, 150); // Light gray

            // Calculate position (bottom center)
            $text = "Licenciado para: " . $watermarkText;
            $textWidth = $pdf->GetStringWidth($text);
            $x = ($size['width'] - $textWidth) / 2;
            $y = $size['height'] - 10; // 10 units from bottom

            $pdf->SetXY($x, $y);
            $pdf->Write(0, $text);
        }

        return $pdf->Output('S'); // Return as string
    }
}
