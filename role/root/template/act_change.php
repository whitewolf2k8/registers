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
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    document.getElementById("kveds").value=getKveds();
    document.getElementById("kises").value=getKises();
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function openUrl(url, post)
   {
       if ( post ) {
           var form = $('<form/>', {
               action: url,
               method: 'POST',
               target: '_blank',
               style: {
                  display: 'none'
               }
           });
           for(var key in post) {
               form.append($('<input/>',{
                   type: 'hidden',
                   name: key,
                   value: post[key]
               }));
           }
           form.appendTo(document.body); // Необходимо для некоторых браузеров
           form.submit();

       } else {
           window.open( url, '_blank' );
       }
  }


  $(document).ready(function() {

    function setDataTest() {
        $('.test').datepicker({showOn: "button",
                  dateFormat: 'yy/mm/dd',
                  buttonImage: "../../img/cal.gif",
                  showOtherMonths: true, autoSize: true,
                  monthNames:month ,
                  dayNamesMin:days ,
                  changeMonth: true,
                  changeYear: true,
                  yearRange: "-1:+2",
                  monthNamesShort: monthSotr});


    }

        function setDataTest1() {
            $('.test1').datepicker({showOn: "button",
                      dateFormat: 'yy/mm/dd',
                      buttonImage: "../../img/cal.gif",
                      showOtherMonths: true, autoSize: true,
                      monthNames:month ,
                      dayNamesMin:days ,
                      changeMonth: true,
                      changeYear: true,
                      yearRange: "-1:+2",
                      monthNamesShort: monthSotr});
        }


    setDataTest('date');
    setDataTest1('date');
    var x=document.getElementsByName('tablo[]');
    for (var i = 0; i < x.length; i++) {
      setDataPoclerFild('dT_'+x[i].id);
      setDataPoclerFild('dT1_'+x[i].id);
      console.log(x[i].id);
    }
    // setDataPoclerFild('dateActS');
    // setDataPoclerFild('dateActE')

    console.log("ready");
    $('.spoiler-body').hide();
    $('.spoiler-title').click(function(){
      $(this).next().slideToggle();
    });
  });

  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    if(mode=='import'){
      if (form.fileImp.value=="") {
        correct = false;
        document.getElementById('fileImp').className="error";
        document.getElementById('errorMes').className="error";
        document.getElementById('errorMes').innerHTML="<p>Будь ласка оберіть файл для імпорту.</p>";
      }
    }

    if(mode=='edit'){
      correct= confirm("Ви впевнені в змінах ??");
      if(correct){
        var arrCheck=document.getElementsByName("checkList[]");
        for(var i=0;i<arrCheck.length;i++){
          arrCheck[i].disabled=false;
        }
      }
    }
    if(mode=='del'){
      correct= confirm("Ви що хочете видалити відмічені записи??");
    }
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function cleanFormImport() {
    document.getElementById("fileImp").value="";
    $.ajax({
     type: "POST",
     url: "script/process_amount_pv.php",
     data: {mode:'getList'},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         formCleanList(res);
      }
   });
  }


  function chacheCheck(){
    var arrText=document.getElementsByClassName("amo");
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].checked)
        cnt++;
    }
    var flag=true;
    if(cnt==0)
    {
      flag=false;
      document.getElementById("delBtn").disabled=true;
      document.getElementById("addBtn").disabled=false;
    }else{
      document.getElementById("delBtn").disabled=false;
      document.getElementById("addBtn").disabled=true;
    }

    for(var i=0;i<arrText.length;i++){
      arrText[i].disabled = flag;
    }
  }


function changeAmountAction(id) {
  var arrCheck=document.getElementsByName("checkList[]");
  for(var i=0;i<arrCheck.length;i++){
    arrCheck[i].disabled="disabled";
    if(id==arrCheck[i].value) arrCheck[i].checked=true;
  }
  document.getElementById("saveBtn").disabled=false;
}

  $(document).ready(function() {
    $("#filtr_kd").ForceNumericOnly();
    $("#filtr_kdmo").ForceNumericOnly();
  });

  function chacheCheck(id){

    var  chDead =  document.getElementById('ch_'+id);
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].value==id){
        arrCheck[i].checked=true;
        document.getElementById(id).className="changeData";
        var flag = ((chDead.checked)? true:false);
        document.getElementById('li_'+id).disabled=flag;
      }
    }
    checkButton();
  }

  function checkButton() {
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].checked)
        cnt++;
    }
    var flag=true;
    if(cnt==0)
    {
      flag=false;
      document.getElementById("saveBtn").disabled=true;
      document.getElementById("addBtn").disabled=false;
    }else{
      document.getElementById("saveBtn").disabled=false;
      document.getElementById("addBtn").disabled=true;
    }
  }
  function chacheCheck(){
    var arrText=document.getElementsByClassName("amo");
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].checked)
        cnt++;
    }
    var flag=true;
    if(cnt==0)
    {
      flag=false;
      document.getElementById("delBtn").disabled=true;
      document.getElementById("addBtn").disabled=false;
    }else{
      document.getElementById("delBtn").disabled=false;
      document.getElementById("addBtn").disabled=true;
    }

    for(var i=0;i<arrText.length;i++){
      arrText[i].disabled = flag;
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

        <h2>Акт редагування </h2>
        <form name="adminForm" action="act_change.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
          <input type="hidden" id ="kveds" name="kveds" <? echo "value='".$filtr_Kveds."'"; ?> />
          <input type="hidden" id ="kises" name="kises" <? echo "value='".$filtr_Kises."'"; ?> />
          <div class="item_blue" style="position: relative; width: 770px; left: 50%; margin-left: -335px;">
            <div id='errorM' style='display="none";margin-left:15%;'>	</div>
            <h2 style="text-align:center;" >Пошук актів по параметрам</h2>
            <p class="act_add">
              <span>Коду ЄДРПОУ <input type="text" maxlength="8" placeholder="ЄДРПОУ" id="kd" name="kd" onchange="searhOrg();" style="width:90px;" value="<? echo $filtr_kd; ?>" /> </span>
              <span>Коду КДМО <input type="text" placeholder="КДМО" maxlength="12" id="kdmo" name="kdmo" onchange="searhOrg();" style="width:125px;" value="<? echo $filtr_kdmo; ?>" />
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
                <th rowspan="2">Тип акту</th>
                <th rowspan="2">Галузевий відділ</th>
                <th rowspan="2">Адреса складання</th>
              </tr>
              <tr class="second_level">
                <th width=170px> складання акту</th>
                <th width=170px>ліквідації по рішенню суду</th>
              </tr>
              <? foreach ($ListResult as $key => $value) {
                echo "<tr name=\"tablo[]\" id=\"".$value['id']."\">";
                echo "<td style =\" overflow:visible;\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\"".$value["id"]."\" onchange=\"chacheCheck()\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kd"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["kdmo"]."</td>";
                echo "<td style =\" overflow:hidden;\" ><input class=\"test\" type=\"text\" id=\"dT_".$value['id']."\" name=\"textTest[".$value['id']."]\" style=\"text-align:center;width:100px;\" value =\"".$value['da']."\" onchange=\"changeAmountAction('".$value['id']."')\"".$filtr_dateTest."\"/></td>";
                echo "<td style =\" overflow:hidden;\" ><input class =\"test1\" type=\"text\" id=\"dT1_".$value['id']."\" name=\"textTest1[".$value['id']."]\" style=\"text-align:center;width:100px;\" value =\"".$value['dl']."\" onchange=\"changeAmountAction('".$value['id']."')\"".$filtr_dateTest1."\"/></td>";
                echo "<td style =\" overflow:hidden;\" ><input class=\"amo\" type=\"text\" id=\"".$value['id']."\" name=\"textRnl[".$value['id']."]\" style=\"text-align:center;width:120px;\" value =\"".$value['rnl']."\" onchange=\"changeAmountAction('".$value['id']."')\"/></td>";
                // echo "<td style =\" overflow:hidden;\" >".$value["types"]."</td>";
                echo "<td style =\" overflow:hidden;\" ><select id=\"".$value['id']."\" name=\"typeSelect[".$value['id']."]\"style=width:180px \" onchange=\"changeAmountAction('".$value['id']."')\" ".$html_type."</select></td>";
                echo "<td style =\" overflow:hidden;\" ><select id=\"li_".$value['id']."\" name=\"depSelect[".$value['id']."]\" style=width:200px \" onchange=\"changeAmountAction('".$value['id']."')\">".$value["dep"]."</select></td>";
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
