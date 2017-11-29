<?php
  function dd($dump) {
    highlight_string("<?php\n\$data =\n" . print_r($dump, true) . ";\n?>");
    die();
  }
?>

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
    <link type="text/css" rel="stylesheet" href="/public/plugins/fontawesome/css/font-awesome.min.css">
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
      <a href="/"><img src="/public/image/logo/inpk_logo.svg"></a>
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

      <?php if ($_SESSION['role_id'] < 3): ?>
        <li class="navigation-section">
          <img class="svg" src="/public/image/icon/admin/settings.svg">
          <ul class="hover-menu">
              <li class="hover-menu__item-title">Настройки</li>
              <?php if ($_SESSION['role_id'] == 1): ?>
                <li><a href="/admin/users">Пользователи</a></li>
                <li><a href="/admin/roles">Роли</a></li>
                <li><a href="/admin/dealings">Сделки</a></li>
                <li><a href="/admin/types">Типы</a></li>
                <li><a href="/admin/total/areas">Площади</a></li>
                <li><a href="/admin/windows">Окна</a></li>
                <li><a href="/admin/glazings">Остекления</a></li>
                <li><a href="/admin/settings-reserve">Бронь</a></li>
                <li><a href="/admin/prices/index">Цены</a></li>
                <li><a href="/admin/apartments">Квартиры</a></li>
              <?php elseif ($_SESSION['role_id'] == 2): ?>
                <li><a href="/admin/prices/index">Цены</a></li>
              <?php endif; ?>
          </ul>
        </li>    
      <?php endif; ?>
    </ul>
  </nav>
  <section id="boxApartments">
<?php endif; ?>