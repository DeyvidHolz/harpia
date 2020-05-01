<?php

class BRFormat
{

  public static function CPF ($val, $format = true) {
    $regex = '/^(\d{3})(\d{3})(\d{3})(\d{2})$/';
    $reverseRegex = '/^(\d{3})\.(\d{3})\.(\d{3})(\-\d{2})$/';

    if (preg_match($regex, $val)) {
      return preg_replace($regex, '$1.$2.$3-$4', $val);
    }
    
    else if (preg_match($reverseRegex, $val)) return preg_replace('/[^0-9]/', '', $val);

    return $val;
  }

  public static function CNPJ ($val, $format = true) {
    $regex = '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/';
    $reverseRegex = '/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})\-(\d{2})$/';

    if (preg_match($regex, $val)) {
      return preg_replace($regex, '$1.$2.$3/$4-$5', $val);
    }
    
    else if (preg_match($reverseRegex, $val)) return preg_replace('/[^0-9]/', '', $val);

    return $val;
  }
  
  public static function Date ($val) {
    $regex = '/^(\d{4})[\-|\/](\d{2})[\-|\/](\d{2})$/';
    $reverseRegex = '/^(\d{2})[\-|\/](\d{2})[\-|\/](\d{4})$/';
  
    if (preg_match($regex, $val)) {
      return preg_replace($regex, '$3/$2/$1', $val);
    }
    
    else if (preg_match($reverseRegex, $val)) return preg_replace($reverseRegex, '$3-$2-$1', $val);
  
    return $val;

  }
  
  public static function Money ($val) {
    return number_format($val, 2, ",", ".");
  }

  public static function Phone ($val, $reverseIncludePlus = false) {
    $regex = '/^(\d{2})?(\d{2})?(\d{4,5})(\d{4})$/';
    $reverseRegex = '/^(\+)? ?(\d{2})? ?(\(?\d{2}\)?)? ?(\d{4,5})[\s|\-]?(\d{4})$/';

    if ($val{0} === '+') $val = substr($val, 1);
  
    if (preg_match($regex, $val)) {

      $val = str_replace('  ', ' ', preg_replace($regex, '$1 $2 $3-$4', $val));
      if (strlen($val) === 15)  $val = '+' . $val;
      return trim($val);

    } else if (preg_match($reverseRegex, $val)) {

      $val = str_replace(' ', ' ', preg_replace($reverseRegex, '$1$2$3$4$5', $val));
      if ($reverseIncludePlus && strlen($val) === 12)  $val = '+' . $val;
      return trim($val);

    }
  
    return $val;

  }

}
