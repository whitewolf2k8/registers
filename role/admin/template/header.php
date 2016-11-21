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
          <li><a href="" class="fly">Завантаження чисельності</a>
              <ul>
                  <li><a href="load_amount_pv.php">з 1-ПВ</a></li>
                  <li><a href="load_region.php">з фінансів</a></li>
              </ul>
          </li>
          <li class="mid"><a href="load_list.php">Порушення законодавства</a></li>
          <li>
            <a href="" class="fly">Где заказывать?</a>
              <ul>
                <li>
                  <a href="ссылка">Стили</a>
                </li>
                  <li>
                    <a href="ссылка" class="fly">Элементы стиля</a>
                   <ul>
                       <li>
                        <a href="ссылка">Шапки</a>
                       </li>
                  <li><a href="ссылка">Картинки для меп-карт</a></li>
                  <li><a href="ссылка">Картинки</a></li>
                  <li><a href="ссылка">Фоны</a></li>
                  <li><a href="ссылка">Иконки</a></li>
                  <li><a href="ссылка">Смайлы</a></li>
                  <li><a href="ссылка">Награды</a></li>
                  <li><a href="ссылка">Кнопки</a></li>
                  <li><a href="ссылка">Заголовки</a></li>
                  <li><a href="ссылка">Курсоры</a></li>
                        <li><a href="ссылка">Tro lo lo </a></li>
              </ul>
                                                                        </li>
              <li><a href="ссылка" class="fly">Рекламные элементы</a>
              <ul>
                  <li><a href="ссылка">Картинки</a></li>
                  <li><a href="ссылка">Логотипы</a></li>
                  <li><a href="ссылка">Баннеры</a></li>
              </ul>
                                                                       </li>

              <li><a href="ссылка" class="fly">Элементы профиля</a>
              <ul>
                  <li><a href="ссылка">Аватарки</a></li>
                  <li><a href="ссылка">Юзербары</a></li>
                  <li><a href="ссылка">Подписи</a></li>
                  <li><a href="ссылка">Комплекты</a></li>
              </ul>
                                                                       </li>
              <li><a href="ссылка" class="fly">HTML-заказы</a>
              <ul>
                  <li><a href="ссылка">Таблицы</a></li>
                  <li><a href="ссылка">Мэп-карты</a></li>
              </ul>
                                                                       </li>
          </ul>
      </li>
      <li class="mid"><a href="ссылка">Навигация</a>
      </li>

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
        <li><a href="ссылка" class="fly">Галерея</a>
          <ul>
              <li><a href="ссылка">Стили</a></li>
              <li><a href="ссылка">Шапки</a></li>
              <li><a href="ссылка">Картинки</a></li>
              <li><a href="ссылка">Баннеры</a></li>
              <li><a href="ссылка">Аватарки</a></li>
          </ul>
        </li>
    </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">Акти</span></a>
      <ul class="sub">
      <li><a href="act_process.php">АКТ введення</a></li>
      <li><a href="act_show.php">АКТ пошук</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">ПОМОЩЬ ФОРУМУ</span></a>
      <ul class="sub">
      <li><a href="ссылка">Вакансии</a></li>
      <li><a href="ссылка">Продвижение</a></li>
      <li><a href="">Финансовая помощь</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">ВАЖНОЕ</span></a>
      <ul class="sub">
      <li><a href="ссылка">Объявления</a></li>
      <li><a href="ссылка">Конкурсы</a></li>
      <li><a href="ссылка">Новости</a></li>
      </ul>
  </li>
    <li class="top_l">
      <a href="../../lib/logout.php" class="top_li">
        <span>Вихід</span>
      </a>
    </li>
  </ul>
</div>
