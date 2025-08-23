<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\Log;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $filterType;

    public function __construct($startDate, $endDate, $filterType = 'created')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterType = $filterType;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'ruangan', 'sarana', 'tanggalPeminjaman.jadwal'])
            ->where('status', 'selesai');

        if ($this->filterType === 'created') {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        } else {
            $query->whereHas('tanggalPeminjaman', function($q) {
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            });
        }

        $results = $query->get();
        Log::info('Query results:', ['count' => $results->count()]);
        return $results;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Peminjaman',
            'Nama Peminjam',
            'Email',
            'Instansi',
            'Status Peminjam',
            'Kegiatan',
            'Estimasi Peserta',
            'Sarana/Ruangan',
            'Kategori Sarana',
            'Tanggal Peminjaman',
            'Jadwal',
            'Total Tarif',
            'Status Pembayaran',
            'Tanggal Pengajuan',
            'Tanggal Disetujui',
            'Tanggal Selesai',
            'Evaluasi',
            'Catatan'
        ];
    }

    public function map($peminjaman): array
    {
        try {
            // Format tanggal peminjaman
            $tanggalPeminjaman = $peminjaman->tanggalPeminjaman->map(function($tp) {
                try {
                    return \Carbon\Carbon::parse($tp->tanggal)->format('d/m/Y');
                } catch (\Exception $e) {
                    Log::error('Error formatting tanggal:', ['error' => $e->getMessage()]);
                    return 'Format tanggal error';
                }
            })->join(', ');

            // Format jadwal
            $jadwal = $peminjaman->tanggalPeminjaman->map(function($tp) {
                try {
                    return $tp->jadwal ? $tp->jadwal->mulai . ' - ' . $tp->jadwal->selesai : 'Jadwal tidak tersedia';
                } catch (\Exception $e) {
                    return 'Jadwal error';
                }
            })->join(', ');

            // Tentukan sarana/ruangan
            $saranaRuangan = '';
            if ($peminjaman->ruangan) {
                $saranaRuangan = $peminjaman->ruangan->nama;
            } elseif ($peminjaman->sarana) {
                $saranaRuangan = $peminjaman->sarana->nama;
            }

            // Kategori sarana
            $kategoriSarana = '';
            if ($peminjaman->sarana && $peminjaman->sarana->kategoriSarana) {
                $kategoriSarana = $peminjaman->sarana->kategoriSarana->jenis;
            }

            // Status peminjam
            $statusPeminjam = match($peminjaman->statusPeminjam) {
                'unit' => 'Unit/Fakultas',
                'ormawa' => 'Ormawa',
                'umum' => 'Umum',
                default => 'Tidak diketahui'
            };

            $row = [
                '', // No akan diisi otomatis
                $peminjaman->id,
                optional($peminjaman->user)->name ?? 'N/A',
                optional($peminjaman->user)->email ?? 'N/A',
                $peminjaman->instansi ?? 'N/A',
                $statusPeminjam,
                $peminjaman->kegiatan ?? 'N/A',
                $peminjaman->estimasiPeserta ?? 'N/A',
                $saranaRuangan,
                $kategoriSarana,
                $tanggalPeminjaman,
                $jadwal,
                'Rp ' . number_format($peminjaman->totalTarif ?? 0, 0, ',', '.'),
                $peminjaman->statusPembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas',
                optional($peminjaman->created_at)->format('d/m/Y H:i') ?? 'N/A',
                optional($peminjaman->disetujui_at)->format('d/m/Y H:i') ?? 'N/A',
                optional($peminjaman->updated_at)->format('d/m/Y H:i') ?? 'N/A',
                $peminjaman->evaluasi ?? 'N/A',
                $peminjaman->feedbackPenolakan ?? 'N/A'
            ];

            return $row;

        } catch (\Exception $e) {
            Log::error('Error in map function:', [
                'error' => $e->getMessage(),
                'peminjaman_id' => $peminjaman->id ?? 'unknown'
            ]);
            return array_fill(0, 19, 'Error processing data');
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 12,  // ID Peminjaman
            'C' => 25,  // Nama Peminjam
            'D' => 30,  // Email
            'E' => 20,  // Instansi
            'F' => 15,  // Status Peminjam
            'G' => 35,  // Kegiatan
            'H' => 15,  // Estimasi Peserta
            'I' => 25,  // Sarana/Ruangan
            'J' => 20,  // Kategori Sarana
            'K' => 20,  // Tanggal Peminjaman
            'L' => 20,  // Jadwal
            'M' => 15,  // Total Tarif
            'N' => 15,  // Status Pembayaran
            'O' => 18,  // Tanggal Pengajuan
            'P' => 18,  // Tanggal Disetujui
            'Q' => 18,  // Tanggal Selesai
            'R' => 40,  // Evaluasi
            'S' => 40,  // Catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'], // Green color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Auto number
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->setCellValue('A' . $row, $row - 1);
        }

        // Data rows styling
        $sheet->getStyle('A2:S' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Alternating row colors
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':S' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F8F9FA'],
                    ],
                ]);
            }
        }

        // Center align specific columns
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M:M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('N:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Wrap text for long content
        $sheet->getStyle('G:G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('R:S')->getAlignment()->setWrapText(true);

        // Freeze first row
        $sheet->freezePane('A2');

        return $sheet;
    }

    public function title(): string
    {
        return 'Peminjaman Selesai';
    }
}