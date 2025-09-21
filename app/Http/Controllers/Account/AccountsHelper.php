<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account;

class AccountsHelper
{
    /**
     * Convert number to words
     *
     * @param int $number
     * @return string
     */
    public static function numberToWords($number)
    {
        $ones = array(
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
        );
        
        $tens = array(
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        
        if ($number < 20) {
            return $ones[$number];
        } elseif ($number < 100) {
            $tens_digit = floor($number / 10) * 10;
            $ones_digit = $number % 10;
            return $tens[$tens_digit] . ($ones_digit > 0 ? ' ' . $ones[$ones_digit] : '');
        } elseif ($number < 1000) {
            $hundreds = floor($number / 100);
            $remainder = $number % 100;
            $result = $ones[$hundreds] . ' Hundred';
            if ($remainder > 0) {
                $result .= ' ' . self::numberToWords($remainder);
            }
            return $result;
        } elseif ($number < 100000) {
            $thousands = floor($number / 1000);
            $remainder = $number % 1000;
            $result = self::numberToWords($thousands) . ' Thousand';
            if ($remainder > 0) {
                $result .= ' ' . self::numberToWords($remainder);
            }
            return $result;
        } elseif ($number < 10000000) {
            $lakhs = floor($number / 100000);
            $remainder = $number % 100000;
            $result = self::numberToWords($lakhs) . ' Lakh';
            if ($remainder > 0) {
                $result .= ' ' . self::numberToWords($remainder);
            }
            return $result;
        } else {
            $crores = floor($number / 10000000);
            $remainder = $number % 10000000;
            $result = self::numberToWords($crores) . ' Crore';
            if ($remainder > 0) {
                $result .= ' ' . self::numberToWords($remainder);
            }
            return $result;
        }
    }
}
