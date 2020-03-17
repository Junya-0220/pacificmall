<div class="news">
    <time class="time"><?php the_time('Y.m.d');?></time>
    <p class='title'><?php the_title();?></p>
    <div class="news-body">
    <?php the_content();?>
    </div><!--.news-body-->
</div><!--.news-->

<div class="more-news">
<?php
$next_post = get_next_post();//次の記事データをオブジェクトで取得するテンプレートタグ
$prev_post = get_previous_post();//前の記事データをオブジェクトで取得するテンプレートタグ
if($next_post)://記事があるかの判定をしている
?>
  <div class="next">
    <a class="another-link" href="<?php echo get_permalink($next_post->ID);?>">NEXT</a>
  </div><!--.next-->
<?php
endif;
if($prev_post)://記事があるかの判定をしている
?>

  <div class="prev">
    <a class="another-link" href="<?php echo get_permalink($prev_post->ID);?>">PREV</a>
  </div><!--.prev-->
<?php
endif;
?>
</div><!--.more news-->
