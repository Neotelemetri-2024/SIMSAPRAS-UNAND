<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Log;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
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
            'ID',
            'Peminjam',
            'Instansi',
            'Status Unand',
            'Kegiatan',
            'Ruangan/Sarana',
            'Tanggal Peminjaman',
            'Waktu',
            'Total Tarif',
            'Tanggal Pengajuan',
            'Evaluasi'
        ];
    }

    public function map($peminjaman): array
    {
        try {
            Log::info('Mapping peminjaman:', $peminjaman->toArray());

            // Format tanggal peminjaman
            $tanggalPeminjaman = $peminjaman->tanggalPeminjaman->map(function($tp) {
                try {
                    return \Carbon\Carbon::parse($tp->tanggal)->format('d/m/Y') . 
                           ' (' . ($tp->jadwal ? $tp->jadwal->mulai . '-' . $tp->jadwal->selesai : 'Jadwal tidak tersedia') . ')';
                } catch (\Exception $e) {
                    Log::error('Error formatting tanggal:', ['error' => $e->getMessage()]);
                    return 'Format tanggal error';
                }
            })->join(', ');

            $row = [
                $peminjaman->id,
                optional($peminjaman->user)->name ?? 'N/A',
                $peminjaman->instansi ?? 'N/A',
                $peminjaman->isUnand ? 'Ya' : 'Tidak',
                $peminjaman->kegiatan ?? 'N/A',
                optional($peminjaman->sarana)->nama ?? optional($peminjaman->ruangan)->nama ?? 'N/A',
                $tanggalPeminjaman,
                optional($peminjaman->created_at)->format('d/m/Y H:i:s') ?? 'N/A',
                'Rp ' . number_format($peminjaman->totalTarif ?? 0, 0, ',', '.'),
                optional($peminjaman->created_at)->format('d/m/Y') ?? 'N/A',
                $peminjaman->evaluasi ?? 'N/A'
            ];

            Log::info('Mapped row:', $row);
            return $row;

        } catch (\Exception $e) {
            Log::error('Error in map function:', [
                'error' => $e->getMessage(),
                'peminjaman_id' => $peminjaman->id ?? 'unknown'
            ]);
            return array_fill(0, 12, 'Error processing data');
        }
    }
}