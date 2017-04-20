<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../jquery-ui-1.12.1.custom/jquery-ui.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/act_show.js"></script>
<script src="../../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="../../../js/act-change.js"></script>

</head>
<body>
  <div class="wrapper">
	  <div class="header">
         <?php  require_once('header.php'); ?>
	  </div>

	  <div class="content">
      <div class="mainConteiner">
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>

        <h2>Акт редагування </h2>
        <form name="adminForm" action="act_change.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="position: relative; width: 500px; left: 50%; margin-left: -225px;">
            <div id='errorM' style='display="none";margin-left:15%;'>	</div>
            <h2 style="text-align:center;" >Пошук актів по параметрам</h2>
            <p class="act_add" style="text-align:center;">
              <span>Коду ЄДРПОУ <input type="text" maxlength="8" placeholder="ЄДРПОУ" id="kd" name="kd" onchange="searhOrg();" style="width:90px;" value="<? echo $filtr_kd; ?>" /> </span>
              <span>Коду КДМО <input type="text" placeholder="КДМО" maxlength="12" id="kdmo" name="kdmo" onchange="searhOrg();" style="width:125px;" value="<? echo $filtr_kdmo; ?>" />
            </p>
            <div class="spoiler-body">
            </div>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Пошук" class="button" onclick="submitForm('search')" />
              <input type="button" value="Видалити" id="delBtn" class="button" disabled  onclick="submitForm('del')" />
              <input type="button" value="Зберегти" id="saveBtn" class="button" disabled=true onclick="submitForm('edit')"
            </p>
          </div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table id="table_id" >
              <tr>
               <th rowspan="2">&nbsp;</th>
                <th rowspan="2">ЄДРПОУ</th>
                <th rowspan="2">КДМО</th>
                <th colspan="2">Дата </th>
                <th rowspan="2">Номер рішення</th>
                <th rowspan="2" width=200px>Тип акту</th>
                <th rowspan="2">Галузевий відділ</th>
                <th rowspan="2">Адреса складання</th>
              </tr>
              <tr class="second_level">
                <th width=170px> складання акту</th>
                <th width=170px>ліквідації по рішенню суду</th>
              </tr>
              <? foreach ($ListResult as $key => $value) {
                echo "<tr name=\"tablo[]\" id=\"".$value['id']."\">";
                echo "<td style =\" overflow:visible;\" ><input type=\"checkbox\" id=\"".$value['id']."\"  name=\"checkList[]\" value=\"".$value["id"]."\" onchange =\"chacheCheck(".$value['id'].")\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kd"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kdmo"]."</td>";
                echo "<td style =\" overflow:hidden;\" ><input class=\"amo\" type=\"text\" id=\"dT_".$value['id']."\" name=\"Ddata[".$value['id']."]\" style=\"text-align:center;width:100px;\" value =\"".$value['da']."\" onchange=\"changeAmountAction('".$value['id']."')\"".$filtr_dateTest."\"/></td>";
                echo "<td style =\" overflow:hidden;\" ><input class =\"amo\" type=\"text\" id=\"dT1_".$value['id']."\" name=\"Ldata[".$value['id']."]\" style=\"text-align:center;width:100px;\" value =\"".$value['dl']."\" onchange=\"changeAmountAction('".$value['id']."')\"".$filtr_dateTest1."\"/></td>";
                echo "<td style =\" overflow:hidden;\" ><input class=\"amo\" type=\"text\" id=\"".$value['id']."\" name=\"textRnl[".$value['id']."]\" style=\"text-align:center;width:120px;\" value =\"".$value['rnl']."\" onchange=\"changeAmountAction('".$value['id']."')\"/></td>";
                echo "<td style =\" overflow:hidden;\" ><select class=\"amo\" id=\"ty_".$value['id']."\" name=\"typeSelect_".$value['id']."[]\"style=width:180px \" onchange=\"changeAmountAction('".$value['id']."')\"".$value['types']."</select><input   id=\"at_".$value['id']."\" type=\"button\" name=\"add_type\"  class=\"btn_add\"
                onclick=\"addTypeSelect( 'at_".$value['id']."');  \"/></td>";
                echo "<td style =\" overflow:hidden;\" ><select class=\"amo\" id=\"li_".$value['id']."\" name=\"depSelect[".$value['id']."]\" style=width:200px \" onchange=\"changeAmountAction('".$value['id']."')\">".$value["dep"]."</select></td>";
                echo "<td style =\" overflow:hidden;\" ><input class=\"amo\" type=\"text\" id=\"".$value['id']."\" name=\"textAd[".$value['id']."]\" style=\"text-align:center;width:200px;\" value =\"".$value['ad']."\" onchange=\"changeAmountAction('".$value['id']."')\"/></td>";
                echo"</tr>";
              } ?>
            </table>
          </div>
        <? } ?>
        </form>
     </div>

	  </div>

</div><!-- .wrapper -->
  <div id="paginatorT">
      <? if(isset($pagination)) echo $pagination; ?>
  </div>
<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>
  <div id="toTop" > ^ Наверх </div>
</body>
</html>
