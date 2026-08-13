<?php

namespace App\Livewire\Consultas\Reportes;

use App\Jobs\Reportes\ReporteSatJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Opcodes\LogViewer\Facades\Cache;

class ReporteSat extends Component
{

    public $exportacion;
    public $reportes = [];
    public $job_id;

    public function comenzarImportacion(){

        if(Cache::get("reporte_sat")){

            $this->exportacion = Cache::get("reporte_sat");

            $this->dispatch('mostrarMensaje', ['warning', "Ya existe un proceso activo para generar el reporte."]);

            return;

        }

        $total = DB::table('predios')->count();

        Cache::put("reporte_sat", [
                    'status'    => 'procesando',
                    'total'     => $total,
                    'procesados' => 0,
                ], now()->addMinutes(10));

        $job = new ReporteSatJob();

        $this->job_id = Queue::push($job);

        $this->exportacion = Cache::get("reporte_sat");

    }

    public function consultarExportacion()
    {

        $this->exportacion = Cache::get("reporte_sat");

    }

    public function descargar()
    {

        if(! $this->exportacion){

            return;

        }

        if($this->exportacion['total'] != $this->exportacion['procesados']){

            return;

        }

        return Storage::disk('s3')->temporaryUrl(
                                                    $this->exportacion['s3_path'],
                                                    now()->addMinutes(30),
                                                    [
                                                        'ResponseContentType' => 'application/octet-stream',
                                                        'ResponseContentDisposition' => 'attachment; filename="' . Str::replace('sgc/reportes/sat/', '', $this->exportacion['s3_path']) . '"'
                                                    ]
                                                    );

    }

    public function mount(){

        $files = Storage::disk('s3')->files('sgc/reportes/sat/');

        $this->reportes = array_map(function($file){

            return [
                'file' => $file,
                'link' => Storage::disk('s3')->temporaryUrl(
                                                                $file,
                                                                now()->addMinutes(30),
                                                                [
                                                                    'ResponseContentType' => 'application/octet-stream',
                                                                    'ResponseContentDisposition' => 'attachment; filename="' . Str::replace('sgc/reportes/sat/', '', $file) . '"'
                                                                ])
            ];

        }, $files);

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-sat')->extends('layouts.admin');
    }
}
