<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\HolidayService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayServiceTest extends TestCase
{
    public function test_is_holiday_returns_true_for_holiday_date()
    {
        // Test ini memerlukan API real, jadi kita skip untuk development
        $this->markTestSkipped('Test ini memerlukan API tanggal merah yang aktif');
    }

    public function test_is_weekend_or_holiday_returns_true_for_weekend()
    {
        $holidayService = new HolidayService();
        
        // Test dengan hari Sabtu
        $saturday = Carbon::parse('2024-01-06'); // Sabtu
        $this->assertTrue($holidayService->isWeekendOrHoliday($saturday));
        
        // Test dengan hari Minggu
        $sunday = Carbon::parse('2024-01-07'); // Minggu
        $this->assertTrue($holidayService->isWeekendOrHoliday($sunday));
    }

    public function test_is_weekend_or_holiday_returns_false_for_weekday()
    {
        $holidayService = new HolidayService();
        
        // Test dengan hari Senin
        $monday = Carbon::parse('2024-01-08'); // Senin
        $this->assertFalse($holidayService->isWeekendOrHoliday($monday));
    }
}
