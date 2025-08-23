<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HolidayService
{
    private $apiUrl;
    private $cacheKey = 'holiday_dates';
    private $cacheDuration = 86400; // 24 jam

    public function __construct()
    {
        $this->apiUrl = env('LIBUR_API_URL', 'https://libur.deno.dev/api');
    }

    public function getHolidayDates($year = null)
    {
        if (!$year) {
            $year = Carbon::now()->year;
        }

        $cacheKey = $this->cacheKey . '_' . $year;
        
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($year) {
            return $this->fetchHolidayDates($year);
        });
    }

    public function isHoliday($date)
    {
        $dateStr = Carbon::parse($date)->format('Y-m-d');
        $year = Carbon::parse($date)->year;
        
        $holidayDates = $this->getHolidayDates($year);
        
        return in_array($dateStr, $holidayDates);
    }

    public function isWeekendOrHoliday($date)
    {
        $carbonDate = Carbon::parse($date);
        return $carbonDate->isWeekend() || $this->isHoliday($date);
    }

    private function fetchHolidayDates($year)
    {
        try {
            $response = @file_get_contents($this->apiUrl);
            
            if ($response === false) {
                Log::warning('Gagal mengambil data tanggal merah dari API');
                return [];
            }

            $holidays = json_decode($response, true);
            
            if (!is_array($holidays)) {
                Log::warning('Format data tanggal merah tidak valid');
                return [];
            }

            $holidayDates = [];
            foreach ($holidays as $holiday) {
                if (isset($holiday['date'])) {
                    $holidayYear = Carbon::parse($holiday['date'])->year;
                    if ($holidayYear == $year) {
                        $holidayDates[] = $holiday['date'];
                    }
                }
            }

            return $holidayDates;

        } catch (\Exception $e) {
            Log::error('Error fetching holiday dates: ' . $e->getMessage());
            return [];
        }
    }

    public function clearCache()
    {
        $currentYear = Carbon::now()->year;
        $cacheKey = $this->cacheKey . '_' . $currentYear;
        Cache::forget($cacheKey);
    }
}
