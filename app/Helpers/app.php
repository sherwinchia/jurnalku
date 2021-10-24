<?php
  use Illuminate\Support\Facades\Auth;
  use Carbon\Carbon;
  use App\Models\PromoCode;

function current_user(){
    return Auth::user();
  }

  function current_admin(){
    return Auth::guard('admin')->user();
  }

  function date_to_human($date, $format = 'd/m/Y, h:i A'){
		if ($date == null) {
			return null;
		}
		$dt = Carbon::parse($date);
		return $dt->format($format);
  }
  
  function human_to_date($date, $format = 'd/m/Y, h:i A'){
		if ($date == null) {
			return null;
		}
		return Carbon::createFromFormat($format, $date);
  }

  function convert_string_decimal($string){
        #T = Trillion = Triliun = 1.000.000.000.000
        #B = Billion = Miliar = 1.000.000.000
        #M = Million = Juta = 1.000.000
        $decimal = 0;
        $string = strtoupper($string);

        if (strpos($string,"B") != false) {
            $string = remove_uneccessary_character($string, "B");
            $decimal = (float) $string * 1000000000;
        }

        if (strpos($string,"M") != false) {
            $string = remove_uneccessary_character($string, "M");
            $decimal = (float) $string * 1000000;
        }

        if (strpos($string,"X") != false) {
            $string = remove_uneccessary_character($string, "X");
            $decimal = (float) $string;

        }
        if (strpos($string,"%") != false) {
            $string = remove_uneccessary_character($string, "%");
            $decimal = (float) $string;
        }

        if (is_numeric($string)) {
            $decimal = (float) $string; 
        }

        return $decimal;
  }

  function decimal_to_human($decimal, $currency = false ){
    $new_format ="";
    $integer = (int) $decimal;

    if ($integer >= 0) {
        if ($integer < 1000000) {
            // Anything less than a million
            $new_format = number_format($integer);
        } else if ($integer < 1000000000) {
            // Anything less than a billion
            $new_format = number_format($integer / 1000000, 2) . ' M';
        } else if ($integer < 1000000000000) {
            // At least a billion
            $new_format = number_format($integer / 1000000000, 2) . ' B';
        } else {
            $new_format = number_format($integer / 1000000000000, 2) . ' T';
        }
    }

    if ($integer < 0) {
        if ($integer > -1000000) {
            // Anything less than a million
            $new_format = number_format($integer);
        } else if ($integer > -1000000000) {
            // Anything less than a billion
            $new_format = number_format($integer / 1000000, 2) . ' M';
        } else if ($integer > -1000000000000) {
            // At least a billion
            $new_format = number_format($integer / 1000000000, 2) . ' B';
        } else {
            $new_format = number_format($integer / 1000000000000, 2) . ' T';
        }
    }

    if ($currency) {
        $new_format = $currency . $new_format;
    }

    return $new_format;
  }

  function remove_uneccessary_character($string, $characters){
        $new_string = str_replace($characters,"",$string);
        $new_string = str_replace(",","",$string);
        return $new_string;
  }

    function get_unique_promocode() {
        $code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 6));
        if (PromoCode::where('code', $code)->exists()) {
            get_unique_promocode();
        }

        return $code;
    }

    function pluralize($quantity, $singular, $plural=null) {
        if($quantity==1 || !strlen($singular)) return $singular;
        if($plural!==null) return $plural;
    
        $last_letter = strtolower($singular[strlen($singular)-1]);
        switch($last_letter) {
            case 'y':
                return substr($singular,0,-1).'ies';
            case 's':
                return $singular.'es';
            default:
                return $singular.'s';
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

    

