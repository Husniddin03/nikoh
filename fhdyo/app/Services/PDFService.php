<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\TestResult;
use App\Models\Couple;

class PDFService
{
    public function generateTestResultPDF(TestResult $testResult)
    {
        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        // Load the view
        $html = view('admin.results.pdf', compact('testResult'))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf;
    }
    
    public function downloadTestResultPDF(TestResult $testResult)
    {
        $dompdf = $this->generateTestResultPDF($testResult);
        
        $filename = 'test-result-' . $testResult->id . '-' . $testResult->couple->jshshir_user . '.pdf';
        
        return $dompdf->stream($filename);
    }
    
    public function saveTestResultPDF(TestResult $testResult, $path = null)
    {
        $dompdf = $this->generateTestResultPDF($testResult);
        
        if (!$path) {
            $path = storage_path('app/public/test-results/');
        }
        
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        
        $filename = 'test-result-' . $testResult->id . '-' . $testResult->couple->jshshir_user . '.pdf';
        $fullPath = $path . $filename;
        
        file_put_contents($fullPath, $dompdf->output());
        
        return $fullPath;
    }
}
