<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\HolidayService;

class ClearHolidayCache extends Command
{
    protected $signature = 'holiday:clear-cache';
    protected $description = 'Membersihkan cache tanggal merah';

    public function handle()
    {
        $holidayService = new HolidayService();
        $holidayService->clearCache();
        
        $this->info('Cache tanggal merah berhasil dibersihkan!');
        
        return 0;
    }
}
