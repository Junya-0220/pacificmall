<?php get_header();?>
              <div class="page-inner full-width">
                <div class="page-main" id="pg-news">
                  <div class="main-container">
                    <div class="main-wrapper">
                      <div class="newsLists">
<?php
if(have_posts()):
    while(have_posts()):the_post();
?>                          
                        <a class="news-link" href="<?php the_permalink();?>">
                          <div class="news-body">
                            <time class="release"><?php the_time('Y.m.d');?></time>
                            <p class="title"><?php the_title();?></p>
                          </div><!--news-body-->
                        </a><!--news-link-->
<?php
    endwhile;
endif;
?>
                      </div><!--newsLists-->
                      <div class="pager">
                        <ul class="pageList">
<?php
if(function_exists('page_navi'))://引数にしている関数が定義されているかチェックする
  page_navi();//Prime Strategy Page Naviで定義されている関数
endif;
?>
                        </ul>

                      </div>
                    </div><!-- main-wrapper -->
                  </div><!-- main-container -->
               </div> <!-- page-main #pg-news -->
              </div><!-- page-inner full-width -->
<?php get_footer();?>