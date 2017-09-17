<?php

use App\Theme\Partial;

function get_partial($context, $fileOrParams=false, $params=[]) {

  $partial = new Partial($context,!is_array($fileOrParams) ? $fileOrParams : false);
  return $partial->get(is_array($fileOrParams) ? $fileOrParams : $params);

}
