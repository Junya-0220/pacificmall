<?php get_header();//ヘッダーを読み込ませる?>
              <div class="page-inner full-width">
                <div class="page-main" id="pg-newsDetail">
                  <div class="main-container">
                    <div class="main-wrapper">
<?php if(have_posts()):
  while(have_posts()):
    the_post();
    get_template_part('content-single');
  endwhile;
endif;
?>
                    </div><!--.main-wrapper-->
                  </div><!--.main-container-->
                </div><!--.page-main #pg-newsDetail-->
              </div><!--.page-inner .full-width-->
<?php get_footer();?>