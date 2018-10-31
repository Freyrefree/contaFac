<?php
  
  $documento = $_REQUEST['archivo'];
  $uuid = $_REQUEST['uuid'];


   header('Content-Type: application/octet-stream');
   header('Content-Disposition: attachment; filename='.$uuid.".XML");
   header('Content-Transfer-Encoding: binary');
   header('Content-Length: '.filesize($documento));

   readfile($documento);

   exit;
?>