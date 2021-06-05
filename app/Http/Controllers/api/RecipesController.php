<?php

namespace App\Http\Controllers\api;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aquí dentro vamos a mostrar un listado en JSON de todas las personas.
        // Devolveremos un array en JSON con el contenido.
        // Ejemplo: return response()->json(["titulo" => 'HOla mundo Laravel']);

        // Dentro de una API REST deberíamos dar siempre una respuesta acorde a la petición.
        // A la hora de devolver datos en una API para cumplir correctamente el estandard se debería devolver el código de respuesta (status) también.
        // https://developer.amazon.com/es/docs/amazon-drive/ad-restful-api-response-codes.html
        $recipes = Recipe::orderBy("nombre")->paginate(10);

        // En este estado devolvemos un status 200
        //return response()->json(['status' => 'ok', 'data' => $personas], 200);
        return response()->json(['data' => $recipes,'code' => 200, 'status' => 'ok' ], 200);;

        // // Si queremos devolver todos los datos de esa persona junto con los hospitales y vacunas que ha realizado tendríamos que hacer algo como:
        // $todoslosdatos = DB::table('personas')
        //     ->join('hospital_persona', 'personas.id', '=', 'hospital_persona.persona_id')
        //     ->join('hospitales', 'hospital_id', '=', 'hospitales.id')
        //     ->orderBy('personas.nombre')->get();

        // $todoslosdatos = DB::table('personas')
        //     ->join('hospital_persona', 'personas.id', '=', 'hospital_persona.persona_id')
        //     ->join('hospitales', 'hospital_id', '=', 'hospitales.id')
        //     ->orderBy('personas.nombre')
        //     ->select('personas.*', 'hospitales.nombre as HospitalNombre')->paginate(10);

        // $todoslosdatos = DB::table('personas')
        //     ->join('hospital_persona', 'personas.id', '=', 'hospital_persona.persona_id')
        //     ->join('hospitales', 'hospital_id', '=', 'hospitales.id')
        //     ->orderBy('personas.nombre')
        //     ->select('personas.nombre', 'personas.apellidos', 'personas.telefono', 'fecha_vacunacion', 'hospitales.nombre as HospitalNombre', 'hospitales.telefono as TelefHospital')->paginate(10);

        // // return response()->json(['data' => $todoslosdatos,'code' => 200, 'status' => 'ok' ], 200);
        // return $this->respuestaExito($todoslosdatos);
        // // return $this->respuestaExito($todoslosdatos, 500);
    }

 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        // return response()->json(['status' => 'ok', 'code' => 200, 'data' => $persona], 200);

        return response()->json(['data' => $recipe,'code' => 200, 'status' => 'ok' ], 200);
    }
}
