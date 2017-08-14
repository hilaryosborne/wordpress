<?php

foreach (new DirectoryIterator(__DIR__) as $fileInfo) {
    if ($fileInfo->isDot()) { continue; }
    if (!$fileInfo->isDir()) { continue; }

    foreach (new DirectoryIterator($fileInfo->getPathname()) as $_fileInfo) {
      if ($_fileInfo->isDot()) { continue; }
      if ($_fileInfo->isDir()) { continue; }
      if ($_fileInfo->getExtension() != 'php') { continue; }
      $file_contents = file_get_contents($_fileInfo->getPathname());
      if (stripos($file_contents,'Plugin Name') === -1) { continue; } 
      include_once($_fileInfo->getPathname());
    }
}
