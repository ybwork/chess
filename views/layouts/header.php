<!DOCTYPE html>
<html lang="en">
  <head>
    <noscript>Для полной функциональности этого сайта необходимо включить JavaScript.</noscript>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chess</title>
    
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600&amp;subset=cyrillic" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/public/css/app.css.php?<?php print filemtime(ROOT . '/public/css/app.css.php'); ?>">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
<?php if (isset($_SESSION['user'])): ?>
  <loader>
    <div class="status-block">
      <div class="circle-loader">
        <div class="checkmark draw"></div>
      </div>
      <p class="error-msg"></p>
      <p class="success-msg"></p>
    </div>
  </loader>

  <header class="header">
    <div class="header-logo">
      <img src="/public/image/logo/inpk_logo.svg">
    </div>
    <div class="header-user">
      <div class="user-name"><?php isset($_SESSION['user_name_surname']) ? print $_SESSION['user_name_surname']: print ''; ?></div>
      <div class="user-role"><?php isset($_SESSION['role_name']) ? print $_SESSION['role_name']: print ''; ?></div>
    </div>
    <div class="header-logout">
      <a href="/logout">Выйти</a>
    </div>
  </header>

  <nav class="navigation-panel">
    <ul class="navigation-items">
      <li class="menu-item">
        <img class="svg" src="/public/image/icon/admin/menu-options.svg" alt="">
      </li>

      <div id="reservator" style="display: none"><?php print $_SESSION['user']; ?></div>
  		<div id="role" style="display: none"><?php print $_SESSION['role_id']; ?></div>

      <li class="navigation-section">
        <img class="svg" src="/public/image/icon/admin/tesla.svg">
        <label>Тесла Дом</label>
        <ul class="hover-menu">
          <li class="hover-menu__item-title">Тесла дом</li>
          <li><a href="/">Главная</a></li>
          <?php if ($_SESSION['role_id'] == 1): ?>
            <li><a href="/admin/types">Типы квартир</a></li>
            <li><a href="/admin/total/areas">Общая площадь</a></li>
            <li><a href="/admin/windows">Куда выходят окна</a></li>
            <li><a href="/admin/apartments">Создание квартир</a></li>
            <li><a href="/admin/glazings">Типы остекления</a></li>
            <li><a href="/admin/settings-reserve">Настройки брони</a></li>
            <li><a href="/admin/prices/index">Загрузка цен</a></li>
          <?php endif; ?>
          <?php if ($_SESSION['role_id'] == 3): ?>
            <li><a href="/admin/prices/index">Загрузка цен</a></li>
          <?php endif; ?>
        </ul>
      </li>

      <?php if ($_SESSION['role_id'] < 4): ?>
        <li class="navigation-section">
          <img class="svg" src="/public/image/icon/admin/settings.svg">
          <ul class="hover-menu">
              <li class="hover-menu__item-title">Система</li>
              <?php if ($_SESSION['role_id'] == 1): ?>
                <li><a href="/admin/users">Пользователи</a></li>
                <li><a href="/admin/roles">Роли</a></li>
              <?php elseif ($_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3): ?>
                <li><a href="/admin/users">Пользователи</a></li>
              <?php endif; ?>
          </ul>
        </li>    
      <?php endif; ?>
    </ul>

    <div class="actual-info">
      <form id="actual-info" action="/apartments/actualize" method="POST">
        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 85.168 85.168" style="enable-background:new 0 0 85.168 85.168;" xml:space="preserve" width="36px" height="36px" class="svg replaced-svg">
          <svg>
          <g>
            <path d="M61.696,14.999l-4.126,4.457c8.806,5.774,13.923,16.353,12.184,27.41c-1.146,7.288-5.063,13.694-11.027,18.037   c-5.206,3.791-11.43,5.615-17.777,5.252l1.09-1.144c-0.021-0.001-0.044,0.002-0.065,0.001l4.129-4.332l-3.813-3.639l-8.188,8.596   l-0.002-0.003l-3.533,3.71l3.811,3.636l0.002-0.001l8.593,8.189l3.536-3.71l-5.565-5.302c7.616,0.36,15.066-1.853,21.315-6.403   c7.261-5.286,12.028-13.084,13.424-21.956C77.741,34.694,71.897,22.14,61.696,14.999z" fill="#FFFFFF"></path>
            <path d="M15.415,38.302c1.146-7.288,5.063-13.694,11.027-18.037c5.206-3.791,11.43-5.615,17.777-5.252l-1.09,1.144   c0.021,0.001,0.044-0.002,0.065-0.001l-4.129,4.332l3.813,3.639l8.188-8.596l0.002,0.003l3.533-3.71L50.79,8.188l-0.002,0.001   L42.195,0l-3.536,3.71l5.565,5.302c-7.616-0.36-15.066,1.853-21.315,6.403c-7.261,5.286-12.028,13.084-13.424,21.956   C7.425,50.475,13.27,63.029,23.47,70.17l4.126-4.457C18.793,59.937,13.676,49.359,15.415,38.302z" fill="#FFFFFF"></path>
          </g>
          </svg>
        </button>
      </form>
    </div>
  </nav>

  <section id="boxApartments">
<?php endif; ?>