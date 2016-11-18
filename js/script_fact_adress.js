


  function showHide(element_id) {
    if (document.getElementById(element_id)) {
        var obj = document.getElementById(element_id);
          if (obj.style.display != "block") {
          obj.style.display = "block"; //Показываем элемент
        }
        else obj.style.display = "none"; //Скрываем элемент
    }
    else alert("Элемент с id: " + element_id + " не найден!");
  }

  function formListRay(arr,idRay, idElement) {
    var arrSize=count(arr);
      var x = document.getElementById(idElement);
        if(x.getAttribute("disabled")){
          x.removeAttribute("disabled");
        }
        x.setAttribute("disabled","disabled");
        x.innerHTML = "";
        var opt = document.createElement('option');
        opt.value = "";
        opt.innerHTML = "- Всі -";
        if(idRay==""){
          opt.selected = true;
        }
        x.appendChild(opt);
      for(var i = 0; i < arrSize; i++)
      {
        var opt = document.createElement('option');
        opt.value = arr[i].kod;
        opt.innerHTML = arr[i].nu;
        if(idRay==arr[i].kod){
          opt.selected = true;
        }
        x.appendChild(opt);
      }
      if(x.getAttribute("disabled")){
        x.removeAttribute("disabled");
      }
  }

  function formListTea(arr,te, idElement) {
    var arrSize=count(arr);
      var x = document.getElementById(idElement);
      if(!x.getAttribute("disabled")){
        x.setAttribute("disabled","disabled");
      }

      x.innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      opt.innerHTML = "- Всі -";
      if(te==""){
        opt.selected = true;
      }
      x.appendChild(opt);

      for(var i = 0; i < arrSize; i++)
      {
        var opt = document.createElement('option');
        opt.value = arr[i].te;
        opt.innerHTML = arr[i].nu;
        if(te==arr[i].te){
          opt.selected = true;
        }
        x.appendChild(opt);
      }
      if(x.getAttribute("disabled")){
        x.removeAttribute("disabled");
      }
  }

  function formListObl(arr,idObl, idElement) {
    var arrSize=count(arr);
      var x = document.getElementById(idElement);
      if(!x.getAttribute("disabled")){
        x.setAttribute("disabled","disabled");
      }

      x.innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      if(idObl==""){
        opt.selected = true;
      }
      opt.innerHTML = "- Всі -";
      x.appendChild(opt);

      for(var i = 0; i < arrSize; i++)
      {
        var opt = document.createElement('option');
        opt.value = arr[i].reg;
        opt.innerHTML = arr[i].nu;
        if(idObl==arr[i].reg){
          opt.selected = true;
        }
        x.appendChild(opt);
      }
      if(x.getAttribute("disabled")){
        x.removeAttribute("disabled");
      }
  }

  function updateLists(mode,idRay,id) {
    if(mode!="")
    {
      $.ajax({
       type: "POST",
       url: "script\\order.php",
       data: {id:mode},
       scriptCharset: "CP1251",
       success: function(data){
           var res = JSON.parse(data);
           formListRay(res,idRay,id); // распарсим JSON
        }
     });
    }else{
      var x = document.getElementById(id);
      x.innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      opt.innerHTML = "- Всі -";
      x.appendChild(opt);
      x.setAttribute("disabled","disabled");
      if(id=="ray_add"){
        generateTeLists("","","","ter_add");
      }else{
        generateTeLists("","","","ter_ch");
      }

    }
  }

  function generateObLists(mode,id) {
    $.ajax({
       type: "POST",
       url: "script\\order_obl.php",
       data: {id:mode},
       scriptCharset: "CP1251",
       success: function(data){
           var res = JSON.parse(data);
           formListObl(res,mode,id); // распарсим JSON
        }
    });
  }


  function generateTeLists(mode,obl,ray,id) {
    if(mode!="")
    {
      if(ray!=""){
        $.ajax({
         type: "POST",
         url: "script\\processTea.php",
         data: {ob:obl,ra:ray},
         scriptCharset: "CP1251",
         success: function(data){
             var res = JSON.parse(data);
             formListTea(res,mode,id); // распарсим JSON
          }
       });
      }else{
        var x=document.getElementById(id);
          x.innerHTML = "";
        var opt = document.createElement('option');
        opt.value = "";
        opt.innerHTML = "- Всі -";
        x.appendChild(opt);
        if(!x.getAttribute("disabled")){
          x.setAttribute("disabled","disabled");
        }
      }
    }else{
      var x=document.getElementById(id);
        x.innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      opt.innerHTML = "- Всі -";
      x.appendChild(opt);
      if(!x.getAttribute("disabled")){
        x.setAttribute("disabled","disabled");
      }
    }
  }



  function callAddWindow(mod,idC)
  {
    if(mod=="add"){
      generateObLists("",'obl_add');
      updateLists("","",'ray_add');
      generateTeLists("","","",'ter_add');
      showHide('add_adress');
    }else if (mod=="change") {
      $.ajax({
       type: "POST",
       url: "script\\processAdress.php",
       data: {action:"get",id:idC},
       scriptCharset: "CP1251",
       success: function(data){
          var res = JSON.parse(data);
          genDataChenge(res);
        }
      });
    }else if(mod=="del"){
      if (confirm("Видалити дану адресу?")) {
        $.ajax({
         type: "POST",
         url: "script\\processAdress.php",
         data: {action:mod,id:idC},
         scriptCharset: "CP1251",
         success: function(data){
            var res = JSON.parse(data);
            updateAdress(res);
            showHide('change_adress');
          }
        });
      }
    }else if(mod=="save"){
      var err = checkChange();
      if(err==""){
        var obl = document.getElementById("obl_ch");
        var ray = document.getElementById("ray_ch");
        var tea = document.getElementById("ter_ch");
        var postCod = document.getElementById("postCodeCh");
        var adres = document.getElementById("adressAddCh");
        $.ajax({
         type: "POST",
         url: "script\\processAdress.php",
         data: {action:"change", ob:obl.options[obl.selectedIndex].value, ra:ray.options[ray.selectedIndex].value, te:tea.options[tea.selectedIndex].value, pi:postCod.value, ad:adres.value, id:idC},
         scriptCharset: "CP1251",
         success: function(data){
            var res = JSON.parse(data);
              postCod.value="";
              adres.value="";
              showHide('change_adress');
              updateAdress(res);
          }
       });
    }
  }
}

  function genDataChenge(arr){
    var obl=arr[0].obl;
    var ray=arr[0].ray;
    var tea=arr[0].tea;
    var idRow =arr[0].id;

    generateObLists(obl,'obl_ch');
    updateLists(obl,ray,'ray_ch');
    generateTeLists(tea,obl,ray,'ter_ch');
    var postCod = document.getElementById("postCodeCh");
    var adres = document.getElementById("adressAddCh");
    var btDel = document.getElementById("btDel");
    var btSave = document.getElementById("btChange");
    postCod.value=arr[0].pi;
    adres.value=arr[0].ad;
    btDel.onclick=function() { callAddWindow("del",idRow); };
    btSave.onclick=function() { callAddWindow("save",idRow); };
    showHide('change_adress');
  }

    function updateAdress(arr){
      var arrSize=count(arr);
      var x=document.getElementById("ur_adres");
      x.innerHTML = "";
      for(var i = 0; i < arrSize; i++)
      {
        x.innerHTML += "<p><text > - Код території(повний/короткий):"+arr[i].tea+"/"+
            +arr[i].te+", адреса : "+arr[i].pi+","+arr[i].ad+"</text>"
            +"<input type=\"button\" class=\"btn_edit\" onclick=\"callAddWindow('change',"+arr[i].id+");\" /></p>";
      }
    }

    function addAdres(mode,idOrg){
      if(mode=="add"){
        var err = checkAdd();
        if(err==""){
          var obl = document.getElementById("obl_add");
          var ray = document.getElementById("ray_add");
          var tea = document.getElementById("ter_add");
          var postCod = document.getElementById("postCode");
          var adres = document.getElementById("adressAdd");
          $.ajax({
           type: "POST",
           url: "script\\processAdress.php",
           data: {action:mode, ob:obl.options[obl.selectedIndex].value, ra:ray.options[ray.selectedIndex].value, te:tea.options[tea.selectedIndex].value, pi:postCod.value, ad:adres.value, org:idOrg},
           scriptCharset: "CP1251",
           success: function(data){
              var res = JSON.parse(data);
                postCod.value="";
                adres.value="";
                showHide('add_adress');
                updateAdress(res);
            }
         });
        }else{
          var  erAdd = document.getElementById("errorMesAdd");
            erAdd.innerHTML = "";
            erAdd.innerHTML = "<p class=\"error\">"+err+"</p>   <div class=\"clr\"></div>";
        }
      }
    }

    function getIndexObl(id){
      var x = document.getElementById(id);
      return x.options[x.selectedIndex].value;
    }

    function checkAdd(){
      var err="";
      var obl = document.getElementById("obl_add");
      var ray = document.getElementById("ray_add");
      var tea = document.getElementById("ter_add");
      var postCod = document.getElementById("postCode");
      var adres = document.getElementById("adressAdd");
      if(obl.options[obl.selectedIndex].value!=""){
        if(ray.options[ray.selectedIndex].value=="") {
          err+="Оберіть район<br/>";
        }else if (tea.options[tea.selectedIndex].value=="") {
          err+="Оберіть місто/село <br/>";
        }
      }else{
        err+="Оберіть область<br/>";
      }

      if(postCod.value==""){
        err+="Заповніть поле поштовий індекс<br/>";
      }
      if(adres.value==""){
        err+="Заповніть поле адреса<br/>";
      }
      return err;
    }

    function checkChange(){
      var err="";
      var obl = document.getElementById("obl_ch");
      var ray = document.getElementById("ray_ch");
      var tea = document.getElementById("ter_ch");
      var postCod = document.getElementById("postCodeCh");
      var adres = document.getElementById("adressAddCh");
      if(obl.options[obl.selectedIndex].value!=""){
        if(ray.options[ray.selectedIndex].value=="") {
          err+="Оберіть район<br/>";
        }else if (tea.options[tea.selectedIndex].value=="") {
          err+="Оберіть місто/село <br/>";
        }
      }else{
        err+="Оберіть область<br/>";
      }

      if(postCod.value==""){
        err+="Заповніть поле поштовий індекс<br/>";
      }
      if(adres.value==""){
        err+="Заповніть поле адреса<br/>";
      }
      return err;
    }

    function  contacAdd(id) {
      showHide(id);
    }

    function addContact(id_org){
      var type=document.getElementById("type_contact");
      var data=document.getElementById("contactData");
      if(data.value==""){
        var x=document.getElementById("errorMesCon");
        x.innerHTML="";
        x.innerHTML = "<p class=\"error\"> Необхідно ввести дані !</p>   <div class=\"clr\"></div>";
      }else{
        contactProcess("add","",id_org,data.value,type.options[type.selectedIndex].value);
      }
    }

    function contactProcess(mode,id,id_org,data,type){
      if(mode=="add"){
        $.ajax({
         type: "POST",
         url: "script\\processContact.php",
         data: {action:mode, org:id_org, d:data, t:type},
         scriptCharset: "CP1251",
         success: function(data){
            var res = JSON.parse(data);
            updateContact(res);
            var type=document.getElementById("type_contact");
            var data=document.getElementById("contactData");
            data.value="";
            type.selectedIndex=0;
            showHide('contactAdd');
          }
        });
      }else if(mode=="edit"){
        $.ajax({
         type: "POST",
         url: "script\\processContact.php",
         data: {action:mode,idR:id, org:id_org, d:data, t:type},
         scriptCharset: "CP1251",
         success: function(data){
            var res = JSON.parse(data);
            updateContact(res);
            showHide('contactChange');
          }
        });
      }else if(mode=="del"){
        $.ajax({
         type: "POST",
         url: "script\\processContact.php",
         data: {action:mode,idR:id, org:id_org},
         scriptCharset: "CP1251",
         success: function(data){
            var res = JSON.parse(data);
            updateContact(res);
            showHide('contactChange');
          }
        });
      }
    }

    function contactChange(id,id_org,data,type) {
      var dataE=document.getElementById("contactDataCh");
      var typeE=document.getElementById("typeC");
      var btCh=document.getElementById("btContactCh");
      var btDel=document.getElementById("btContactDel");

      switch (type) {
        case 0:
          typeE.innerHTML="<p>Тип контакту \"Телефон\" </p>";
          break;
        case 1:
          typeE.innerHTML="<p>Тип контакту \"Факс\" </p>";
          break;
        case 2:
          typeE.innerHTML="<p>Тип контакту \"Email\" </p>";;
          break;
      }
      dataE.value=data;
      btCh.onclick=function() {
        if(dataE.value!=""){
          contactProcess("edit",id,id_org,dataE.value,type);
        }else{
          var x=document.getElementById("errorMesCon");
          x.innerHTML="";
          x.innerHTML = "<p class=\"error\"> Необхідно ввести дані !</p>   <div class=\"clr\"></div>";

        } };
      btDel.onclick=function() {
        if (confirm("Видалити даний контакт?")){
          contactProcess("del",id,id_org,dataE.value,type);
        } };
      showHide("contactChange");
    }

    function updateContact(arr) {
      var arrSize=count(arr);
      var x=document.getElementById("contact");
      x.innerHTML = "";
      var c=0;
      var text="";
      for(var i = 0; i < arrSize; i++)
      {
        if(c==3){
          x.innerHTML +="<p>"+text+"</p>";
          c=0;
          text="";
        }
        switch (arr[i].type) {
          case '0':
            text += "<text>Телефон: "+arr[i].data+";</text>"
              +"<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange("+arr[i].id+","+arr[i].id_org+",'"+arr[i].data+"',"+arr[i].type+");\" />";
            break;
          case '1':
            text += "<text>Факс:  "+arr[i].data+";</text>"
              +"<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange("+arr[i].id+","+arr[i].id_org+",'"+arr[i].data+"',"+arr[i].type+");\" />";
            break;
          case '2':
            text += "<text>Email:  "+arr[i].data+";</text>"
              +"<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange("+arr[i].id+","+arr[i].id_org+",'"+arr[i].data+"',"+arr[i].type+");\" />";
            break;
        }
        c+=1;
      }
      if(text!=""){
        x.innerHTML +="<p>"+text+"</p>";
      }

    }
