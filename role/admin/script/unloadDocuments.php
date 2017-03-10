<?
  $file=isset($_POST['file'])?$_POST['file']:"";
  $path_file='../../../files/unload/'.$file.'.dbf';
  if (file_exists($path_file)) {
    if (ob_get_level()) {
      ob_end_clean();
    }
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition:  attachment; filename=' .$file.".dbf");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path_file));
	  readfile($path_file);
    unlink ($path_file);
    exit;
  }

?>
