<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo wp_get_document_title();?></title>
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/assets/images/common/favicon.ico" />
  <link href="https://fonts.googleapis.com/earlyaccess/notosansjapanese.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Vollkorn:400i" rel="stylesheet" />
  <?php wp_head();?>
</head>
<body <?php body_class(); //<body>にクラス属性を追加する?>>
<?php wp_body_open(); //<body>直後に必ず書く。wp5.2以降で使用可能。wp5.1以前の場合はこの行を削除する ?>
  <div class="container">
    <header id="header">
      <div class="header-inner">
        <div class="logo">
          <a class="logo-header" href="/">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/common/logo-main.svg" class="main-logo" alt="PACIFIC MALL DEVELOPMENT" />
            <img src="<?php echo get_template_directory_uri();?>/assets/images/common/logo-fixed.svg" class="fixed-logo" alt="PACIFIC MALL DEVELOPMENT" />
          </a>
        </div>
        <button class="toggle-menu js-toggoleNav">
          <span class="toggle-line">メニュー</span>
        </button>
        <div class="header-nav">
          <nav class="global-nav">
          <?php
          wp_nav_menu(
            [
              'theme_location' => 'place_global',//register_nav_menusで登録したメニュー名を指定
              'container' => false,//出力されるulタグを無効にするために記述
            ]
            );
          ?>
          </nav>
          <form class="search-form" role="search" method="get" action="<?php echo esc_url(home_url());?>">
            <div class="search-box">
              <input type="text" class="search-input" name="s" placeholder="キーワードを入力してください" />
              <button type="submit" class="button-submit"></button>
            </div>
            <div class="search-buttons">
              <button type="button" class="close-icon js-searchIcon"></button>
              <button type="button" class="search-icon js-searchIcon"></button>
            </div>
          </form>
        </div>
      </div>
    </header>
    <?php if(is_front_page()): //トップページの場合?>
    <section class="section-contents" id="keyvisual">
    <?php echo get_main_image();?>
      <div class="wrapper">
        <h1 class="site-title"><?php bloginfo('description');?></h1>
        <p class="site-caption">
          <?php echo get_the_excerpt();?>
        </p>
      </div>
    </section>
    <?php else: ?>
    <div class="wrap">
      <div id="primary" class="content-area">
        <main>
        <div class="page-contents">
          <div class="page-head">
            <?php echo get_main_image();?>
            <div class="wrapper">
              <span class="page-title-en"><?php echo get_main_en_title();?></span><!--page-title-en-->
              <h2 class="page-title"><?php echo get_main_title();?></h2>
            </div><!--.wrapper-->
          </div><!--.page-head -->
          <div class="page-container">
<?php
if(function_exists('bread_crumb'))://引数にしている関数(ここではbread_crumb())が定義されているかどうかをチェックしています
  bread_crumb();//プラグインで定義されている関数です。Prime Strategy Bread Crumbのプラグインを使用してパンくずナビを生成しています。
endif;
?>
<?php endif?>