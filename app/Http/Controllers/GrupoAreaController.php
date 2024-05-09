<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoArea;

class GrupoAreaController extends Controller
{
    public function guardarAreas(Request $request)
    {
        $grupoId = $request->input('grupo_id');
        $areasSeleccionadas = $request->input('areas');

        foreach ($areasSeleccionadas as $areaId) {
            GrupoArea::create([
                'grupo_id' => $grupoId,
                'area_id' => $areaId
            ]);
        }

        toastr()->success('Áreas agregadas correctamente', 'Notificación');

        // Redirecciona a la página de áreas
        return back();
    }
}
