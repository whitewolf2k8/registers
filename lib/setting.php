<?
  $bdusername="admin";
  $bdpassword="Cgfccrfz75";
  $bdname="reestrator";

  $_header = 'Online-����� "����� �����������"';
  $_footer = '� ������� ��������� ���������� � ����������� ������, 2015-2016';
  $typeUsers = array(
    0 => "Root",
    1 => "�������������",
    2 => "����������");

  $typeAct = array(
    '2' =>"������ ��� �����������",
    '3' =>"��� �������� � ���������� ����� ������������� ���",
    '8' =>"������ ��� ��������",
    '1' =>"��� �������� ���� ������������ ����������",
    '4' =>"��� �������� � ���������� ���������� ����",
    '5' =>"���������� �����");

  $fildListDb=array(array('nu'=>"KD",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"���������������� ��� ������"),
    array('nu'=>"KDMO",'typeL'=>"number",'typeS'=>'N','len'=>12,'lenAftedot'=>0,'de'=>"���������������� ��� ������ ��������"),
    array('nu'=>"KDG",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"��� ��������� ����������"),
    array('nu'=>"NU",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"������������ ���\'����"),
    array('nu'=>"PK",'typeL'=>"character",'typeS'=>'C','len'=>45,'de'=>"������� ��������"),
    array('nu'=>"TE",'typeL'=>"number",'typeS'=>'N','len'=>10,'lenAftedot'=>0,'de'=>"��� ������� �� ������"),
    array('nu'=>"TEA",'typeL'=>"number",'typeS'=>'N','len'=>5,'lenAftedot'=>0,'de'=>"������������� ������������ ������������"),
    array('nu'=>"PI",'typeL'=>"number",'typeS'=>'N','len'=>6,'lenAftedot'=>0,'de'=>"�������� ������"),
    array('nu'=>"AD",'typeL'=>"character",'typeS'=>'C','len'=>150,'de'=>"������"),
    array('nu'=>"PF",'typeL'=>"number",'typeS'=>'N','len'=>3,'lenAftedot'=>0,'de'=>"��� ������������ ������� �����"),
    array('nu'=>"GU",'typeL'=>"number",'typeS'=>'N','len'=>5,'lenAftedot'=>0,'de'=>"��� ������ ���������"),
    array('nu'=>"UO",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"������ �����"),
    array('nu'=>"RN",'typeL'=>"character",'typeS'=>'N','len'=>17,'de'=>"����� �������� ����������� 䳿"),
    array('nu'=>"DR",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"���� ������������ �� "),
    array('nu'=>"DZ",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"���� �������� ��� �� ������"),
    array('nu'=>"PR",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"���"),
    array('nu'=>"OS",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"����� ���������"),
    array('nu'=>"RIK",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"���� �������� ���������"),
    array('nu'=>"SN",'typeL'=>"character",'typeS'=>'C','len'=>17,'de'=>"����� �������� ���������"),
    array('nu'=>"DL",'typeL'=>"number",'typeS'=>'N','len'=>8,'lenAftedot'=>0,'de'=>"���� ��������"),
    array('nu'=>"KISE",'typeL'=>"number",'typeS'=>'N','len'=>2,'lenAftedot'=>0,'de'=>"������������� ������ ��������"),
    array('nu'=>"IZ",'typeL'=>"number",'typeS'=>'N','len'=>1,'lenAftedot'=>0,'de'=>"������ �������� ���������� ����������"),
    array('nu'=>"E1_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"�������� ������",'de'=>"��� ���� �������� 1 �� ����2010"),
    array('nu'=>"NE1_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 1 �� ����2010"),
    array('nu'=>"E2_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���� �������� 2 �� ����2010"),
    array('nu'=>"NE2_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 2 �� ����2010"),
    array('nu'=>"E3_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���� �������� 3 �� ����2010"),
    array('nu'=>"NE3_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 3 �� ����2010"),
    array('nu'=>"E4_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���� �������� 4 �� ����2010"),
    array('nu'=>"NE4_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 4 �� ����2010"),
    array('nu'=>"E5_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���� �������� 5 �� ����2010"),
    array('nu'=>"NE5_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 5 �� ����2010"),
    array('nu'=>"E6_10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���� �������� 6 �� ����2010"),
    array('nu'=>"NE6_10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"����� ���� �������� 6 �� ����2010"),
    array('nu'=>"VDF10",'typeL'=>"character",'typeS'=>'C','len'=>5,'de'=>"��� ���������� ���� �������� �� ����2010"),
    array('nu'=>"NVDF10",'typeL'=>"character",'typeS'=>'C','len'=>250,'de'=>"��� ���������� ����� ���� �������� �� ����2010"), );

?>
