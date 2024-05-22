<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoArea;
use App\Models\Grupo;
use App\Models\Area;
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
            toastr()->error('Debe seleccionar áreas para crear o actualizar el grupo.', 'Error');
            return Redirect::back();
        }
    
        // Verificar si las áreas ya existen en el grupo
        $areasExistentes = GrupoArea::where('grupo_id', $grupoId)->pluck('area_id')->toArray();
    
        // Obtener las nuevas áreas que no están en el grupo
        $nuevasAreas = array_diff($areasSeleccionadas, $areasExistentes);
    
        // Si estamos guardando por primera vez, verificar si hay al menos dos áreas
        if (empty($areasExistentes) && count($nuevasAreas) < 2) {
            toastr()->error('Debe seleccionar al menos dos áreas para crear el grupo.', 'Error');
            return Redirect::back();
        }
    
        // Si estamos actualizando, permitir una nueva área si es diferente de las existentes
        if (!empty($areasExistentes) && count($nuevasAreas) == 0) {
            toastr()->error('Debe seleccionar al menos una área diferente para actualizar el grupo.', 'Error');
            return Redirect::back();
        }
    
        // Agregar las nuevas áreas al grupo
        foreach ($nuevasAreas as $areaId) {
            GrupoArea::create([
                'grupo_id' => $grupoId,
                'area_id' => $areaId
            ]);
        }
    
        toastr()->success('Áreas actualizadas exitosamente', 'Notificación');
        return Redirect::route('create.grupo');
    }

    public function quitarArea(Request $request)
    {
        // Obtener el ID del grupo y el ID del área a quitar
        $grupoId = $request->input('grupo_id');
        $areaId = $request->input('area_id');
    
        // Verificar si el grupo y el área existen
        $grupo = Grupo::find($grupoId);
        $area = Area::find($areaId);
    
        if (!$grupo || !$area) {
            toastr()->error('El grupo o el área no fueron encontrados.', 'Error');
            return Redirect::back();
        }
    
        // Buscar la relación entre el grupo y el área en la tabla grupo_area
        $relacion = GrupoArea::where('grupo_id', $grupoId)->where('area_id', $areaId)->first();
    
        if (!$relacion) {
            toastr()->error('La relación entre el grupo y el área no fue encontrada.', 'Error');
            return Redirect::back();
        }

        // Contar el número de áreas asociadas al grupo
        $totalAreas = GrupoArea::where('grupo_id', $grupoId)->count();

        // Verificar si el grupo tiene al menos dos áreas
        if ($totalAreas <= 2) {
            
            return Redirect::back();
        }
    
        // Actualizar el campo area_id a null en la tabla grupo_area
        $relacion->update(['area_id' => null]);
    
       
        return Redirect::back();
    }

    
}
