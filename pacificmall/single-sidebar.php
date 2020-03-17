<?php
/*
Template Name: サイドバーあり
Template Post Type: daily_contribution
*/
get_header(); ?>
			  <div class="page-inner two-column">
                <div class="page-main" id="pg-company">
                  <div class="content">
                    <div class="content-main">
                      <article class="article-body">
                        <div class="article-inner">
<?php
if( have_posts() ):
	while(have_posts()):the_post();
		get_template_part('content-single');
	endwhile;
endif;
?>
          </div><!--.article-inner-->
        </article>
      </div><!--.content-main-->
      <?php get_sidebar();?>
      </div><!--.content-->
    </div><!--.page-main-->
  </div><!--.page-inner two-column-->
<?php get_footer();?>