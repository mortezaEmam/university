<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class PersianDateController extends Controller
{

    /**
     * دریافت تاریخ شمسی فعلی
     */

    public function currentDate($format = 'Y-m-d')
    {
        return $this->formatDate(now(), $format);
    }

    /**
     * تبدیل تاریخ میلادی به شمسی
     */
    public function gregorianToJalali($date, $format = 'Y-m-d')
    {
        return $this->formatDate($date, $format);
    }
    public function getPersianDate()
    {
        $date = Jalalian::now();

        return response()->json([
            'date' => $date->format('l j ، F Y'), // چهارشنبه 20 فروردین 1404
            'today' => 'امروز',
            'timestamp' => now()->timestamp
        ]);
    }

    /**
     * تابع اصلی فرمت دهی
     */
    private function formatDate($date, $format)
    {
        try {
            return Jalalian::fromDateTime($date)->format($format);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فرمت تاریخ نامعتبر است',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * دریافت اطلاعات کامل تاریخ
     */
    public function fullDateInfo()
    {
        $now = now();
        return response()->json([
            'jalali' => Jalalian::fromDateTime($now)->format('%A, %d %B %Y'),
            'gregorian' => $now->format('Y-m-d'),
            'timestamp' => $now->timestamp,
            'day_name' => Jalalian::fromDateTime($now)->format('%A'),
            'month_name' => Jalalian::fromDateTime($now)->format('%B'),
            'year' => Jalalian::fromDateTime($now)->format('%Y'),
            'today' => 'امروز'
        ]);
    }
}
