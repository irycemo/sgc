<?php

namespace App\Http\Controllers\Admin\Predios;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Models\Predio;
use App\Models\Tramite;
use App\Models\Traslado;

class PrediosController extends Controller
{

    public function __invoke(Predio $predio){

        $predio->load(
            'propietarios.persona',
            'terrenosComun',
            'construccionesComun',
            'terrenos',
            'construcciones',
            'colindancias',
            'audits.user:id,name',
            'audits.tramite:id,año,folio,usuario',
            'bloqueos.creadoPor',
            'bloqueos.actualizadoPor',
            'movimientos.creadoPor'
        );

        $audits_ids = [];

        $traslados = Traslado::with('audits')->where('predio_id', $predio->id)->pluck('id');

        $audits_traslados = Audit::where('auditable_type', 'App\Models\Traslado')->whereIn('auditable_id', $traslados)->pluck('id')->toArray();

        array_push($audits_ids, ...$audits_traslados);

        $certificaciones = Certificacion::with('audits')->where('predio_id', $predio->id)->pluck('id');

        $audits_certificados = Audit::where('auditable_type', 'App\Models\Certificacion')->whereIn('auditable_id', $certificaciones)->pluck('id')->toArray();

        array_push($audits_ids, ...$audits_certificados);

        $avaluos = Avaluo::with('audits')->where('predio', $predio->id)->pluck('id');

        $audits_avaluos = Audit::where('auditable_type', 'App\Models\Avaluo')->whereIn('auditable_id', $avaluos)->pluck('id')->toArray();

        array_push($audits_ids, ...$audits_avaluos);

        $tramites = Tramite::with('audits')->whereHas('predios', function($q) use($predio){ $q->where('predio_id', $predio->id); })->pluck('id');

        $audits_tramites = Audit::where('auditable_type', 'App\Models\Tramite')->whereIn('auditable_id', $tramites)->pluck('id')->toArray();

        array_push($audits_ids, ...$audits_tramites);

        $audits_predio = $predio->audits->pluck('id')->toArray();

        array_push($audits_ids, ...$audits_predio);

        $auditoria_completa = Audit::with('user', 'tramite')->whereIn('id', $audits_ids)->latest()->get();

        return view('admin.predios.show', compact('predio', 'auditoria_completa'));

    }

}
