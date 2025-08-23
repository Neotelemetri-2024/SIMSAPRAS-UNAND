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
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Facades\Log;

class PeminjamanExportAdvanced implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            'Data Peminjaman' => new PeminjamanDataSheet($this->startDate, $this->endDate, $this->filterType),
            'Ringkasan' => new PeminjamanSummarySheet($this->startDate, $this->endDate, $this->filterType),
            'Statistik' => new PeminjamanStatsSheet($this->startDate, $this->endDate, $this->filterType),
        ];
    }
}

class PeminjamanDataSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $filterType;

    public function __construct($startDate, $endDate, $filterType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterType = $filterType;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'ruangan', 'sarana.kategoriSarana', 'tanggalPeminjaman.jadwal'])
            ->where('status', 'selesai');

        if ($this->filterType === 'created') {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        } else {
            $query->whereHas('tanggalPeminjaman', function($q) {
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
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
        // Format tanggal peminjaman
        $tanggalPeminjaman = $peminjaman->tanggalPeminjaman->map(function($tp) {
            return \Carbon\Carbon::parse($tp->tanggal)->format('d/m/Y');
        })->join(', ');

        // Format jadwal
        $jadwal = $peminjaman->tanggalPeminjaman->map(function($tp) {
            return $tp->jadwal ? $tp->jadwal->mulai . ' - ' . $tp->jadwal->selesai : 'Jadwal tidak tersedia';
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

        return [
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
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   'B' => 12,  'C' => 25,  'D' => 30,  'E' => 20,
            'F' => 15,  'G' => 35,  'H' => 15,  'I' => 25,  'J' => 20,
            'K' => 20,  'L' => 20,  'M' => 15,  'N' => 15,  'O' => 18,
            'P' => 18,  'Q' => 18,  'R' => 40,  'S' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
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
        return 'Data Peminjaman';
    }
}

class PeminjamanSummarySheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $filterType;

    public function __construct($startDate, $endDate, $filterType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterType = $filterType;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'ruangan', 'sarana.kategoriSarana'])
            ->where('status', 'selesai');

        if ($this->filterType === 'created') {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        } else {
            $query->whereHas('tanggalPeminjaman', function($q) {
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            });
        }

        $data = $query->get();

        // Hitung statistik
        $totalPeminjaman = $data->count();
        $totalTarif = $data->sum('totalTarif');
        $peminjamanLunas = $data->where('statusPembayaran', 'lunas')->count();
        $peminjamanBelumLunas = $data->where('statusPembayaran', 'tidak')->count();

        // Statistik berdasarkan status peminjam
        $unitCount = $data->where('statusPeminjam', 'unit')->count();
        $ormawaCount = $data->where('statusPeminjam', 'ormawa')->count();
        $umumCount = $data->where('statusPeminjam', 'umum')->count();

        // Statistik berdasarkan kategori sarana
        $kategoriStats = $data->groupBy('sarana.kategoriSarana.jenis')
            ->map(function($group) {
                return [
                    'count' => $group->count(),
                    'total_tarif' => $group->sum('totalTarif')
                ];
            });

        return collect([
            [
                'Kategori' => 'Total Peminjaman',
                'Jumlah' => $totalPeminjaman,
                'Total Tarif' => 'Rp ' . number_format($totalTarif, 0, ',', '.'),
                'Keterangan' => 'Seluruh peminjaman selesai'
            ],
            [
                'Kategori' => 'Peminjaman Lunas',
                'Jumlah' => $peminjamanLunas,
                'Total Tarif' => 'Rp ' . number_format($data->where('statusPembayaran', 'lunas')->sum('totalTarif'), 0, ',', '.'),
                'Keterangan' => 'Peminjaman yang sudah dibayar'
            ],
            [
                'Kategori' => 'Peminjaman Belum Lunas',
                'Jumlah' => $peminjamanBelumLunas,
                'Total Tarif' => 'Rp ' . number_format($data->where('statusPembayaran', 'tidak')->sum('totalTarif'), 0, ',', '.'),
                'Keterangan' => 'Peminjaman yang belum dibayar'
            ],
            [
                'Kategori' => 'Unit/Fakultas',
                'Jumlah' => $unitCount,
                'Total Tarif' => 'Rp ' . number_format($data->where('statusPeminjam', 'unit')->sum('totalTarif'), 0, ',', '.'),
                'Keterangan' => 'Peminjaman dari unit/fakultas'
            ],
            [
                'Kategori' => 'Ormawa',
                'Jumlah' => $ormawaCount,
                'Total Tarif' => 'Rp ' . number_format($data->where('statusPeminjam', 'ormawa')->sum('totalTarif'), 0, ',', '.'),
                'Keterangan' => 'Peminjaman dari ormawa'
            ],
            [
                'Kategori' => 'Umum',
                'Jumlah' => $umumCount,
                'Total Tarif' => 'Rp ' . number_format($data->where('statusPeminjam', 'umum')->sum('totalTarif'), 0, ',', '.'),
                'Keterangan' => 'Peminjaman dari umum'
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Jumlah',
            'Total Tarif',
            'Keterangan'
        ];
    }

    public function map($row): array
    {
        return [
            $row['Kategori'],
            $row['Jumlah'],
            $row['Total Tarif'],
            $row['Keterangan']
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 15,
            'C' => 20,
            'D' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
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

        // Data rows styling
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:D' . $highestRow)->applyFromArray([
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

        // Center align numbers
        $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C:C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return $sheet;
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}

class PeminjamanStatsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $filterType;

    public function __construct($startDate, $endDate, $filterType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterType = $filterType;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'ruangan', 'sarana.kategoriSarana'])
            ->where('status', 'selesai');

        if ($this->filterType === 'created') {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        } else {
            $query->whereHas('tanggalPeminjaman', function($q) {
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            });
        }

        $data = $query->get();

        // Statistik berdasarkan kategori sarana
        if ($data->count() === 0) {
            return collect([
                [
                    'Kategori Sarana' => 'Tidak ada data',
                    'Jumlah Peminjaman' => 0,
                    'Total Tarif' => 'Rp 0',
                    'Rata-rata Tarif' => 'Rp 0',
                    'Persentase' => '0%'
                ]
            ]);
        }

        $kategoriStats = $data->groupBy('sarana.kategoriSarana.jenis')
            ->map(function($group, $kategori) use ($data) {
                return [
                    'Kategori Sarana' => $kategori ?? 'Tidak ada kategori',
                    'Jumlah Peminjaman' => $group->count(),
                    'Total Tarif' => 'Rp ' . number_format($group->sum('totalTarif'), 0, ',', '.'),
                    'Rata-rata Tarif' => 'Rp ' . number_format($group->avg('totalTarif'), 0, ',', '.'),
                    'Persentase' => round(($group->count() / $data->count()) * 100, 2) . '%'
                ];
            })
            ->values();

        return $kategoriStats;
    }

    public function headings(): array
    {
        return [
            'Kategori Sarana',
            'Jumlah Peminjaman',
            'Total Tarif',
            'Rata-rata Tarif',
            'Persentase'
        ];
    }

    public function map($row): array
    {
        return [
            $row['Kategori Sarana'],
            $row['Jumlah Peminjaman'],
            $row['Total Tarif'],
            $row['Rata-rata Tarif'],
            $row['Persentase']
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
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

        // Data rows styling
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:E' . $highestRow)->applyFromArray([
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

        // Center align numbers
        $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return $sheet;
    }

    public function title(): string
    {
        return 'Statistik';
    }
}
