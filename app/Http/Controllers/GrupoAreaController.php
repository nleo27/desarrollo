<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoArea;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class GrupoAreaController extends Controller
{
    public function guardarAreas(Request $request)
    {
       
        
        $grupoId = $request->input('grupo_id');
        $areasSeleccionadas = $request->input('areas');
    
         // Verificar si no se han seleccionado áreas
         if (empty($areasSeleccionadas)) {
            toastr()->error('Debe seleccionar áreas para crear un grupo.', 'Error');
            return Redirect::back();
        }
     
        
        if (count($areasSeleccionadas) < 2) {
            toastr()->error('Debe seleccionar al menos dos áreas para crear un grupo.', 'Error');
            return Redirect::back();
        }


        // Verificar si las áreas ya existen en el grupo
            $areasExistentes = GrupoArea::where('grupo_id', $grupoId)->pluck('area_id')->toArray();
                     

            // Verificar si al menos una de las áreas es diferente a las existentes en el grupo
                $diferentes = false;
                foreach ($areasSeleccionadas as $areaId) {
                    if (!in_array($areaId, $areasExistentes)) {
                        $diferentes = true;
                        break;
                    }
                }

                if (!$diferentes) {
                    toastr()->error('Al menos una de las áreas seleccionadas debe ser diferente a las existentes en el grupo.', 'Error');
                    return Redirect::back();
                }


                
       
                foreach ($areasSeleccionadas as $areaId) {
            GrupoArea::create([
                'grupo_id' => $grupoId,
                'area_id' => $areaId
            ]);
        }
    
       

        toastr()->success('Areas Agregadas Exitosamente', 'Notificacion');
        return Redirect::route('create.grupo');
        
    }
}
