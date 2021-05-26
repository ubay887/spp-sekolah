<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
// use App\Penjualan;

class SiswaExport implements FromView, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($data, $sekolahInfo)
    {
        $this->data = $data;
        $this->sekolahInfo = $sekolahInfo;
        // $this->bulan = $bulan;
        // $this->jenisPembayaranTipe = $jenisPembayaranTipe;
        // $this->namaKelas = $namaKelas;
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
                $event->sheet->mergeCells('A4:G4');
                $event->sheet->mergeCells('A6:G6');
                // $event->sheet->mergeCells('A3:B3');
                // $event->sheet->mergeCells('A4:B4');
                // $event->sheet->mergeCells('A5:B5');

 
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
                $header = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $header2= [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A1:G1')->applyFromArray($header);
                $event->sheet->getStyle('A2:G4')->applyFromArray($header2);
            },
        ];
    }

    public function view(): View
    {
        //MENGAMBIL DATA TRANSAKSI BERDASARKAN INVOICE YANG DITERIMA DARI CONTROLLER
        // $penjualan = Penjualan::where('invoice', $this->invoice)
        //     ->with('pelanggan', 'penjualan_detail', 'penjualan_detail.buku')->first();
        //DATA TERSEBUT DIPASSING KE FILE INVOICE_EXCEL
        return view('admin.siswa.cetak.excel', [
            'data' => $this->data,
            'sekolahInfo' => $this->sekolahInfo,
        ]);
    }
}