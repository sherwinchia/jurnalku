<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PromoCode;

function current_user()
{
    return Auth::user();
}

function current_admin()
{
    return Auth::guard('admin')->user();
}

function date_to_human($date, $format = 'd/m/Y, h:i A')
{
    if ($date == null) {
        return null;
    }
    $dt = Carbon::parse($date);
    return $dt->format($format);
}

function human_to_date($date, $format = 'd/m/Y, h:i A')
{
    if ($date == null) {
        return null;
    }
    return Carbon::createFromFormat($format, $date);
}

function convert_string_decimal($string)
{
    #T = Trillion = Triliun = 1.000.000.000.000
    #B = Billion = Miliar = 1.000.000.000
    #M = Million = Juta = 1.000.000
    $decimal = 0;
    $string = strtoupper($string);

    if (strpos($string, "B") != false) {
        $string = remove_uneccessary_character($string, "B");
        $decimal = (float) $string * 1000000000;
    }

    if (strpos($string, "M") != false) {
        $string = remove_uneccessary_character($string, "M");
        $decimal = (float) $string * 1000000;
    }

    if (strpos($string, "X") != false) {
        $string = remove_uneccessary_character($string, "X");
        $decimal = (float) $string;
    }
    if (strpos($string, "%") != false) {
        $string = remove_uneccessary_character($string, "%");
        $decimal = (float) $string;
    }

    if (is_numeric($string)) {
        $decimal = (float) $string;
    }

    return $decimal;
}

function decimal_to_human($raw, string $currency = null, bool $percentage = false)
{
    $new_format = (float) $raw;

    if (isset($currency)) {
        if (strtolower($currency) === 'rp') {
            $new_format = number_format($new_format, 0, ',', '.');
        } else {
            $new_format = number_format($new_format, 0, ',', ',');
        }
        $new_format = $currency . $new_format;
    } elseif ($percentage) {
        $new_format = number_format($new_format, 0, '.', '.') . '%';
    } else {
        $new_format = number_format($new_format, 0, '.', '.');
    }

    return $new_format;
}

function date_interval(string $exit_date, string $entry_date)
{
    $exit = Carbon::parse($exit_date);
    $entry = Carbon::parse($entry_date);
    return  $exit->diffInHours($entry) . 'h';
}

function remove_uneccessary_character($string, $characters)
{
    $new_string = str_replace($characters, "", $string);
    $new_string = str_replace(",", "", $string);
    return $new_string;
}

function get_unique_promocode($length = 6)
{
    $code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length));
    if (Promocode::where('code', $code)->exists()) {
        get_unique_promocode();
    }

    return $code;
}

function pluralize($quantity, $singular, $plural = null)
{
    if ($quantity == 1 || !strlen($singular)) return $singular;
    if ($plural !== null) return $plural;

    $last_letter = strtolower($singular[strlen($singular) - 1]);
    switch ($last_letter) {
        case 'y':
            return substr($singular, 0, -1) . 'ies';
        case 's':
            return $singular . 'es';
        default:
            return $singular . 's';
    }
}

function get_boolean_value($value)
{
    if ($value == true) {
        return "True";
    }

    if ($value == false) {
        return "False";
    }
}

function date_to_datetime_local($value)
{
    return Carbon::parse($value)->format('Y-m-d\TH:i');
}
