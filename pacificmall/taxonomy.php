<?php get_header();?>
    <div class="page-inner">
        <div class="page-main" id="pg-contribution">
            <div class="contribution">
<?php
$term = get_specific_posts('daily_contribution','event',$term,-1);
if($term->have_posts())://$termに閲覧しているスラッグが自動的に格納されている
    while($term->have_posts()):$term->the_post();
        get_template_part('content-tax');
    endwhile;
    wp_reset_postdata();
endif;
?>
              </div><!--contribution-->
            </div> <!--.page-main #pg-contribution-->
          </div><!--page-inner-->
<?php get_footer();?>
