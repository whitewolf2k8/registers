<div id="mainfoter">
      <h1><? echo $_header; ?></h1>
</div>

<div id="infolist">
      <p class="leftSide">�� ������������� ��:<font style="font-weight:bold;"> <? echo $_SESSION['name']." ( ".$typeUsers[$_SESSION[type]]." )"; ?></font></p>
      <p class="rightSide">������� ����: <font style="font-weight:bold;"><? echo date("m.d.y");?> </font> </p>
</div>

<div id=menu>
<ul id="nav">
    <li class="top">
      <a href="index.php" class="top_link">
        <span>�� �������</span>
      </a>
    </li>

    <li class="top">
      <a id="" class="top_link">
        <span class="down">����� ���</span>
      </a>
        <ul class="sub">
          <li>
            <a href="load_arm.php">������������ ���</a>
          </li>
          <li><a href="" class="fly">������������ ����������</a>
              <ul>
                  <li><a href="load_amount_pv.php">� 1-��</a></li>
                  <li><a href="load_region.php">� �������</a></li>
              </ul>
          </li>
          <li class="mid"><a href="load_list.php">��������� �������������</a></li>
          <li>
            <a href="" class="fly">��� ����������?</a>
              <ul>
                <li>
                  <a href="������">�����</a>
                </li>
                  <li>
                    <a href="������" class="fly">�������� �����</a>
                   <ul>
                       <li>
                        <a href="������">�����</a>
                       </li>
                  <li><a href="������">�������� ��� ���-����</a></li>
                  <li><a href="������">��������</a></li>
                  <li><a href="������">����</a></li>
                  <li><a href="������">������</a></li>
                  <li><a href="������">������</a></li>
                  <li><a href="������">�������</a></li>
                  <li><a href="������">������</a></li>
                  <li><a href="������">���������</a></li>
                  <li><a href="������">�������</a></li>
                        <li><a href="������">Tro lo lo </a></li>
              </ul>
                                                                        </li>
              <li><a href="������" class="fly">��������� ��������</a>
              <ul>
                  <li><a href="������">��������</a></li>
                  <li><a href="������">��������</a></li>
                  <li><a href="������">�������</a></li>
              </ul>
                                                                       </li>

              <li><a href="������" class="fly">�������� �������</a>
              <ul>
                  <li><a href="������">��������</a></li>
                  <li><a href="������">��������</a></li>
                  <li><a href="������">�������</a></li>
                  <li><a href="������">���������</a></li>
              </ul>
                                                                       </li>
              <li><a href="������" class="fly">HTML-������</a>
              <ul>
                  <li><a href="������">�������</a></li>
                  <li><a href="������">���-�����</a></li>
              </ul>
                                                                       </li>
          </ul>
      </li>
      <li class="mid"><a href="������">���������</a>
      </li>

      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">��������</span></a>
      <ul class="sub">
      <li><a href="load_kved.php">���� 2010</a></li>
      <li><a href="load_kise.php">KICE 2014</a></li>

      <li><a href="" class="fly">�������</a>
          <ul>
              <li><a href="load_koatuu.php">KOATUU</a></li>
              <li><a href="load_region.php">������</a></li>
          </ul>
      </li>
      <li><a href="load_opf.php">���</a></li>
      <li><a href="load_management.php">������ ���������</a></li>
      <li><a href="department.php">³����</a></li>
      <li><a href="manegers.php">��������</a></li>
        <li><a href="������" class="fly">�������</a>
          <ul>
              <li><a href="������">�����</a></li>
              <li><a href="������">�����</a></li>
              <li><a href="������">��������</a></li>
              <li><a href="������">�������</a></li>
              <li><a href="������">��������</a></li>
          </ul>
        </li>
    </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">����</span></a>
      <ul class="sub">
      <li><a href="act_process.php">��� ��������</a></li>
      <li><a href="act_show.php">��� �����</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">������ ������</span></a>
      <ul class="sub">
      <li><a href="������">��������</a></li>
      <li><a href="������">�����������</a></li>
      <li><a href="">���������� ������</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">������</span></a>
      <ul class="sub">
      <li><a href="������">����������</a></li>
      <li><a href="������">��������</a></li>
      <li><a href="������">�������</a></li>
      </ul>
  </li>
    <li class="top_l">
      <a href="../../lib/logout.php" class="top_li">
        <span>�����</span>
      </a>
    </li>
  </ul>
</div>
