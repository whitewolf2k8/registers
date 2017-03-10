<?
  $file=isset($_POST['file'])?$_POST['file']:"";
  if (file_exists('..\..\..\files\unload\\'.$file.'.dbf')) {
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
    header('Content-Length: ' . filesize('..\..\..\files\unload\\'.$file.'.dbf'));

    $f=fopen('..\..\..\files\unload\\'.$file.'.dbf', 'rb');
    while(!feof($f)) {
      // Читаем килобайтный блок, отдаем его в вывод и сбрасываем в буфер
      echo fread($f, 1024);
      flush();
    }
// Закрываем файл
   fclose($f);
  //  readfile('..\..\..\files\unload\\'.$file.'.dbf');
    /*if ($fd = fopen('..\..\..\files\unload\\'.$file.'.dbf', 'rb')) {
      while (!feof($fd)) {
        print fread($fd, 1024);
      }
      fclose($fd);
    }*/
    unlink ('..\..\..\files\unload\\'.$file.'.dbf');
    exit;
  }

?>
