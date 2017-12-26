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
          <a href="el_signatures.php">Електронні підписи</a>
        </li>
        <li>
          <a href="load_bankrut.php">Завантаження даних про банкрутів</a>
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
      </ul>
    </li>
    <li class="top"><a href="" id="" class="top_link"><span class="down">Довідники</span></a>
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
    <li class="top"><a href="" id="" class="top_link"><span class="down">Акти</span></a>
      <ul class="sub">
        <li><a href="act_show.php">АКТ пошук</a></li>
      </ul>
    </li>
    <li class="top"><a href="" id="" class="top_link"><span class="down">Документація</span></a>
        <ul class="sub">
          <li><a href="ссылка">Про систему</a></li>
          <li><a href="ссылка">Вибірка</a></li>
        </ul>
    </li>
    <li class="top_l">
      <a href="../../lib/logout.php" class="top_li">
        <span>Вихід</span>
      </a>
    </li>
  </ul>
</div>
