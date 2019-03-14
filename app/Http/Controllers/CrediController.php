<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrediController extends Controller
{

    public function show(){
        $clientes = DB::select("SELECT  SUM(valor_abono) as totalabonado,  documento, nombre, direccion, telefono, valor_credito, fecha_desembolso, valor_abono, abono_capital, fecha_abono, fecha_desembolso, saldo, intereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."' order by abonos.fecha_abono asc LIMIT 1" );
        $abonos = DB::select("SELECT   valor_credito, fecha_desembolso, valor_abono, abono_capital, fecha_abono, fecha_desembolso, saldo, intereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."' order by abonos.fecha_abono  asc " );
        $intereses = DB::select("SELECT  SUM(intereses) as totalintereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$_POST['Documento']."' order by abonos.id_abono asc LIMIT 1" );
        return view('clientes.index', ['clientes' => $clientes], ['abonos' => $abonos], ['intereses' => $intereses]);  
    }

    public function abono($documento){
        $clientes = DB::select("SELECT *  FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento  WHERE clientes.documento = '".$documento."'" ); 
        return view('clientes.abono', ['clientes' => $clientes]);  
    }
    public function valor($documento){
        $clientes = DB::select("SELECT  SUM(valor_abono) as totalabonado,  documento, nombre, direccion, telefono, valor_credito, fecha_desembolso, valor_abono, fecha_abono, fecha_desembolso, saldo, intereses FROM clientes INNER JOIN creditos on clientes.documento = creditos.clientes_documento INNER JOIN abonos on abonos.creditos_id_credito = creditos.id_credito WHERE clientes.documento = '".$documento."' order by abonos.id_abono asc LIMIT 1" );
        $qlsalini = DB::select("SELECT id_credito, valor_credito, fecha_desembolso FROM creditos WHERE clientes_documento = '".$documento."' " );
        $qlultimoabono = DB::select("SELECT * FROM abonos INNER JOIN creditos on abonos.creditos_id_credito = creditos.id_credito WHERE creditos.clientes_documento = '".$documento."' order by abonos.id_abono desc  LIMIT 1" );

        $idCredito = $qlsalini[0]->id_credito;
        $salini = $qlsalini[0]->valor_credito;
        
        $abono = $_POST['valAbono'];

        $abonoCap = isset($qlultimoabono[0]->abono_capital) ? $qlultimoabono[0]->abono_capital : 0 ;
        $fechaAbono = isset($qlultimoabono[0]->fecha_abono) ? $qlultimoabono[0]->fecha_abono : 0 ;
        
        if($fechaAbono == 0){
            $fechaAbono = $qlsalini[0]->fecha_desembolso;
        }else{
            $fechaAbono = $qlultimoabono[0]->fecha_abono;
        }

        if($fechaAbono == $qlsalini[0]->fecha_desembolso){
            $fechaExpiracion = Carbon::parse('now');
            $fechaEmision = Carbon::parse($qlsalini[0]->fecha_desembolso);
        }else{
            $fechaExpiracion = Carbon::parse('now');
            $fechaEmision = Carbon::parse($qlultimoabono[0]->fecha_abono);
        }
    
        $diasinteres = $fechaExpiracion->diffInDays($fechaEmision);
        
       if($abonoCap == 0){
        $abonoCap = $abono;
        $interes = $salini * ($diasinteres) * 0.0004;
        $capital = $abono - $interes; 
        $saldo = $qlsalini[0]->valor_credito - $capital;
       }else{
        $abonoCap = $qlultimoabono[0]->abono_capital;
        $interes = $qlultimoabono[0]->saldo * ($diasinteres) * 0.0004;
        $capital = $abono - $interes; 
        $saldo = $qlultimoabono[0]->saldo - $capital;
       }
        
        

        //echo "fecha ". $abonoCap;
        //exit(0);

        $qlinsert = DB::select("INSERT INTO abonos VALUES(NULL, '".$idCredito."', '".$abono."', '".$capital."', '".$interes."', '".$saldo."', NOW())" );
        
        return view('welcome'); 
         
    } 
}
