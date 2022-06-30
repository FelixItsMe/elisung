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
