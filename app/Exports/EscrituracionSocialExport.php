<?php

namespace App\Exports;

use App\Models\Tramite;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class EscrituracionSocialExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public function __construct(
        public $estado,
        public $servicio,
        public $dependencia,
        public $usuario,
        public $oficina,
        public $fecha1,
        public $fecha2
    ){}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tramite::with('servicio', 'creadoPor', 'actualizadoPor')
                            ->where('solicitante', 'Escrituración social')
                            ->when (isset($this->estado) && $this->estado != "", function($q){
                                $q->where('estado', $this->estado);
                            })
                            ->when (isset($this->servicio) && $this->servicio != "", function($q){
                                $q->where('servicio_id', $this->servicio);
                            })
                            ->when(isset($this->dependencia) && $this->dependencia != "", function($q){
                                return $q->where('nombre_solicitante', $this->dependencia);
                            })
                            ->when(isset($this->usuario) && $this->usuario != "", function($q){
                                return $q->where('creado_por', $this->usuario);
                            })
                            ->when(isset($this->oficina) && $this->oficina != "", function($q){
                                $q->whereHas('creadoPor', function($q){
                                    $q->select('id', 'oficina_id')
                                        ->where('oficina_id', $this->oficina);
                                });
                            })
                            ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                            ->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(storage_path('app/public/img/logo2.png'));
        $drawing->setHeight(90);
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            'Trámite',
            'Estado',
            'Servicio',
            'Solicitante',
            'Número de oficio',
            'Cantidad',
            'Registrado en',
            'Registrado por',
            'Oficina',
            'observaciones'
        ];
    }

    public function map($tramite): array
    {
        return [
            $tramite->año . '-'. $tramite->folio . '-' . $tramite->usuario,
            $tramite->estado,
            $tramite->servicio->nombre,
            $tramite->nombre_solicitante,
            $tramite->numero_oficio ?? 'N/A',
            $tramite->cantidad,
            $tramite->created_at,
            $tramite->creadoPor?->name,
            $tramite->creadoPor?->oficina->nombre,
            $tramite->observaciones
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Escrituración Social (Sistema de Gestión Catastral)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de escrituración social (Sistema de Gestión Catastral)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);
                $event->sheet->getRowDimension('1')->setRowHeight(90);
                $event->sheet->getStyle('A2:J2')->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]
                );
            },
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'J' => 50,
        ];
    }

}
