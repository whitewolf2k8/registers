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
          <li>

            <a href="load_el_signatures.php">��������� ������</a>
          </li>
          <li>
            <a href="load_bankrut.php">��� ��� ��������</a>
          </li>
          <li><a href="" class="fly">������������ ����������</a>
              <ul>
                  <li><a href="load_amount_pv.php">� 1-��</a></li>
                  <li><a href="load_amount_fin.php">� �������</a></li>
              </ul>
          </li>
          <li class="mid"><a href="load_list.php">��������� �������������</a></li>
          <li class="mid"><a href="load_volator.php">��������� ����������</a></li>
          <li class="mid"><a href="load_stop_activity.php">������������ ��������</a></li>
          <li><a href="load_activity.php">��������� �� ������ ���</a></li>
          <li><a href="load_consent.php">����� ���</a></li>

      </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">��������</span></a>
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
      <li><a href="load_skof.php">����</a></li>
      <li><a href="department.php">³����</a></li>
      <li><a href="manegers.php">��������</a></li>
    </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">������</span></a>
      <ul class="sub">
        <li><a href="picks_organizations.php">������ ���������</a></li>
        <li><a href="selection_org_by_list.php">������� ��������� �� �����</a></li>
        <li><a href="selection_org_by_user_list.php">������� ��������� �� ������</a></li>
        <li><a href="" class="fly">������� ��������� ����� ���������</a>
            <ul>
              <li><a href="export_organizations_adress.php">�� ��������</a></li>
              <li><a href="export_organizations_adress_by_user_list.php">�� ������ �������� ������������</a></li>
            </ul>
        </li>
      </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">����</span></a>
      <ul class="sub">
      <li><a href="act_process.php">��� ��������</a></li>
      <li><a href="act_show.php">��� �����</a></li>
      </ul>
  </li>

  <li class="top"><a href="#" id="" class="top_link"><span class="down">�������������</span></a>
      <ul class="sub">
        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� �������.pdf'});\""; ?>;>��� �������</a></li>
        <li><a href="" class="fly">����� ���</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������������ ���.pdf'});\""; ?>;>������������ ���</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��������� ������.pdf'});\""; ?>;>��������� ������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��� ��� ��������.pdf'});\""; ?>;>��� ��� ��������</a></li>
                <li><a href="" class="fly">������������ ����������</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������������ ���������� � 1-��.pdf'});\""; ?>;>� 1-��</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������������-���������� � �������.pdf'});\""; ?>;>� �������</a></li>
                    </ul>
                </li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��������� �������������.pdf'});\""; ?>;>��������� �������������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��������� ����������.pdf'});\""; ?>;>��������� ����������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������������ ��������.pdf'});\""; ?>;>������������ ��������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��������� �� ������ ���.pdf'});\""; ?>;>��������� �� ������ ���</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'����� ���.pdf'});\""; ?>;>����� ���</a></li>
            </ul>
        </li>
        <li><a href="" class="fly">��������</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'���� 2010.pdf'});\""; ?>;>���� 2010</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'ʲ��  2014.pdf'});\""; ?>;>ʲ�� 2014</a></li>
                <li><a href="" class="fly">�������</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� KOATUU.pdf'});\""; ?>;>KOATUU</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� ������.pdf'});\""; ?>;>������</a></li>
                    </ul>
                </li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'���.pdf'});\""; ?>;>���</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������ ���������.pdf'});\""; ?>;>������ ���������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'³����.pdf'});\""; ?>;>³����</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��������.pdf'});\""; ?>;>��������</a></li>
            </ul>
        </li>
        <li><a href="" class="fly">������</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������ ����������.pdf'});\""; ?>;>������ ���������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� ��������� �� ����� 1.pdf'});\""; ?>;>������� ��������� �� �����</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� ��������� �� ������ 1.pdf'});\""; ?>;>������� ��������� �� ������</a></li>
                <li><a href="" class="fly">������� ��������� ����� ���������</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� ��������� ����� ��������� �� ��������.pdf'});\""; ?>;>�� ��������</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'������� ��������� ����� ��������� �� ������ �������� ������������.pdf'});\""; ?>;>�� ������ �������� ������������</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="" class="fly">����</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��� ��������.pdf'});\""; ?>;>��� ��������</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'��� ������.pdf'});\""; ?>;>��� �����</a></li>
            </ul>
        </li>

      </ul>
  <li class="top_l">
    <a href="../../lib/logout.php" class="top_li">
      <span>�����</span>
    </a>
  </li>
</ul>
</div>
