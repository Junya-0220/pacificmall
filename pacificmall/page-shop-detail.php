<?php 
/*
Template Name: 店舗詳細
*/
get_header();
?>
<div class="page-inner full-width">
  <div class="page-main" id="pg-shopDetail">
    <div class="lead-inner">
<?php
if(have_posts()):
  while(have_posts()):the_post();
    the_content();
  endwhile;
endif;
?>
      <div class="bg-shop"></div>
    </div><!--.lead-inner -->
    <div class="shopList-Container">
      <div class="shopList-head">
        <span class="title-en"></span>
        <h3 class="title">ショップリスト</h3>
      </div><!--.shopList-head -->
      <div class="shopList-inner">
        <ul class="shopList">
          <?php
          $shops = ['first_shop_detail','second_shop_detail'];
          foreach($shops as $shop):
            if(have_rows($shop)):
              while(have_rows($shop)):the_row();
                get_template_part('content-shop-detail');
              endwhile;
            endif;
          endforeach;
          ?> 
       </ul>
      </div><!--.shopList-inner -->
    </div><!--shopList-Container-->
  </div><!--.page-main-->
</div><!--.page-inner full-width-->
<?php get_footer();?>