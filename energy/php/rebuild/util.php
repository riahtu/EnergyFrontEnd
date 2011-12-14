<?php
function array_get_key($ar, $key) {
  $ret = array();
  foreach ($ar as $val) {
    $ret[] = $val[$key];
  }
  return $ret;
}

function array_sample($ar, $size) {
  $step = count($ar) / $size;

  $ret = array();
  for ($i = 0; $i < count($ar); $i += $step) {
    $ret[] = $ar[$i];
  }

  return $ret;
}

?>
