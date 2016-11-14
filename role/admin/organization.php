<?
  require_once('../../lib/start.php');

  if (!isset ($_SESSION))
  {
    session_start();
  }

  function getNameKved($link,$kod){
    if($kod!=""){
      $qeruStr="SELECT * FROM `kved10` WHERE kod like '".$kod."'";
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row["nu"];
        mysqli_free_result($result);
      }else{
        return "";
      }
    }
    return "";
  }

  $filtr_id = (isset($_SESSION['orgId']))?$_SESSION['orgId']:'';
  if($filtr_id!=""){

      $qeruStr="SELECT org.*, op.nu as opfNu, kis.nu as kisNu, kis.kod as kisKod, dep.nu as depNu FROM `organizations`as org left join opf as op on op.kd=org.pf"
      ." left join kise14 as kis on kis.kd=org.kice "
      ." left join managment_department as dep on dep.kd=org.gu "
      ." WHERE org.id= $filtr_id";

      $result = mysqli_query($link,$qeruStr);
      if($result){
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        $org=$row;
        getNameKved($link,$row['e6_10']);
        $org+=array('vdf10N' =>getNameKved($link,$row['vdf10']));
        for($i=1;$i<=6;$i++){

          $org+=array('e_'.$i.'N' =>getNameKved($link,str_replace(" ","",$row['e'.$i.'_10'])));
        }
        mysqli_free_result($result);
      }
      $qeruStr="SELECT * FROM `actual_address` WHERE id_org= $filtr_id";
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $addres = array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $addres[]=$r;
        }
        mysqli_free_result($result);
      }

      $qeruStr="SELECT * FROM `contact` WHERE id_org= $filtr_id  ORDER BY type";
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $contact = array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $contact[]=$r;
        }
        mysqli_free_result($result);
      }
      if($org["kdg"]!=0){
        $qeruStr="SELECT id, nu FROM `organizations` WHERE kd=".$org['kdg'];
        $result = mysqli_query($link,$qeruStr);
        if($result){
          $r=mysqli_fetch_array($result, MYSQLI_ASSOC);
          $org+=array('kdgNu' =>$r["nu"],'idKdg' =>$r["id"]);
          mysqli_free_result($result);

        }
      }
  }

  if($org["kd"]!=0){
    $qeruStr="SELECT id,kd,kdmo,kdg,nu FROM `organizations` WHERE kdg=".$org['kd'];
    $result = mysqli_query($link,$qeruStr);
    if($result){
      if(mysqli_num_rows($result)>0){
        $child= array();
        while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $child[]=$row;
        }
      }
    }
  }

  require_once('template/organization.php');
?>
