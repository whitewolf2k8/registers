<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<title>���� � �����</title>
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">
<script src="../../../js/jquery-1.7.2.js"></script>
<script type="text/javascript">
	function submitForm(mode) {
		correct = true;
		form = document.forms['adminForm'];
		document.getElementById('errorMes').className="" ;
		document.getElementById('errorMes').display="none";
		document.getElementById('errorMes').innerHTML="";
		form.login.className = '';
		form.password.className = '';
		if (((/^\s+$/.test(form.login.value))||form.login.value==""||form.login.value=="����")||((/^\s+$/.test(form.pwd.value))||form.pwd.value==""||form.pwd.value=="������")) {
			correct = false;
			text='';
			if((/^\s+$/.test(form.login.value))||form.login.value==""||form.login.value=="����"){
				text+=' - ������ ��� ����; <br>'
				if((/^\s+$/.test(form.login.value))){
					form.login.value="����";
				}
				form.login.className = 'focused';
			}
			if((/^\s+$/.test(form.pwd.value))||form.password.value==""||form.password.value=="������"){
				text+=' - ������ ��� ������;';
				if((/^\s+$/.test(form.pwd.value))){
					form.pwd.value="������";
				}
				form.password.className = 'focused';
			}
			document.getElementById('errorMes').className="error" ;
			document.getElementById('errorMes').innerHTML="<p>����� ���� �� ������� ��������� ���� ����� :</p>"+text;
		}
		if (correct) {
			form.mode.value = mode;
			form.submit();
		}
	}

	$(document).ready(function(){
				 $("#my_name").keypress(function(e){
					 if(e.keyCode==13){
					 //������ ������� enter - ����� ��� ���
					 }
				 });

			 });

		jQuery.fn.ForceEnter =
		function()
		{
		 $(this).keyup(function(event){
			 if(event.keyCode == 13){
				 submitForm('');

			 }
		 });
		}


	$(document).ready(function() {
		$("#login").ForceEnter();
		$("#pwd").ForceEnter();
	});

</script>
</head>

<body>
	<div id='errorMes' display="none" <? if(isset($errorMes)){echo "class='error'";}?> >
		<label for="er"><? echo (isset($errorMes)?"<p>$errorMes</p>":""); ?></label>
	</div>
	<form name="adminForm" id="adminForm" action="index.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="mode" />
		<div class="containerLogin">
			<h2>��� ��� ����� <br> "����� �����������"</h2>
      <fieldset>
      	<p><label for="login">����:</label></p>
      	<p><input type="text" name='login' id="login"<?echo ($login!='')?('value="'.$login.'"'):('value="����"') ?>  onBlur="if(this.value=='')this.value='����'" onFocus="if(this.value=='����')this.value=''"></p>
				<p><label for="pwd">������:</label></p>
      	<p><input type="password" name='password' id="pwd"<?echo ($password!='')?('value="'.$password.'"'):('value="������"') ?> onBlur="if(this.value=='')this.value='������'" onFocus="if(this.value=='������')this.value=''"></p>
      	<p><input type="button"  onclick="submitForm('')" value="��������������"></p>
			</fieldset>
		</div>
  </form>
</body>
</html>
