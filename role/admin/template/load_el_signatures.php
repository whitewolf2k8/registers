<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<title>�������</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    if(mode=='import'){
      if (form.fileImp.value=="") {
        correct = false;
        document.getElementById('fileImp').className="error";
        document.getElementById('errorMes').className="error";
        document.getElementById('errorMes').innerHTML="<p>���� ����� ������ ���� ��� �������.</p>";
      }
    }

    if(mode=='edit'){
      correct= confirm("�� �������� � ����� ??");
      if(correct){
        var arrCheck=document.getElementsByName("checkList[]");
        for(var i=0;i<arrCheck.length;i++){
          arrCheck[i].disabled=false;
        }
      }
    }
    if(mode=='del'){
      correct= confirm("�� �� ������ �������� ������� ������??");
    }
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function formCleanList(arr) {
    document.getElementById("filtr_year_insert").innerHTML=arr.insert_year;
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

        <h2>����� ����������� ������</h2>
        <form name="adminForm" action="load_el_signatures.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>����� �����</h2>
            <p><input type="file" id="fileImp"  accept=".csv" name="fileImp" style="width:256px" /></p>
            <p style="text-align:center">����� �� ����  �����������</p>
            <p>
               <div class="navigation_left">��</div>
               <div class="navigation_right">
                  <select id="filtr_year_insert" name="filtr_year_insert" style="width:200px;text-align:center;"><? echo $insert_year; ?></select>
               </div>
            </p>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="���������" class="button" onclick="cleanFormImport()" />
              <input type="button" value="�����������" class="button" onclick="submitForm('import')" />
            </p>
          </div>


          <div class="item_blue" style="float:left;margin-left:25%; width:330px;">
  	        <h2>�����</h2>
            <p>
          	   <div class="navigation_left">����� �� ������</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kd"  name="filtr_kd" value="<?php echo $filtr_kd; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
          	   <div class="navigation_left">����� �� KDMO</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kdmo" name="filtr_kdmo" value="<?php echo $filtr_kdmo; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">��</div>
               <div class="navigation_right">
                  <select id="filtr_year_select" name="filtry_year_select" style="width:200px;text-align:center;"><? echo $select_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="�����" class="button" onclick="submitForm('')" />
  	        </p>
  	    	</div>

          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table>
              <tr>
                <th>������</th>
                <th>KDMO</th>
                <th>����������� �����</th>
                <th>г�</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
                echo "<td style =\" overflow:hidden;\" >".$value["kd"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kdmo"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["el_info"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nu"]."</td>";
                echo"</tr>";
              }
        } ?>
          </table>
        </div>
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
  <div id="toTop" > ^ ������ </div>
</body>
</html>
