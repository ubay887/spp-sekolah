<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
// use App\Penjualan;

class PembayaranExport implements FromView, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($laporan, $sekolahInfo, $total, $start_date, $end_date, $mode)
    {
        $this->laporan = $laporan;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->mode = $mode;
        $this->sekolahInfo = $sekolahInfo;
        $this->total = $total;
    }

    public function registerEvents(): array
    {
        //MEMANIPULASI CELL
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                //CELL TERKAIT AKAN DI-MERGE
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A5:G5');
                $event->sheet->mergeCells('A6:B6');
                $event->sheet->mergeCells('A7:B7');

 
                //DEFINISIKAN STYLE UNTUK CELL
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    // 'fill' => [
                    //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    //     'rotation' => 90,
                    //     'startColor' => [
                    //         'argb' => 'FFA0A0A0',
                    //     ],
                    //     'endColor' => [
                    //         'argb' => 'FFFFFFFF',
                    //     ],
                    // ],
                ];
                //CELL TERAKAIT AKAN MENGGUNAKAN STYLE DARI $styleArray
                // $event->sheet->getStyle('A6:F6')->applyFromArray($styleArray);

 
                //FORMATTING STYLE UNTUK CELL TERKAIT
                $headCustomer = [
                    // 'font' => [
                    //     'bold' => true,
                    // ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A1:G3')->applyFromArray($headCustomer);
            },
        ];
    }

    public function view(): View
    {
        return view('admin.laporan.exportPembayaranExcel', [
            'laporan' => $this->laporan,
            'start_date' => date_format(date_create($this->start_date), "d/m/Y"),
            'end_date' => date_format(date_create($this->end_date), "d/m/Y"),
            'mode' => $this->mode,
            'sekolahInfo' => $this->sekolahInfo,
            'total' => $this->total,
        ]);
    }
}