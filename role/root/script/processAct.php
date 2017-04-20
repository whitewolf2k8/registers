<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST['mode'];


  if($action=="getListType1")
  {
    $options= array(getListTypeAct1($typeAct,0));
    echo php2js($options);

  }

  function getListTypeAct1($arr,$id,$mes=" - не обрано - ")
  {
    $str="<option value='0'".(($id==0)?"selected":"").">".$mes."</option>";
    foreach ($arr as $key => $value) {
      $str.="<option value='".$key."' ".(($id==$key)?"selected":"").">".$value."</option>";
    }
    return $str;
  }


  closeConnect($link);
?>
