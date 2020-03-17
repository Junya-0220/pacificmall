<?php get_header();?>
			  <div class="page-inner">
                <div class="page-main" id="pg-common">
                  <ul class="commons">
<?php
$common_pages = get_child_pages();
if($common_pages->have_posts()):
  while($common_pages->have_posts())://ループ開始
    $common_pages->the_post();//サブクエリを利用したWordPressのループ方法はオブジェクトのメソッドを使う形で記述する
    get_template_part('content-common');
  endwhile;//ループ終了
  wp_reset_postdata();//サブクエリを実行した後、メインクエリに戻すときに記述する
endif;
?>
              </ul><!--commons-->
            </div> <!--.page-main #pg-common-->
          </div><!--page-inner-->
<?php get_footer();?>
