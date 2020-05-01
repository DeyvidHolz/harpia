<?php

class Validator
{

  private static $allowedValidationTypes = [
    'letters', 'required', 'alpha', 'username', 'email', 'digits', 'maxlength', 'minlength', 'length'
  ];


  // {field} = fieldname | {value} = the max length value (for example), or the property prefix.
  private static $invalidMessages = [
    'letters' => 'É pemitido apenas letras para o campo {field}.',
    'required' => 'O campo {field} é obrigatório.',
    'alpha' => 'É permitido apenas letras não acentuadas e números para o campo {field}.',
    'username' => 'Digite um nome de usuário válido.',
    'email' => 'Digite um e-mail válido.',
    'digits' => 'É permitido apenas números para o campo {field}.',
    'digits.1' => 'O campo {field} deve ter {value} dígitos',
    'minlength' => 'O campo {field} deve conter no mínimo {value} caractere(s).',
    'maxlength' => 'O campo {field} deve conter no máximo {value} caractere(s).',
    'length' => 'O campo {field} deve ter entre {value} caractere(s).'
  ];


  // The {values} of $invalidMessages will be replaced by the prefixes. The index must be the same of $invalidMessages.
  // {v} will be replaced by the values, min and max (for example).
  private static $prefixes = [
    'digits.1' => 'no mínimo {v} e no máximo {v}',
    'length' => '{v} a {v}'
  ];

  public static function get(Array $arr) {
    $errors = [];
    
    foreach($arr as $arrValidate) { // [0] = [ value, validation_str, fieldname ]
      $field = array_search('field', $arrValidate);
      unset($arrValidate[$field]);

      if ($field) {
        foreach ($arrValidate as $value => $validateString) {
          $isValid = self::getValidation($validateString, $value, $field);
          if (count($isValid)) $errors[$field] = $isValid;
        }
      } else {
        harpErr(['Validator Error' => 'Field not found.', 'Description' => 'Passed field is empty. Put "fieldNameExample" => "field" in your Validation Array.'],__LINE__,__FILE__);
      }

    }

    return (count($errors)) ? $errors : true;
    
  }

  public static function getValidation($validator, $value, $field = null) {
    // Prepare the validation parameters
    $errors = [];

    $toValidate = explode('|', $validator);
    
    foreach ($toValidate as $tempValidation) {
      $validation = explode(':', $tempValidation);
      if (!isset($validation[1])) $validation[1] = null;
      $valid = self::validate($validation[0], $validation[1], $value, $field);
      if ($valid !== true && !empty($valid))  $errors[] = $valid;
    }
    
    return $errors;
  }

  public static function validate($validationString, $validationOption, $value, $field = null) {
    // Check validation string and calls validate method
    $allowedValidationTypes = self::$allowedValidationTypes;

    if (in_array($validationString, $allowedValidationTypes)) {
      return self::$validationString($value, $field, $validationOption);
    }
    harpErr(['Validator Error' => 'Validation "' . $validationString . '" is an invalid type of validation.'],__LINE__,__FILE__);
    exit;
  }

  public static function getPreparedInvalidMessage ($message, $field = null, $validationOptionValue = null) {
    $message = str_replace('{field}', $field, $message);
    $message = str_replace('{value}', $validationOptionValue, $message);
    $message = str_replace('  ', ' ', $message);
    
    return $message;
  }

  public static function required ($val, $field) {
    return (!empty($val)) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function letters($val, $field, $allowSpaces) {
    if ($allowSpaces === 'allowSpaces' || $allowSpaces === 'allow') {
      return preg_match('/^[A-Za-záàâãéèêíïóôõöúçÁÀÂÃÉÈÍÏÓÔÕÖÚÇ ]+$/', $val) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
    }
    
    return preg_match('/^[A-Za-záàâãéèêíïóôõöúçÁÀÂÃÉÈÍÏÓÔÕÖÚÇ]+$/', $val) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function alpha ($val, $field) {
    return preg_match('/^[A-Za-z0-9]+$/', $val) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function username ($val, $field) {
    return preg_match('/^[\w\.{1}]+$/', $val) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function email ($val, $field) {
    return preg_match('/^([\w.]+)@(\w+)\.(\w+)$/', $val) ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function digits($val, $field, $between) {

    if (preg_match('/^[0-9]*$/', $val)) {
      if (!empty($between)) {
        $between = explode('-', $between);
        if (count($between) > 1 && !empty($between[1])) {
          $valid = true;
          if (strlen($val) < $between[0]) {
            $replacement = self::$prefixes[__FUNCTION__.'.1'];
            $replacement = preg_replace('/\{v\}/', $between[0], $replacement, 1);
            $replacement = preg_replace('/\{v\}/', $between[1], $replacement, 1);

            $valid = self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__.'.1'], $field, $replacement);
          }

          if (strlen($val) > $between[1]) {
            $replacement = self::$prefixes[__FUNCTION__.'.1'];
            $replacement = preg_replace('/\{v\}/', $between[0], $replacement, 1);
            $replacement = preg_replace('/\{v\}/', $between[1], $replacement, 1);

            $valid = self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__.'.1'], $field, $replacement);
          }

          return $valid;
        } else {
          return (float) $val <= (float) $between[0] ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__.'.1'], $field);
        }
      } else {
        return true;
      }
    }

    return self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field);
  }

  public static function maxlength ($val, $field, $max) {
    return strlen($val) <= $max ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field, $max);
  }

  public static function minlength ($val, $field, $min) {
    return strlen($val) >= $min ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field, $min);
  }

  public static function length($val, $field, $between) {
    if (!empty($between)) {
      $between = explode('-', $between);
      if (count($between) === 2) {
        $valid = true;
        if (strlen($val) < $between[0]) {
          $replacement = self::$prefixes[__FUNCTION__];
          $replacement = preg_replace('/\{v\}/', $between[0], $replacement, 1);
          $replacement = preg_replace('/\{v\}/', $between[1], $replacement, 1);

          $valid = self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field, $replacement);
        }

        if (strlen($val) > $between[1]) {
          $replacement = self::$prefixes[__FUNCTION__];
          $replacement = preg_replace('/\{v\}/', $between[0], $replacement, 1);
          $replacement = preg_replace('/\{v\}/', $between[1], $replacement, 1);

          $valid = self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field, $replacement);
        }

        return $valid;
      } else {
        return (float) $val <= (float) $between[0] ? true : self::getPreparedInvalidMessage(self::$invalidMessages[__FUNCTION__], $field, $between[0]);
      }
    } else {
      return true;
    }
  }

}