<?php

namespace App\Exports\Reportes;

use App\Models\User;
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

class UsuariosExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public function __construct(
        public $estado,
        public $area,
        public $oficina,
        public $valuador,
        public $fecha1,
        public $fecha2
    ){}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('oficina:id,nombre', 'creadoPor')
                            ->when (isset($this->estado) && $this->estado != "", function($q){
                                $q->where('status', $this->estado);
                            })
                            ->when (isset($this->area) && $this->area != "", function($q){
                                $q->where('area', $this->area);
                            })
                            ->when(isset($this->oficina) && $this->oficina != "", function($q){
                                return $q->where('oficina_id', $this->oficina);
                            })
                            ->when(isset($this->valuador) && $this->valuador != "", function($q){
                                return $q->where('valuador', $this->valuador);
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
            'Clave',
            'Estado',
            'Nombre',
            'Apellido paterno',
            'Apellido materno',
            'Correo',
            'Área',
            'Oficina',
            'Valuador',
            'Registrado en',
            'Registrado por',
        ];
    }

    public function map($usuario): array
    {
        return [
            $usuario->clave,
            $usuario->status,
            $usuario->name,
            $usuario->ap_paterno,
            $usuario->ap_materno,
            $usuario->email,
            $usuario->area,
            $usuario->oficina?->nombre,
            $usuario->valuador ? 'SI' : 'NO',
            $usuario->created_at,
            $usuario->creadoPor?->nombreCompleto(),
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->nombreCompleto(),
            'title'          => 'Reporte de Usuarios (Sistema de Gestión Catastral)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:K1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de usuarios (Sistema de Gestión Catastral)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:K1')->applyFromArray([
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
                $event->sheet->getStyle('A2:K2')->applyFromArray([
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
        ];
    }

}
