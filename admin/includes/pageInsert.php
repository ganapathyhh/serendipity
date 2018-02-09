<?php

function downloader($data, $filename = true, $content = 'application/x-octet-stream')
   {
    // If headers have already been sent, there is no point for this function.
    if(headers_sent()) return false;
    // If $filename is set to true (or left as default), treat $data as a filepath.
    if($filename === true)
     {
      if(!file_exists($data)) return false;
      $data = file_get_contents($data);
     }
    if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false)
     {
      header('Content-Disposition: attachment; filename="'.$filename.'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Content-Transfer-Encoding: binary');
      header('Content-Type: '.$content);
      header('Pragma: public');
      header('Content-Length: '.strlen($data));
     }
    else
     {
      header('Content-Disposition: attachment; filename="'.$filename.'"');
      header('Content-Transfer-Encoding: binary');
      header('Content-Type: '.$content);
      header('Expires: 0');
      header('Pragma: no-cache');
      header('Content-Length: '.strlen($data));
     }
    // Send file to browser, and terminate script to prevent corruption of data.
    exit($data);
   }

?>