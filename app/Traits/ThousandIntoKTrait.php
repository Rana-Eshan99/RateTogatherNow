<?php

namespace App\Traits;

trait ThousandIntoKTrait {
    public function thousandsCurrencyFormat($num) {
        // Define suffixes for different magnitudes
        $x_parts = array('', 'k', 'm', 'b', 't');

        // Get the magnitude (number of thousands, millions, etc.)
        $magnitude = floor((strlen((string) $num) - 1) / 3);

        // Ensure the magnitude does not exceed the defined suffixes
        if ($magnitude > 0) {
            // Divide the number by 1000^magnitude and round to one decimal place
            $num = $num / pow(1000, $magnitude);
            $num = round($num, 1);

            // Format the number with one decimal point
            $num = number_format($num, 1);

            // Append the corresponding suffix (k, m, b, t)
            return $num . $x_parts[$magnitude];
        }

        // If the number is less than 1000, just format it with one decimal point
        return number_format($num, 1);
    }
}

