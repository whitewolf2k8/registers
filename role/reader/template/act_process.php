<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../jquery-ui-1.12.1.custom/jquery-ui.css" media="screen" type="text/css" />
<title>�������</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/tcal.js"></script>
<script src="../../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="../../../js/script_act_process.js"></script>

<script type="text/javascript">

  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];

    if(mode=='add'){
      correct= confirm("�� ������� � ����� ??");
    }
    if(mode=='del'){
      correct= confirm("�� �� ������ �������� ������ ������??");
    }
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      form.submit();
    }
  }


</script>
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

        <h2>�������� ���� </h2>

        <form name="adminForm" action="act_process.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="position: relative; width: 900px; left: 50%; margin-left: -450px;">

            <div id='errorM' style='display="none";margin-left:15%;'>	</div>

            <p class="act_add">
              <input type="hidden" id="orgid"/>
              <span>Kd <input type="text"  maxlength="8" placeholder="������" id="kd" style="width:100px;" /></span>
              <span>Kdmo <input type="text" placeholder="����" maxlength="12" id="kdmo" style="width:130px;"/> </span>
              <span>����� <input type="text" id="nuOrg"  placeholder="����� ����������" readonly  style=" width:422px;" /> </span>
              <span><input type="button"  class="button" value="�����" onclick="searhOrg()"/></span>
            </p>

            <div class="clr"></div>

            <p class="act_add">
              <span>���� ��������� ���� <input type="text" id='dateS'  value=""></span>
              <span style="float:right">���� �������� �� ������ ����������� ����
                 <input type="text" id='dateEnd'  value="">
              </span>
            </p>

            <div class="clr"></div>

            <p class="act_add">
              <span>����� ������ ����������� ���� <input type="text"  id="kodDis" style="width:150px;"  value=""></span>
              <span>��� ���������� ����� <input type="text"  id="kodDepNom"  value="" maxlength="4"  style="width:50px;" onchange="chandeDep();" />
                  <select id="kodDepList"  style="width:222px; text-align:center;" onchange="chengeIdListDep();"><? echo $list_department; ?></select>
              </span>
            </p>

            <div class="clr"></div>
            <p class="act_add">
              <span id="typeAct">������ ���� <select name="types[]" style="width:150px;"><? echo $list_type_act; ?></select>
              <select name="types[]" style="width:150px;"><? echo $list_type_act; ?></select>
              <input type="button" value="" name="add_type" class="btn_add"  onclick="addTypeSelect();"/> </span>
            </p>

            <div class="clr"></div>
            <p class="act_add">
              <span>������ ��������� ���� <input type="text" id="ad"  style="width:697px;" value=""></span>
            </p>

            <div class="clr"></div>
            <p align="center">
              <input type="button" value="������" class="button" onclick="addToDb();" />
              <input type="button" value="��������" class="button" onclick="cleanFormImport()" />
            </p>

          </div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table id="table_id" >
              <tr>
                <th rowspan="2">&nbsp;</th>
                <th rowspan="2">������</th>
                <th rowspan="2">����</th>
                <th colspan="2">���� </th>
                <th rowspan="2">����� ������</th>
                <th rowspan="2">��� ����</th>
                <th rowspan="2">��������� ����</th>
                <th rowspan="2">������ ���������</th>
              </tr>
              <tr class="second_level">
                <th> ��������� ����</th>
                <th>�������� �� ������ ����</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr id=\"".$value['id']."\">";
                echo "<td  style =\" overflow:visible\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\"".$value["id"]."\" onchange=\"chacheCheck('".$value["id"]."');\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kd"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kdmo"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["da"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["dl"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["rnl"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["types"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["dep"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["ad"]."</td>";
                echo"</tr>";
              }
        } ?>
          </table>
        </div>
        <div class="clr"></div>
        <div class="item_blue" style="position: relative; width: 400px; left: 50%; margin-left: -200px;">
          <div class="clr"></div>
          <h2 style="text-align:center;">�������� �������� ������</h2>
          <p align="center">
            <input type="button" id="bt_sev" value="�������� ������ ������ �� ����" disabled class="button" onclick="submitForm('add');" />
            <input type="button" id="bt_del" value="�������� ������ ������" disabled class="button" onclick="submitForm('del');" />
          </p>
        </div>
        <div class="clr"></div>
    </form>
	  </div>
  </div>
</div>
<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>
<div id="toTop" > ^ ������ </div>
</body>
</html>
