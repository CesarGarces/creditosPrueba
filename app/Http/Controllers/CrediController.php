<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrediController extends Controller
{

    public function show(){
        $clientes = DB::select("SELECT  SUM(valor_abono) as totalabonado,  documento, nombre, direccion, telefono, valor_credito, fecha_desembolso, valor_abono, fecha_abono, fecha_desembolso, saldo, intereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."' ORDER BY abonos.id_abono DESC" );
        //$clientes = DB::select("SELECT * FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento  WHERE clientes.documento = '".$_POST['Documento']."'" ); 
        
        return view('clientes.index', ['clientes' => $clientes]);  


    }

    public function abono($documento){
        //$abono = DB::select("SELECT * FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."'" );
        $clientes = DB::select("SELECT *  FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento  WHERE clientes.documento = '".$documento."'" ); 
 
        return view('clientes.abono', ['clientes' => $clientes]);  


    }
    public function valor($documento){
        $clientes = DB::select("SELECT  SUM(valor_abono) as totalabonado,  documento, nombre, direccion, telefono, valor_credito, fecha_desembolso, valor_abono, fecha_abono, fecha_desembolso, saldo, intereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$documento."' ORDER BY abonos.id_abono DESC" );
        $qlsalini = DB::select("SELECT id_credito, valor_credito, fecha_desembolso FROM creditos WHERE clientes_documento = '".$documento."' " );
        $qlfecha = DB::select("SELECT * FROM abonos INNER JOIN creditos on abonos.creditos_id_credito = creditos.id_credito WHERE creditos.clientes_documento = '".$documento."'" );
        $idCredito = $qlsalini[0]->id_credito;
        $salini = $qlsalini[0]->valor_credito; 
        $abono = $_POST['valAbono'];
        
        $fechaAbono = isset($qlfecha[0]->fecha_abono) ? $qlfecha[0]->fecha_abono : 0 ;
        
        if($fechaAbono == 0){
            $fechaAbono = $qlsalini[0]->fecha_desembolso;
        }else{
            $fechaAbono = $qlfecha[0]->fecha_abono;
        }
        
        $fechaEmision = Carbon::parse($qlsalini[0]->fecha_desembolso);
        $fechaExpiracion = Carbon::parse($fechaAbono);

        $diasinteres = $fechaExpiracion->diffInDays($fechaEmision);

        $interes = $salini * ($diasinteres) * 0.0004;
      
        $capital = $abono - $interes;
        $saldo = $qlsalini[0]->valor_credito - $capital;

        $qlinsert = DB::select("INSERT INTO abonos VALUES(NULL, '".$idCredito."', '".$abono."', '".$capital."', '".$interes."', '".$saldo."', NOW())" );
        
        //$abono = DB::select("SELECT * FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."'" );
        //$clientes = DB::select("SELECT * FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento  WHERE clientes.documento = '".$documento."'" ); 
        return view('clientes.index', ['clientes' => $clientes]);  
        //return 'interes: '. $idCredito;

    }

  
}
