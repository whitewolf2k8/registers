<div id="mainfoter">
      <h1><? echo $_header; ?></h1>
</div>

<div id="infolist">
      <p class="leftSide">Âč ŕňîđčçóâŕëčń˙ ˙ę:<font style="font-weight:bold;"> <? echo $_SESSION['name']." ( ".$typeUsers[$_SESSION[type]]." )"; ?></font></p>
      <p class="rightSide">Ďîňî÷íŕ äŕňŕ: <font style="font-weight:bold;"><? echo date("m.d.y");?> </font> </p>
</div>

<div id=menu>
<ul id="nav">
    <li class="top">
      <a href="index.php" class="top_link">
        <span>Íŕ ăîëîâíó</span>
      </a>
    </li>

    <li class="top">
      <a id="" class="top_link">
        <span class="down">Âőłäíł äŕíł</span>
      </a>
        <ul class="sub">
          <li>
            <a href="load_arm.php">Çŕâŕíňŕćĺíí˙ ŔĐĚ</a>
          </li>
          <li>

            <a href="load_el_signatures.php">Ĺëĺęňđîííł ďłäďčńč</a>
          </li>
          <li>

            <a href="load_bankrut.php">Äŕíł ďđî áŕíęđóňłâ</a>

          </li>
          <li><a href="" class="fly">Çŕâŕíňŕćĺíí˙ ÷čńĺëüíîńňł</a>
              <ul>
                  <li><a href="load_amount_pv.php">ç 1-ĎÂ</a></li>
                  <li><a href="load_amount_fin.php">ç ôłíŕíńłâ</a></li>
              </ul>
          </li>
          <li class="mid"><a href="load_list.php">Ďîđóřĺíí˙ çŕęîíîäŕâńňâŕ</a></li>
          <li class="mid"><a href="load_volator.php">Ďîđóřĺíí˙ ŕäěłíńďđŕâč</a></li>
          <li class="mid"><a href="load_stop_activity.php">Ďđčçóďčíĺíí˙ äł˙ëüíîńňł</a></li>

          <li><a href="load_volator.php">Ŕäěłíńďđŕâč ńďđŕâč </a></li>
          <li><a href="load_activity.php">Ŕęňčâíłńňü çŕ äŕíčěč ÄÔŃ</a></li>

      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">Äîâłäíčęč</span></a>
      <ul class="sub">
      <li><a href="load_kved.php">Ęâĺä 2010</a></li>
      <li><a href="load_kise.php">KICE 2014</a></li>

      <li><a href="" class="fly">Ňĺđčňîđłż</a>
          <ul>
              <li><a href="load_koatuu.php">KOATUU</a></li>
              <li><a href="load_region.php">Đĺăłîíč</a></li>
          </ul>
      </li>
      <li><a href="load_opf.php">ÎĎÔ</a></li>
      <li><a href="load_management.php">Îđăŕíč óďđŕâëłíí˙</a></li>
      <li><a href="department.php">Âłääłëč</a></li>
      <li><a href="manegers.php">Ęĺđłâíčęč</a></li>
        <li><a href="ńńűëęŕ" class="fly">Ăŕëĺđĺ˙</a>
          <ul>
              <li><a href="ńńűëęŕ">Ńňčëč</a></li>
              <li><a href="ńńűëęŕ">Řŕďęč</a></li>
              <li><a href="ńńűëęŕ">Ęŕđňčíęč</a></li>
              <li><a href="ńńűëęŕ">Áŕííĺđű</a></li>
              <li><a href="ńńűëęŕ">Ŕâŕňŕđęč</a></li>
          </ul>
        </li>
    </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">Ŕęňč</span></a>
      <ul class="sub">
      <li><a href="act_process.php">ŔĘŇ ââĺäĺíí˙</a></li>
      <li><a href="act_show.php">ŔĘŇ ďîřóę</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">ĎÎĚÎŮÜ ÔÎĐÓĚÓ</span></a>
      <ul class="sub">
      <li><a href="ńńűëęŕ">Âŕęŕíńčč</a></li>
      <li><a href="ńńűëęŕ">Ďđîäâčćĺíčĺ</a></li>
      <li><a href="">Ôčíŕíńîâŕ˙ ďîěîůü</a></li>
      </ul>
  </li>
  <li class="top"><a href="" id="" class="top_link"><span class="down">ÂŔĆÍÎĹ</span></a>
      <ul class="sub">
      <li><a href="ńńűëęŕ">Îáú˙âëĺíč˙</a></li>
      <li><a href="ńńűëęŕ">Ęîíęóđńű</a></li>
      <li><a href="ńńűëęŕ">Íîâîńňč</a></li>
      </ul>
  </li>
    <li class="top_l">
      <a href="../../lib/logout.php" class="top_li">
        <span>Âčőłä</span>
      </a>
    </li>
  </ul>
</div>
