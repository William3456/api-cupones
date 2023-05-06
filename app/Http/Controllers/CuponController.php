<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CuponController extends Controller
{

    public function getCuponById($id){

        $cupon = DB::select('SELECT * FROM cupones WHERE id_cupon = ?', array($id));
        return response()->json([
            'status' => 200,
            'body' => $cupon
        ]);
    }

    public function updateCupon($id){

        $cupon = DB::select('SELECT * FROM cupones WHERE id_cupon = ?', array($id));

        if ($cupon != null){
            if ($cupon[0]->vencido != 0){
                return response()->json([
                    'status' => 400,
                    'body' => null,
                    'msj' => 'Cupon vencido'
                ]);
            }else if($cupon[0]->estado == 1){
                return response()->json([
                    'status' => 400,
                    'body' => null,
                    'msj' => 'Cupon ya canjeado'
                ]);
            }else{
                $cuponUpd = DB::table('cupones')
                    ->where('id_cupon', $id)
                    ->update(['estado' => 1]);
                $cupon = DB::select('SELECT * FROM cupones WHERE id_cupon = ?', array($id));
                return response()->json([
                    'status' => 200,
                    'msj' => 'Actualizado',
                    'body' => $cupon,
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'body' => $cupon
            ]);
        }

    }
}
