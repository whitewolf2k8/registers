<?
  require_once('../../lib/start.php');

  function getTypeLine($arr)
  {
    return $arr['type'];
  }


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

      $str_bankrut="SELECT * FROM bankrupts WHERE  id_org = ".$org["id"];
      $result = mysqli_query($link,$str_bankrut);
      if(mysqli_num_rows($result)>0){
        $bankrut_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $bankrut_info[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_acts="SELECT * FROM `acts` WHERE  org = ".$org["id"];
      $result = mysqli_query($link,$str_acts);
      if(mysqli_num_rows($result)>0){
        $act_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $r["da"]=dateToDatapiclerFormat($r["da"]);
          $r["dl"]=dateToDatapiclerFormat($r["dl"]);
          $act_info[]=$r+array('types' =>getTypeActStr($typeAct,$r['act']),'dep'=>getDepartmentNu($link,$r['department']) );
        }
      }
      mysqli_free_result($result);


      $str_activ="SELECT * FROM `letter_base` WHERE  id_org = ".$org["id"]." AND type = 0 ";
      $result = mysqli_query($link,$str_activ);
      if(mysqli_num_rows($result)>0){
        $violation_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $violation_info[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_violation="SELECT * FROM `letter_base` WHERE  id_org = ".$org["id"]." AND type = 1 ";

      $result = mysqli_query($link,$str_violation);
      if(mysqli_num_rows($result)>0){
        $activity_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $activity_info[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_cause="SELECT t1.*,t2.nu FROM `violation_base` as t1 LEFT JOIN `managers` as t2 on t2.id=t1.id_maneger  WHERE  id_org = ".$org["id"];
      $result = mysqli_query($link,$str_cause);
      if(mysqli_num_rows($result)>0){
        $cause_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $cause_info[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_profit="SELECT t2.nu as nuYear,t2.short_nu as yearShot, t3.nu as nuPeriod,t3.start_m, t3.finish_m ,t1.profit FROM `profit_fin` as t1  left join year"
        ." as t2 on t1.`id_year` = t2.id left join period as t3 "
        ."on t1.id_period = t3.id  WHERE t1.id_org = ".$org["id"]." ORDER BY t2.nu DESC, t3.start_m DESC";
      $result = mysqli_query($link,$str_profit);

      if(mysqli_num_rows($result)>0){
        $profit_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $profit_info[]=$r;
        }
      }
      mysqli_free_result($result);
  

      $str_amount="SELECT t2.nu as nuYear,t2.short_nu as yearShot, t3.nu as nuPeriod,t3.start_m, t3.finish_m ,t1.amount, t1.type FROM `amount_workers` as t1  left join year"
        ." as t2 on t1.`id_year` = t2.id left join period as t3 "
        ."on t1.id_period = t3.id  WHERE t1.id_org = ".$org["id"]."  ORDER BY t2.nu DESC, t3.start_m DESC";
      $result = mysqli_query($link,$str_amount);
      if(mysqli_num_rows($result)>0){
        $amount_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $amount_info[]=$r;
        }
      }
      mysqli_free_result($result);


      $amount_res=array();

      for ($i=0; $i < count($amount_info) ; $i++) {
        $line1= $amount_info[$i];
        if(isset($amount_info[$i+1])){
          if(($amount_info[$i][nuYear]==$amount_info[$i+1][nuYear]) && ($amount_info[$i][nuPeriod]==$amount_info[$i+1][nuPeriod]))
          {
            $line2= $amount_info[$i+1];
            $i++;
          }
        }

        if(isset($line2)){
          $fin=0;
          $pv=0;
          if(getTypeLine($line1)==1){
            $fin=$line1['amount'];
          }else{
            $pv=$line1['amount'];
          }
          if(getTypeLine($line2)==1){
            $fin=$line2['amount'];
          }else{
            $pv=$line2['amount'];
          }
          $amount_res[]=array('nuYear' =>$line1['nuYear'], 'yearShot' =>$line1['yearShot'],'nuPeriod' =>$line1['nuPeriod'],'amountF' =>$fin,'amountP' =>$pv  );
        }else{
          $fin=0;
          $pv=0;
          if(getTypeLine($line1)==1){
            $fin=$line1['amount'];
          }else{
            $pv=$line1['amount'];
          }
          $amount_res[]=array('nuYear' =>$line1['nuYear'], 'yearShot' =>$line1['yearShot'],'nuPeriod' =>$line1['nuPeriod'],'amountF' =>$fin,'amountP' =>$pv  );
        }
      }

      $str_activity_tax="SELECT t2.nu as nuYear,t2.short_nu as yearShot, t3.nu as nuPeriod,t1.sign FROM `activity_tax` as t1  left join year"
        ." as t2 on t1.`id_year` = t2.id left join period as t3 "
        ."on t1.id_period = t3.id  WHERE t1.id_org = ".$org["id"]." ORDER BY t2.nu DESC, t3.start_m DESC";
      $result = mysqli_query($link,$str_activity_tax);
      if(mysqli_num_rows($result)>0){
        $activity_tax_info=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $activity_tax_info[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_ecp="SELECT t2.nu as nuYear,t2.short_nu as yearShot, t1.el_info FROM `el_signatures` as t1  left join year"
        ." as t2 on t1.`id_year` = t2.id  WHERE t1.id_org = ".$org["id"]." ORDER BY t2.nu DESC ";
      $result = mysqli_query($link,$str_ecp);
      if(mysqli_num_rows($result)>0){
        $info_ecp=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $info_ecp[]=$r;
        }
      }
      mysqli_free_result($result);

      $str_consents="SELECT t2.nu as nuYear,t2.short_nu as yearShot, t1.type FROM `consents` as t1  left join year"
        ." as t2 on t1.`id_year` = t2.id  WHERE t1.id_org = ".$org["id"]." ORDER BY t2.nu DESC ";
      $result = mysqli_query($link,$str_consents);
      if(mysqli_num_rows($result)>0){
        $info_consents=array();
        while($r=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $info_consents[]=$r;
        }
      }
      mysqli_free_result($result);

  }


  require_once('template/organization.php');
?>
