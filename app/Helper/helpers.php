<?php
use Illuminate\Support\Str;

if (! function_exists('imageIntervention')) {
    function imageIntervention($image, string $path): ?string
    {
        $clientExtension = ($image->getClientOriginalExtension() == null && $image->getClientOriginalExtension() == '') ? 'png' : $image->getClientOriginalExtension();
        $name = strtoupper(Str::random(5)) . '-' . time() . '.' . $clientExtension;

        if (!file_exists($path)) {
            mkdir($path, 755, true);
        }
        // $final_path = public_path($path . $name);
        $image->move($path, $name);

        return $path . $name;
    }
}

if (! function_exists('getMonthDates')) {
    function getMonthDates(string $month): ?array
    {
        $endOfMonthDate = now()->parse($month)->endOfMonth()->format('d');

        $dates = [];

        for ($i=1; $i <= $endOfMonthDate; $i++) {
            $dates[] = $i;
        }

        return $dates;
    }
}
