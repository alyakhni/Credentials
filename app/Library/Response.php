<?php

namespace App\Library\Response;

class Response
{
  const MISSING_PARAMS = "The request is missing a required parameter, includes an invalid parameter value, includes a parameter more than once, or is otherwise malformed.";

  public static function success(){

  }

  public static function error($response, $array){
    return response()->json($array);
  }
}
