<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function savePDF(Request $request)
    {
        try {
            $pdfContent = $request->input('pdfContent');

            $filename = 'pdf_' . time() . '.pdf';

            $pdfPath = public_path('pdfs/' . $filename);

            file_put_contents($pdfPath, $pdfContent);

            return response()->json(['message' => 'PDF guardado exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al guardar el PDF']);
        }
    }
}
