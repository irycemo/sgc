<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Tramite;
use App\Models\PredioAvaluo;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;

class Avaluo extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'notificado_en' => 'date'
    ];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'impreso' => 'green-400',
            'concluido' => 'yellow-400',
            'notificado' => 'gray-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function predioAvaluo(){
        return $this->belongsTo(PredioAvaluo::class, 'predio_avaluo');
    }

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function notificador(){
        return $this->belongsTo(User::class, 'notificado_por');
    }

    public function tramiteInspeccion(){
        return $this->belongsTo(Tramite::class, 'tramite_inspeccion');
    }

    public function tramiteDesglose(){
        return $this->belongsTo(Tramite::class, 'tramite_desglose');
    }

    public function imagenes(){
        return $this->morphMany(File::class, 'fileable');
    }

    public function encabezado(){

        $encabezado = $this->imagenes()->where('descripcion', 'encabezado')->first();

        return $encabezado
            ? Storage::disk('avaluos')->url($encabezado->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function fachada(){

        $fachada = $this->imagenes()->where('descripcion', 'fachada')->first();

        return $fachada
            ? Storage::disk('avaluos')->url($fachada->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function fachada_pdf(){

        $fachada = $this->imagenes()->where('descripcion', 'fachada')->first();

        return $fachada
            ? 'avaluos/' . $fachada->url
            : 'storage/img/escudo_guinda.png';

    }

    public function foto2(){

        $foto2 = $this->imagenes()->where('descripcion', 'foto2')->first();

        return $foto2
            ? Storage::disk('avaluos')->url($foto2->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function foto2_pdf(){

        $foto2 = $this->imagenes()->where('descripcion', 'foto2')->first();

        return $foto2
            ? 'avaluos/' . $foto2->url
            : 'storage/img/escudo_guinda.png';

    }

    public function foto3(){

        $foto3 = $this->imagenes()->where('descripcion', 'foto3')->first();

        return $foto3
            ? Storage::disk('avaluos')->url($foto3->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function foto3_pdf(){

        $foto3 = $this->imagenes()->where('descripcion', 'foto3')->first();

        return $foto3
            ? 'avaluos/' . $foto3->url
            : 'storage/img/escudo_guinda.png';

    }

    public function foto4(){

        $foto4 = $this->imagenes()->where('descripcion', 'foto4')->first();

        return $foto4
            ? Storage::disk('avaluos')->url($foto4->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function foto4_pdf(){

        $foto4 = $this->imagenes()->where('descripcion', 'foto4')->first();

        return $foto4
            ? 'avaluos/' . $foto4->url
            : 'storage/img/escudo_guinda.png';

    }

    public function macrolocalizacion(){

        $macrolocalizacion = $this->imagenes()->where('descripcion', 'macrolocalizacion')->first();

        return $macrolocalizacion
            ? Storage::disk('avaluos')->url($macrolocalizacion->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function macrolocalizacion_pdf(){

        $macrolocalizacion = $this->imagenes()->where('descripcion', 'macrolocalizacion')->first();

        return $macrolocalizacion
            ? 'avaluos/' . $macrolocalizacion->url
            : 'storage/img/escudo_guinda.png';

    }

    public function microlocalizacion(){

        $microlocalizacion = $this->imagenes()->where('descripcion', 'microlocalizacion')->first();

        return $microlocalizacion
            ? Storage::disk('avaluos')->url($microlocalizacion->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function microlocalizacion_pdf(){

        $microlocalizacion = $this->imagenes()->where('descripcion', 'microlocalizacion')->first();

        return $microlocalizacion
            ? 'avaluos/' . $microlocalizacion->url
            : 'storage/img/escudo_guinda.png';

    }

    public function poligonoImagen(){

        $poligonoImagen = $this->imagenes()->where('descripcion', 'poligonoImagen')->first();

        return $poligonoImagen
            ? Storage::disk('avaluos')->url($poligonoImagen->url)
            : Storage::disk('public')->url('img/ico.png');
        ;

    }

    public function poligonoImagen_pdf(){

        $poligonoImagen = $this->imagenes()->where('descripcion', 'poligonoImagen')->first();

        return $poligonoImagen
            ? 'avaluos/' . $poligonoImagen->url
            : 'storage/img/escudo_guinda.png';

    }

}
