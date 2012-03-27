<?php
namespace OWASP\Validators\Validator;

class VarType {

  public static function validate($var, $expected) {
    if (gettype($var) === $expected){
      return true;
    }
    return false;
  }
}

?>
