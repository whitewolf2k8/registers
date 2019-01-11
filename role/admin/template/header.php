<div id="mainfoter">
      <h1><? echo $_header; ?></h1>
</div>

<div id="infolist">
      <p class="leftSide">Ви аторизувалися як:<font style="font-weight:bold;"> <? echo $_SESSION['name']." ( ".$typeUsers[$_SESSION[type]]." )"; ?></font></p>
      <p class="rightSide">Поточна дата: <font style="font-weight:bold;"><? echo date("m.d.y");?> </font> </p>
</div>

<div id=menu>
<ul id="nav">
    <li class="top">
      <a href="index.php" class="top_link">
        <span>На головну</span>
      </a>
    </li>

    <li class="top">
      <a id="" class="top_link">
        <span class="down">Вхідні дані</span>
      </a>
        <ul class="sub">
          <li>
            <a href="load_arm.php">Завантаження АРМ</a>
          </li>
          <li>

            <a href="load_el_signatures.php">Електронні підписи</a>
          </li>
          <li>
            <a href="load_bankrut.php">Дані про банкрутів</a>
          </li>
          <li><a href="" class="fly">Завантаження чисельності</a>
              <ul>
                  <li><a href="load_amount_pv.php">з 1-ПВ</a></li>
                  <li><a href="load_amount_fin.php">з фінансів</a></li>
              </ul>
          </li>
          <li class="mid"><a href="load_list.php">Порушення законодавства</a></li>
          <li class="mid"><a href="load_volator.php">Порушення адмінсправи</a></li>
          <li class="mid"><a href="load_stop_activity.php">Призупинення діяльності</a></li>
          <li><a href="load_activity.php">Активність за даними ДФС</a></li>
          <li><a href="load_consent.php">Згоди ОДА</a></li>

      </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">Довідники</span></a>
      <ul class="sub">
      <li><a href="load_kved.php">Квед 2010</a></li>
      <li><a href="load_kise.php">KICE 2014</a></li>

      <li><a href="" class="fly">Території</a>
          <ul>
              <li><a href="load_koatuu.php">KOATUU</a></li>
              <li><a href="load_region.php">Регіони</a></li>
          </ul>
      </li>
      <li><a href="load_opf.php">ОПФ</a></li>
      <li><a href="load_management.php">Органи управління</a></li>
      <li><a href="load_skof.php">СКОФ</a></li>
      <li><a href="department.php">Відділи</a></li>
      <li><a href="manegers.php">Керівники</a></li>
    </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">Запити</span></a>
      <ul class="sub">
        <li><a href="picks_organizations.php">Вибірка підприємств</a></li>
        <li><a href="selection_org_by_list.php">Експорт підприємств по файлу</a></li>
        <li><a href="selection_org_by_user_list.php">Експорт підприємств по списку</a></li>
        <li><a href="" class="fly">Експорт фактичних адрес підприємств</a>
            <ul>
              <li><a href="export_organizations_adress.php">по фільтрам</a></li>
              <li><a href="export_organizations_adress_by_user_list.php">по списку заданому користувачем</a></li>
            </ul>
        </li>
      </ul>
  </li>
  <li class="top"><a href="#" id="" class="top_link"><span class="down">Акти</span></a>
      <ul class="sub">
      <li><a href="act_process.php">АКТ введення</a></li>
      <li><a href="act_show.php">АКТ пошук</a></li>
      </ul>
  </li>

  <li class="top"><a href="#" id="" class="top_link"><span class="down">Доукументація</span></a>
      <ul class="sub">
        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Головна сторінка.pdf'});\""; ?>;>Про систему</a></li>
        <li><a href="" class="fly">Вхідні дані</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Завантаження АРМ.pdf'});\""; ?>;>Завантаження АРМ</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Електронні підписи.pdf'});\""; ?>;>Електронні підписи</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Дані про банкрутів.pdf'});\""; ?>;>Дані про банкрутів</a></li>
                <li><a href="" class="fly">Завантаження чисельності</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Завантаження чисельності з 1-ПВ.pdf'});\""; ?>;>з 1-ПВ</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Завантаження-чисельності з фінансів.pdf'});\""; ?>;>з фінансів</a></li>
                    </ul>
                </li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Порушення законодавства.pdf'});\""; ?>;>Порушення законодавства</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Порушення адмінсправи.pdf'});\""; ?>;>Порушення адмінсправи</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Призупинення діяльноісті.pdf'});\""; ?>;>Призупинення діяльності</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Активність за даними ДФС.pdf'});\""; ?>;>Активність за даними ДфС</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Згоди ОДА.pdf'});\""; ?>;>Згоди ОДА</a></li>
            </ul>
        </li>
        <li><a href="" class="fly">Довідники</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Квед 2010.pdf'});\""; ?>;>Квед 2010</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'КІСЕ  2014.pdf'});\""; ?>;>КІСЕ 2014</a></li>
                <li><a href="" class="fly">Території</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Території KOATUU.pdf'});\""; ?>;>KOATUU</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Території Регіони.pdf'});\""; ?>;>Регіони</a></li>
                    </ul>
                </li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'ОПФ.pdf'});\""; ?>;>ОПФ</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Органи управління.pdf'});\""; ?>;>Органи управління</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Відділи.pdf'});\""; ?>;>Відділи</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Керівники.pdf'});\""; ?>;>Керівники</a></li>
            </ul>
        </li>
        <li><a href="" class="fly">Запити</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Вибірка підприємтсва.pdf'});\""; ?>;>Вибірка підприємств</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Експорт підприємств по файлу 1.pdf'});\""; ?>;>Експорт підприємств по файлу</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Експорт підприємств по списку 1.pdf'});\""; ?>;>Експорт підприємств по списку</a></li>
                <li><a href="" class="fly">Експорт фактичних адрес підприємств</a>
                    <ul>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Експорт фактичних адрес підприємств по фільтрам.pdf'});\""; ?>;>по фільтрам</a></li>
                        <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Експорт фактичних адрес підприємств по списку заданому користувачем.pdf'});\""; ?>;>по списку заданому користувачем</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="" class="fly">Акти</a>
            <ul>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Акт введення.pdf'});\""; ?>;>АКТ введення</a></li>
                <li><a OnClick=<? echo "\"openUrlDoc('document_view.php',{path:'Акт пошуку.pdf'});\""; ?>;>АКТ пошук</a></li>
            </ul>
        </li>

      </ul>
  <li class="top_l">
    <a href="../../lib/logout.php" class="top_li">
      <span>Вихід</span>
    </a>
  </li>
</ul>
</div>
