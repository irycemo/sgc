<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public function __construct(
        public $estado,
        public $oficina,
        public $rol,
        public $permiso,
        public $fecha1,
        public $fecha2,
    ){}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('oficina:id,nombre')
                        ->when (isset($this->estado) && $this->estado != "", function($q){
                            $q->where('estado', $this->estado);
                        })
                        ->when(isset($this->oficina) && $this->oficina != "", function($q){
                            return $q->where('oficina_id', $this->oficina);
                        })
                        ->when(isset($this->rol) && $this->rol != "", function($q){
                            $q->whereHas('roles', function($q){
                                $q->where('name', $this->rol);
                            });
                        })
                        ->when(isset($this->permiso) && $this->permiso != "", function($q){
                            $q->whereHas('permissions', function($q){
                                $q->where('name', $this->permiso);
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
            'Clave',
            'Nombre',
            'Correo',
            'Estado',
            'Rol',
            'Área',
            'Oficina',
            'Valuador',
            'Registrado en',
        ];
    }

    public function map($usuario): array
    {
        return [
            $usuario->clave,
            $usuario->name,
            $usuario->email,
            $usuario->estado,
            $usuario->getRoleNames()->first(),
            $usuario->area,
            $usuario->oficina->nombre,
            $usuario->valuador ? 'Si' : 'No',
            $usuario->created_at,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Usuarios (Sistema de Gestión Catastral)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de usuarios (Sistema de Gestión Catastral)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:I1')->applyFromArray([
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
                $event->sheet->getStyle('A2:I2')->applyFromArray([
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
