<?php

namespace App\Exports;

use App\Models\Certificacion;
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


class CertificacionesExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public function __construct(
        public $estado,
        public $oficina,
        public $año,
        public $documento,
        public $fecha1,
        public $fecha2
    ){}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Certificacion::with('oficina:id,nombre', 'creadoPor:id,name', 'tramite:id,año,folio,usuario')
                                ->when (isset($this->año) && $this->año != "", function($q){
                                    $q->where('año', $this->año);
                                })
                                ->when (isset($this->documento) && $this->documento != "", function($q){
                                    $q->where('documento', $this->documento);
                                })
                                ->when (isset($this->estado) && $this->estado != "", function($q){
                                    $q->where('estado', $this->estado);
                                })
                                ->when(isset($this->oficina) && $this->oficina != "", function($q){
                                    return $q->where('oficina_id', $this->oficina);
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
            'Tipo',
            'Año',
            'Folio',
            'Estado',
            'Oficina',
            'Trámite',
            'Registrado en',
            'Registrado por',
        ];
    }

    public function map($certificacion): array
    {
        return [
            $certificacion->tipo->label(),
            $certificacion->año,
            $certificacion->folio,
            $certificacion->estado,
            $certificacion->oficina->nombre,
            $certificacion->tramite?->año . '-' . $certificacion->tramite?->folio . '-' . $certificacion->tramite?->usuario,
            $certificacion->created_at,
            $certificacion->creadoPor?->name,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Certificaciones (Sistema de Gestión Catastral)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de certificaciones (Sistema de Gestión Catastral)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:H1')->applyFromArray([
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
                $event->sheet->getStyle('A2:H2')->applyFromArray([
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
            'E' => 50,
            'P' => 50,
        ];
    }

}
