<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
// use App\Penjualan;

class TagihanExport implements FromView, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($data, $sekolahInfo, $bulan, $jenisPembayaranTipe, $namaKelas)
    {
        $this->data = $data;
        $this->bulan = $bulan;
        $this->jenisPembayaranTipe = $jenisPembayaranTipe;
        $this->namaKelas = $namaKelas;
        $this->sekolahInfo = $sekolahInfo;
    }

    public function registerEvents(): array
    {
        //MEMANIPULASI CELL
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                //CELL TERKAIT AKAN DI-MERGE
                if($this->jenisPembayaranTipe === 'bulanan'){
                    $event->sheet->mergeCells('A1:P1');
                    $event->sheet->mergeCells('A2:P2');
                    $event->sheet->mergeCells('A3:P3');
                }else{
                    $event->sheet->mergeCells('A1:G1');
                    $event->sheet->mergeCells('A2:G2');
                    $event->sheet->mergeCells('A3:G3');
                }
                // $event->sheet->mergeCells('A3:B3');
                // $event->sheet->mergeCells('A4:B4');
                $event->sheet->mergeCells('A5:B5');
                $event->sheet->mergeCells('A6:B6');
                $event->sheet->mergeCells('A7:B7');
                $event->sheet->mergeCells('A8:B8');
                $event->sheet->mergeCells('A9:B9');

 
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
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A1:P3')->applyFromArray($headCustomer);
            },
        ];
    }

    public function view(): View
    {
        //MENGAMBIL DATA TRANSAKSI BERDASARKAN INVOICE YANG DITERIMA DARI CONTROLLER
        // $penjualan = Penjualan::where('invoice', $this->invoice)
        //     ->with('pelanggan', 'penjualan_detail', 'penjualan_detail.buku')->first();
        //DATA TERSEBUT DIPASSING KE FILE INVOICE_EXCEL
        return view('admin.laporan.exportTagihanExcel', [
            'data' => $this->data,
            'bulan' => $this->bulan,
            'jenisPembayaranTipe' => $this->jenisPembayaranTipe,
            'namaKelas' => $this->namaKelas,
            'sekolahInfo' => $this->sekolahInfo,
        ]);
    }
}