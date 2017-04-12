<?
  $bdusername="admin";
  $bdpassword="Cgfccrfz75";
  $bdname="reestrator";

  $_header = 'Online-сервіс "Реєстр респондентів"';
  $_footer = '© Головне управління статистики у Миколаївській області, 2015-2016';
  $typeUsers = array(
    0 => "Root",
    1 => "Администратор",
    2 => "Користувач");

  $typeAct = array(
    '2' =>"рішення про банкрутство",
    '3' =>"акт складено у присутності інших уповноважених осіб",
    '8' =>"рішення про ліквідацію",
    '1' =>"акт складено лише працівниками статистики",
    '4' =>"акт складено у присутності працівників ЖЕКУ",
    '5' =>"повернення листа");

  $fildListDb=array(array('nu'=>"KD",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Ідентифікаційник код ЄДРПОУ"),
    array('nu'=>"KDMO",'typeL'=>"number",'typeS'=>'N','len'=>12,'lenAftedot'=>0,'de'=>"Ідентифікаційник код місцевої одининці"),
    array('nu'=>"KDG",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Код головного підприємства"),
    array('nu'=>"NU",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Найменування суб\'єкту"),
    array('nu'=>"PK",'typeL'=>"character",'typeS'=>'C','len'=>45,'de'=>"Прізвище керівника"),
    array('nu'=>"TE",'typeL'=>"number",'typeS'=>'N','len'=>10,'lenAftedot'=>0,'de'=>"Код території за КОАТУУ"),
    array('nu'=>"TEA",'typeL'=>"number",'typeS'=>'N','len'=>5,'lenAftedot'=>0,'de'=>"Адміністративно територіальна приналежність"),
    array('nu'=>"PI",'typeL'=>"number",'typeS'=>'N','len'=>6,'lenAftedot'=>0,'de'=>"Поштовий індекс"),
    array('nu'=>"AD",'typeL'=>"character",'typeS'=>'C','len'=>150,'de'=>"Адреса"),
    array('nu'=>"PF",'typeL'=>"number",'typeS'=>'N','len'=>3,'lenAftedot'=>0,'de'=>"Код організаційно правової форми"),
    array('nu'=>"GU",'typeL'=>"number",'typeS'=>'N','len'=>5,'lenAftedot'=>0,'de'=>"Код органу управління"),
    array('nu'=>"UO",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"Ознака особи"),
    array('nu'=>"RN",'typeL'=>"character",'typeS'=>'N','len'=>17,'de'=>"Номер останньої реєстраційної дії"),
    array('nu'=>"DR",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Дата реєстраційних дій "),
    array('nu'=>"DZ",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Дата внесення змін до ЄДРПОУ"),
    array('nu'=>"PR",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"Тип"),
    array('nu'=>"OS",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Орган реєстрації"),
    array('nu'=>"RIK",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Дата первинної реєстрації"),
    array('nu'=>"SN",'typeL'=>"character",'typeS'=>'C','len'=>17,'de'=>"Номер первинної реєстрації"),
    array('nu'=>"DL",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"Дата ліквідації"),
    array('nu'=>"KISE",'typeL'=>"number",'typeS'=>'N','len'=>2,'lenAftedot'=>0,'de'=>"Інституційний сектор економіки"),
    array('nu'=>"IZ",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"Ознака наявності іноземного засновника"),
    array('nu'=>"E1_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Поштовий індекс",'de'=>"Код виду діяльності 1 за КВЕД2010"),
    array('nu'=>"NE1_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 1 за КВЕД2010"),
    array('nu'=>"E2_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код виду діяльності 2 за КВЕД2010"),
    array('nu'=>"NE2_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 2 за КВЕД2010"),
    array('nu'=>"E3_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код виду діяльності 3 за КВЕД2010"),
    array('nu'=>"NE3_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 3 за КВЕД2010"),
    array('nu'=>"E4_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код виду діяльності 4 за КВЕД2010"),
    array('nu'=>"NE4_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 4 за КВЕД2010"),
    array('nu'=>"E5_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код виду діяльності 5 за КВЕД2010"),
    array('nu'=>"NE5_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 5 за КВЕД2010"),
    array('nu'=>"E6_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код виду діяльності 6 за КВЕД2010"),
    array('nu'=>"NE6_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Назва виду діяльності 6 за КВЕД2010"),
    array('nu'=>"VDF10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"Код фактичного виду діяльності за КВЕД2010"),
    array('nu'=>"NVDF10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"Код фактичного Назва виду діяльності за КВЕД2010"), );

?>
