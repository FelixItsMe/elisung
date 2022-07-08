<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\Telemetri;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month') ?? now('Asia/Jakarta')->format('Y-m');

        $localZone = "Asia/Jakarta";
        $startOfMonth = now($localZone)->parse($month)->startOfMonth();
        $endOfMonth = now($localZone)->parse($month)->endOfMonth();

        $data = Telemetri::query()
            ->select('id', 't_akhir', 'beras', 'bensin_pakai')
            ->whereBetween('t_akhir', [$startOfMonth, $endOfMonth])
            ->get();

        $chartData = [];

        foreach (getMonthDates($month) as $date) {
            $collection = collect($data);

            $filtered = $collection->filter(function ($value, $key) use($date){
                return now()->parse($value->t_akhir)->format('d') == $date;
            });

            $totalBeras = 0;
            $totalBensin = 0;
            foreach ($filtered->all() as $value) {
                $totalBeras += $value->beras;
                $totalBensin += $value->bensin_pakai;
            }

            $chartData[] = (object) [
                'bensin' => $totalBensin,
                'beras' => $totalBeras,
                'date' => $date
            ];
        }

        return response()->json([
            'data' => $chartData
        ], 200);
    }
}
