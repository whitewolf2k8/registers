
  $(document).ready(function() {

    function setDataTest() {
        $('.Ddata').datepicker({showOn: "button",
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
            $('.Ldata').datepicker({showOn: "button",
                      buttonImage: "../../img/cal.gif",
                      showOtherMonths: true, autoSize: true,
                      monthNames:month ,
                      dayNamesMin:days ,
                      changeMonth: true,
                      changeYear: true,
                      yearRange: "-1:+2",
                      monthNamesShort: monthSotr});
        }

    setDataTest('Ddata');
    setDataTest1('Ldata');
    var x=document.getElementsByName('tablo[]');
    for (var i = 0; i < x.length; i++) {
      setDataPoclerFild('dT_'+x[i].id);
      setDataPoclerFild('dT1_'+x[i].id);
    }
    console.log("ready");
    $('.spoiler-body').hide();
    $('.spoiler-title').click(function(){
      $(this).next().slideToggle();
    });
  });

  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];

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

  function changeAmountAction(id) {
    document.getElementById(id).className="changeData";
    var not = document.getElementsByClassName("notactive");
    var arrCheck=document.getElementsByName("checkList[]");
    for(var i=0;i<arrCheck.length;i++){
       if(not.length == 0){
          arrCheck[i].disabled="disabled";
       }
      if(id==arrCheck[i].value) arrCheck[i].checked=true;
      if(document.getElementById(arrCheck[i].value).className == "changeData") arrCheck[i].disabled="";
    }
      document.getElementById("saveBtn").disabled=false;
  }

  function chacheCheck(id){
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;

    var qt = document.getElementsByClassName("changeData");
    var qt1 = document.getElementsByClassName("notactive");

    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].checked){
        cnt++;
      }
      if(qt.length == 0 && qt1.length == 0){
        if(arrCheck[i].value==id){
          if(arrCheck[i].checked){
            document.getElementById(id).className="change";
          }else{
            document.getElementById(id).className="";
            }
          }
        }else{
          if(arrCheck[i].value==id){
            if(arrCheck[i].checked){
              document.getElementById(id).className="changeData";
             }else{
               if (document.getElementById(id).className=="changeData") {
                   document.getElementById(id).className="notactive";
              }
            }
          }
        }
      }
    checkButton();
  }

function checkButton() {
    var arrData=document.getElementsByClassName("ui-datepicker-trigger");
    var arrButt=document.getElementsByClassName("btn_add");
    var arrText=document.getElementsByClassName("amo");
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
    if(arrCheck[i].checked)
      cnt++;
    }

    var flag=true;
    var qr = document.getElementsByClassName("changeData");
    var qr1 = document.getElementsByClassName("notactive");

    if(cnt==0)
    {
        flag=false;
        document.getElementById("saveBtn").disabled=true;
        document.getElementById("delBtn").disabled=true;
    }else{
      if (qr.length > 0 || qr1.length > 0){
      document.getElementById("saveBtn").disabled=false;
      }else{
        document.getElementById("delBtn").disabled=false;
      }
    }
    if (qr.length == 0 && qr1.length == 0) {
      for(var i=0;i<arrText.length;i++){
         arrText[i].disabled = flag;
      }
    }
    if (qr.length == 0 && qr1.length == 0) {
      for(var i=0;i<arrButt.length;i++){
         arrButt[i].disabled = flag;
      }
    }
    if (qr.length == 0 && qr1.length == 0) {
      for(var i=0;i<arrData.length;i++){
         arrData[i].disabled = flag;
      }
    }
  }

  function addTypeSelect(id) {
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'getListType1'},
     scriptCharset: "CP1251",
     success: function(data){
      var res = JSON.parse(data);
      $("#"+id).before("<select class=\"amo\" name=\"typeSelect_"+id.substr(3)+"[]\" style=\"width:180px;\" onchange=\"changeAmountAction("+id.substr(3)+")\">"+res[0]+"</select>");
      }
    });
  }
