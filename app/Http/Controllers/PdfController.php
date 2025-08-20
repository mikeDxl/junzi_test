<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosBaja;
use App\Models\Colaboradores;
use App\Models\Bajas;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    public function pdfFiniquito(Request $request)
   {
       
       $datosbaja = DatosBaja::findOrFail($request->datosbajaid);

       $baja = Bajas::findOrFail($datosbaja->baja_id);

       DatosBaja::where('id',$datosbaja->id)->update([
        'colaborador_id' => $baja->colaborador_id
       ]);

       

       $colaborador = Colaboradores::findOrFail($request->colaborador_id);

       // Genera el PDF utilizando DomPDF
       $pdf = PDF::loadView('pdf.finiquito', ['datosbaja' => $datosbaja , 'colaborador' => $colaborador]);

       // Retorna el PDF para descargar o visualizar en el navegador
       return $pdf->download('formato_baja.pdf');
   }
}
