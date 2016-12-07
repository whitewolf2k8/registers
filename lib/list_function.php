<?
  function createList($link, $fildName, $query, $selected="",$strInp="- Всі -")
  {
    $str="<option value='' ".((($selected==""))?"selected":"").">".$strInp."</option>";
    $result = mysqli_query($link,$query);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str.="<option value='".$row[$fildName]."' ".(($selected==$row[$fildName])?"selected":"").">".$row[$fildName]."</option>";
      }
    }
    return $str;
  }

  function createListDuble($link, $fildName1,$fildName2, $query, $selected="",$strInp="- Всі -")
  {
    $str="<option value='' ".((($selected==""))?"selected":"").">".$strInp."</option>";
    $result = mysqli_query($link,$query);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str.="<option value='".$row[$fildName1]."' ".(($selected==$row[$fildName1])?"selected":"").">".$row[$fildName2]."</option>";
      }
    }
    return $str;
  }

  function getListKvedSek($link, $selected){
    $str="SELECT DISTINCT `sek` FROM `kved10`";
    return createList($link,"sek",$str,$selected);
  }


  function getListObl($link, $selected){
    $str="SELECT * FROM `region` WHERE `kod`=0";
    return createListDuble($link,"reg","nu",$str,$selected);
  }

  function getListTeR($link, $selected_obl,$selected_reg){
    $str="SELECT * FROM `region` WHERE reg=".$selected_obl." AND kod NOT IN (0,100,200)";
    return createListDuble($link,"kod","nu",$str,$selected_reg);
  }

  function getListRoleUser($selected,$typeUsers){
    $str="<option value='' ".(($selected==="")?"selected":"")."> - Всі - </option>";
    foreach ($typeUsers as $key => $value) {
      $str.="<option value='".$key."' ".(($selected===$key)?"selected":"").">".$value."</option>";
    }
    return $str;
  }

  function getListYear($link, $id , $t)
  {
    $str="";
    $qeruStr="SELECT * FROM `year` ";
    $result = mysqli_query($link,$qeruStr);
    if($t==1){
      $str="<option value='' "."selected"."> - Всі - </option>";
    }
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $select="";
        if($id==$row['id']){
          $select="selected";
        }else if(date('Y')==$row["nu"] && $t!=1){
          $select="selected";
        }
        $str.="<option value='".$row['id']."' ".$select.">".$row['nu']."</option>";
      }
    }
    return $str;
  }


  function getListPeriod($link, $id)
  {
    $qeruStr="SELECT * FROM `period` ";
    $result = mysqli_query($link,$qeruStr);
    $str="<option value=''".(($id==="")?"selected":"")."> - Всі - </option>";
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str.="<option value='".$row['id']."' ".(($id===$row['id'])?"selected":"").">".$row['nu']."</option>";
      }
    }
    return $str;
  }

  function getListDepatment($link, $id,$type=0,$mes=" - не обрано - ")
  {
    $qeruStr="SELECT * FROM `depatment`".(($type==0)?" WHERE dead = 0 ":"");
    $result = mysqli_query($link,$qeruStr);
    $str="<option value='0'".(($id==="")?"selected":"").">".$mes."</option>";
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str.="<option ".(($row['dead']==1)?"disabled":"")."  value='".$row['id']."' ".(($id===$row['id'])?"selected":"").">".$row['nu']."</option>";
      }
    }
    return $str;
  }

  function getListBankruts($link, $id,$type=0,$mes=" - не обрано - ")
  {
    $qeruStr="SELECT DISTINCT type_deal FROM `bankrupts`";
    $result = mysqli_query($link,$qeruStr);
    $str="<option value='0'".(($id=="0")?"selected":"''").">".$mes."</option>";
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $str.="<option value='".$row['type_deal']."' ".(($id==$row['type_deal'])?"selected":"").">".$row['type_deal']."</option>";
      }
    }
    return $str;
  }

  function getListDepatmentByKod($link, $kod,$type=0,$mes=" - не обрано - ")
  {
    $qeruStr="SELECT * FROM `depatment`".(($type==0)?" WHERE dead = 0 ":"");
    $result = mysqli_query($link,$qeruStr);
    $str="<option value='0'".(($kod==="")?"selected":"").">".$mes."</option>";
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str.="<option ".(($row['dead']==1)?"disabled":"")."  value='".$row['id']."' ".(($kod===$row['nom'])?"selected":"").">".$row['nu']."</option>";
      }
    }
    return $str;
  }

  function getListTypeAct($arr,$id,$mes=" - не обрано - ")
  {
    $str="<option value='0'".(($id==0)?"selected":"").">".$mes."</option>";
    foreach ($arr as $key => $value) {
      $str.="<option value='".$key."' ".(($id==$key)?"selected":"").">".$value."</option>";
    }
    return $str;
  }

  function getListRay($link,$obl,$ray,$mes=" - всі - ")
  {
    $result=array();
    if($obl==""){
      $result["anabled"]=0;
      $result["data"]="<option value='' selected >".$mes."</option>";
    }else{
      $result["anabled"]=1;
      $result["data"]=getListTeR($link, $obl,$ray);
    }
    return $result;
  }

  function getListTeritorys($link,$obl,$ray,$ter,$mes=" - всі - ")
  {
    $result=array();
    if($ray==""){
      $result["anabled"]=0;
      $result["data"]="<option value='' selected >".$mes."</option>";
    }else{
      $result["anabled"]=1;
      $str="SELECT te, nu FROM `koatuu` WHERE  te like  ('".$obl.$ray."%') and te not like  ('%000') ";
      $result["data"]=createListDuble($link,"te","nu",$str,$ter);
    }
    return $result;
  }

  function getListMeneger($link, $selected){
    $str="SELECT * FROM `managers`";
    return createListDuble($link,"id","nu",$str,$selected);
  }

?>
