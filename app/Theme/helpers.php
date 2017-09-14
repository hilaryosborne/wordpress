<?php

use App\Theme\Partial;

function get_partial($context, $file=false, $params=[]) {

  $partial = new Partial($context,$file);

  return $partial->get($params);
}
