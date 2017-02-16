<?
	require_once("list_function.php");

  function connectingDb()
  {
    global $bdusername, $bdpassword, $bdname;
    $link = new mysqli('localhost', $bdusername , $bdpassword, $bdname);
    if (!$link) {
        die('Ошибка подключения (' . mysqli_connect_errno() . ') ');
    }
    return $link;
  }

  function closeConnect($link)
  {
    mysqli_close($link);
  }

  function checkUser($link, $username, $password)
  {
    $query = "SELECT id,login,locathion,type FROM `users` WHERE `login`=? and `pass`=?";
    $stmt = mysqli_stmt_init($link);
    if(!mysqli_stmt_prepare($stmt, $query))
    {
      echo "Ошибка подготовки запроса\n";
    }
    else
    {
      mysqli_stmt_bind_param($stmt, "ss", $val1, $val2);
      $val1 = $username;
      $val2 = md5($password);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)>0)
      {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
          $res=$row;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        return $res;
      }else{
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        return false;
      }
    }
  }


  function checkExistsLogin($link, $login)
  {
    $query="SELECT * FROM `users` WHERE `login`= '$login'";
    $result = mysqli_query($link,$query);
      if ($result){
      if(($result->num_rows)>0)
      {
        return true;
      }else{
        return false;
      }
      mysqli_free_result($result);
    }
    return false;
  }

  function changeCodingPage($string)
  {
		$enc=((mb_detect_encoding($string)==false)?"cp866":mb_detect_encoding($string));
		if($enc!="cp866"){
			$result=$string;
			$result=replace_symvol($result,"ї","Є","є");
			$result=replace_symvol($result,"ў","І","і");
			$result=replace_symvol($result,"Ў","i","І");
			$result=replace_symvol($result,"°","Ї","ї");
			$result=replace_symvol($result,"•","Ї","ї");
			return  $result;
		}else{
					$result=$string;
					$result=replace_symvol($result,"ї","Є","є");
					$result=replace_symvol($result,"ў","І","і");
					$result=replace_symvol($result,"Ў","i","І");
					$result=replace_symvol($result,"°","Ї","ї");
					$result=replace_symvol($result,"•","Ї","ї");
					return $result;
		}
	}

	function isCyrilic($text) {
	    return preg_match('/[А-Яа-яЁёЇїҐґ0-9]/', $text);
	}
  function changeCodingPageShort($string)
  {
    $result= iconv("ibm866", "Windows-1251//TRANSLIT",  $string);
    return $result;
  }

  function replace_symvol($string,$sherch, $replaceU, $replaceL ){
    $result=$string;
    $pos=stripos($result, $sherch);
    while ($pos!==false){
			if("°"==$sherch||"•"==$sherch){
				$s="";
				if($pos==0){
					$s=$replaceU;
				}else{
					$s=(ctype_upper(substr($result, $pos-1,1))?$replaceU:$replaceL);
				}
			}else{
				$replace=((substr($result, $pos,1)!==$sherch)?$replaceU:$replaceL);
			}
      $result=substr_replace($result,$replace,$pos,1);
      $pos=stripos($result, $sherch);
    }
    return $result;
  }

  function calcTimeRun($startTime,$endTime){
    $time=$endTime-$startTime;
    $hours = floor($time/3600);
    $minutes = floor(($time/3600 - $hours)*60);
    $seconds =ceil(((($time/3600 - $hours)*60) - floor(($time/3600 - $hours)*60))*60);
    return "<br> Виконання скрипта зайняло  $hours годин $minutes хвилин $seconds секунд";
  }

	function formatKodKved10($string){
		//$countChar=iconv_strlen($string, "Windows-1251");
		$string=str_replace(" ","",$string);
		$result="";
		switch (iconv_strlen($string, "Windows-1251")) {
    	case 1:
					if(preg_match("/\d/", $string)){
						return "0".$string."   ";
					}
					return errorMesKodKved10();
        	break;
    	case 2:
					if(preg_match("/\d\./", $string)){
						return "0".substr($string, 0, -1)."   ";
					}
					if(preg_match("/\d\d/", $string)){
						return $string."   ";
					}
					return errorMesKodKved10();
        	break;
			case 3:
					if(preg_match("/\d\d\./", $string)){
						return substr($string, 0, -1)."   ";
					}
					if(preg_match("/\d\.\d/", $string)){
						return "0".$string." ";
					}
					return errorMesKodKved10();
    			break;
			case 4:
					if(preg_match("/\d\d\.\d/", $string)){
						return $string." ";
					}
					if(preg_match("/\d\.\d\d/", $string)){
						return "0".$string;
					}
					return errorMesKodKved10();
        	break;
			case 5:
					if(preg_match("/\d\d\.\d\d/", $string)){
						return $string;
					}else{
							return errorMesKodKved10();
					}
        	break;
			default:
	        return errorMesKodKved10();
					break;
		}
	}
	function errorMesKodKved10(){
		return "Введений код КВЕД не відповідає шаюлону чч.чч. Неможливо виконати пошук.";
	}

	function formatKdKise14($string){
		$string=str_replace(" ","",$string);
		$result="";
		switch (iconv_strlen($string, "Windows-1251")) {
    	case 4:
					if(preg_match("/\d\d\d\d/", $string)){
						return $string;
					}
					return "Введене чило не відповідає формату чччч";
        	break;
			case 1:
					if($string==0){
						return $string;
					}
					return "Введене чило не відповідає формату чччч";
					break;

			default:
	        return "Введене чило не відповідає формату чччч";
					break;
		}
	}
	function formatKodKise14($string){
		$string=str_replace(" ","",$string);
		$result="";
		$errorM= "Введене чило не відповідає формату S.ччччч";
		switch (iconv_strlen($string, "Windows-1251")) {
			case 3:
					if(preg_match("/S\.\d/", $string)){
						return $string."     ";
					}
					return $errorM;
					break;

			case 4:
					if(preg_match("/S\.\d\d/", $string)){
						return $string."    ";
					}
					return $errorM;
					break;
			case 5:
					if(preg_match("/S\.\d\d\d/", $string)){
						return $string."   ";
					}
			case 6:
					if(preg_match("/S\.\d\d\d\d/", $string)){
						return $string."  ";
					}
			case 7:
					if(preg_match("/S\.\d\d\d\d\d/", $string)){
						return $string." ";
					}
					return $errorM;
					break;
			case 8:
					if(preg_match("/S\.\d\d\d\d\d\d/", $string)){
						return $string;
					}
					return $errorM;
					break;
			default:
				return $errorM;
				break;

		}
	}



	function getPaginator($total,$count=10,$now){
		$arrayCount= array(0,10,20,30,40,50,100);
		//проверка на нулевое количество страниц в выборе при первой загрузке пагинатора
		$count=($count=="")?50:$count;
		$result.="" ;
		if($count==0){
			$pageCount=round($total/1, 0, PHP_ROUND_HALF_UP);
		}else {
			$pageCount=round($total/$count, 0, PHP_ROUND_HALF_UP);
		}
		$result.="<div class='pagination'><p> В таблицю вибрано ".
		$total." записів. Показати в таблиці по "
			.'<select name="limits" size="1" onchange="submitFormLim(this.value)">';
		foreach($arrayCount as $v) {
			$result .= '<option value="'.$v.'"'.($count==$v ? ' selected="selected"' : '').'>'.($v==0 ? 'Все' : $v).'</option>';
		}
 		$result.= '</select></p>';
		if($total>$count && $count!=0){
				$result.=createListPaginator($total,$count,$now)."</div>";
		}else {
			$result.="</div>";
		}
		return $result;
	}

	function createListPaginator($total,$count=10,$now){
		$result.="";
		if($count!=0){
			$pageCount=ceil($total/$count);
			$currentPage=ceil($now/$count)+1;
			$currentGroup=ceil($currentPage/10);
			for ($i=0; $i < $total ; $i+=$count) {
				$page=ceil($i/$count)+1;
				$group=ceil($page/10);
				if ($currentGroup!=$group) {
					$result.= '<a class="page gradient" href="#" onclick="submitFormLimStart('.$i.');">'.$page.'-'.min($page+9, $pageCount).'</a>';# code...
					$i+=$count*9;
				}else{
					if ($currentPage==$page) {
						$result.="<span class='page active'>".$page."</span>";
					}else {
						$result .= '<a class="page gradient" href="#" onclick="submitFormLimStart('.$i.');">'.$page.'</a>';
					}
				}
			}
		}
		return $result;
	}


	function php2js($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        $a = str_replace(",", ".", strval($a));
      }
      static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
      array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
      return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = php2js($v);
      return '[ ' . join(', ', $result) . ' ]';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = php2js($k).': '.php2js($v);
      return '{ ' . join(', ', $result) . ' }';
    }
  }




	function getTypeAct($arrType,$inputTypes)
	{
		$str="";
		$res=explode (";",$inputTypes);
		foreach ($res as $key => $value) {
			if($value!=""){
				$str.=$arrType[$value].";<br>";
			}
		}
		return $str;
	}

	function getDepartmentNu($link,$id)
	{
		$str="";
		$qeruStr="SELECT * FROM `depatment` WHERE `id`=".$id;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $str=$row['nu'];
      }
			mysqli_free_result($result);
    }
    return $str;
	}

	function dateToDatapiclerFormat($str)
	{
		if($str=="0000-00-00") return "";
		return date("m/d/Y", strtotime($str));
	}

	function dateToSqlFormat($str)
	{
			if($str=="") return "0000-00-00";
			return date('Y-m-d', strtotime(str_replace('-', '/', $str)));
	}

	function getTypsHtml($arrType, $arrInput)
	{
			$result="";
			$count=count($arrInput);

			foreach ($arrInput as $key => $value) {
				if($count<=2 && $value==0 ) {
					$result.="<select name=\"types[]\" style=\"width:150px;\">".getListTypeAct($arrType,$value)."</select>";
				}else if ($value!=0) {
					$result.="<select name=\"types[]\" style=\"width:150px;\">".getListTypeAct($arrType,$value)."</select>";
				}
			}
			return $result;
	}

	function getKvedHtml($link,$arrKved)
	{
		$result="";
		$fields = explode(",", $arrKved);
		foreach ($fields as $key => $value) {
			if($value!=""){
				$res = mysqli_query($link,"SELECT * FROM `kved10` WHERE `id`=".$value);
				$row = mysqli_fetch_assoc($res);
				$result.="<abbr id=\"".$row["id"]."\"  title=\"".$row["nu"]."\">".$row["kod"]."</abbr>"
		    	."<input type=\"button\" id=\"b_".$row["id"]."\" class=\"btn_del\"  onclick=\"delKved('".$row["id"]."');\"/>";
			}
		}
		return $result;
	}

	function getKisedHtml($link,$arrKved)
	{
		$result="";
		$fields = explode(",", $arrKved);
		foreach ($fields as $key => $value) {
			$kd =substr($value,5);
			if($kd!=""){
				$res = mysqli_query($link,"SELECT * FROM `kise14` WHERE `kd`=".$kd);
				$row = mysqli_fetch_assoc($res);
				$result.="<abbr id=\"kise_".$row["kd"]."\"  title=\"".$row["nu"]."\">".$row["kod"]."</abbr>"
				."<input type=\"button\" id=\"kise_b_".$row["kd"]."\" class=\"btn_del\"  onclick=\"delKise('".$row["kd"]."');\"/>";
			}
		}
		return $result;
	}

	function getKveds($link,$strKveds)
	{
		$result=array();
		$fields = explode(",", $strKveds);
		foreach ($fields as $key => $value) {
			if($value!=""){
				$res=mysqli_query($link,"SELECT * FROM `kved10` WHERE id=".$value);
				$row=mysqli_fetch_array($res, MYSQLI_ASSOC);
				$result[]=$row["kod"];
				mysqli_free_result($res);
			}
		}
		return $result;
	}

	function delApostrophe($str){
		return str_replace("'","&#39;",$str);
		//return addslashes(stripslashes(str_replace("'","&#39;",$str)));
	}

	function delSpace($str){
		return str_replace(' ','',$str);
	}

	function setMaxSession($max) {
    if(isset($_SESSION)){
      session_start();
    }
    $_SESSION['max'] = $max;
    session_write_close();
	}


?>
