<?php get_header();?>
    <section class="section-contents" id="shop">
      <div class="wrapper">
<?php
$shop_obj = get_page_by_path('shop');/*引数に固定ページのスラッグを指定することでそのページのオブジェクトを取得できる。
ここでは店舗情報のオブジェクトを取得している。*/
$post = $shop_obj;
setup_postdata($post);
/*引数に投稿オブジェクトを指定することで、WordPressの多くのテンプレートタグが参照するテンプレートタグが参照する
各種グローバル変数へ指定した投稿情報をセットする。
そのため、setup_postdata()からwp_reset_postdata()の間で使用しているテンプレートタグは、指定した投稿情報をもとに実行される。
setup_postdata()をメインクエリに戻すときはwp_reset_postdata()を記述する。
*/
$shop_title = get_the_title();
?>
        <span class="section-title-en"><?php the_field('english_title');?></span>
        <h2 class="section-title"><?php the_title();?></h2>
        <p class="section-lead"><?php echo get_the_excerpt();?></p>
<?php wp_reset_postdata();?>
        <ul class="shops">
<?php
$shop_pages = get_child_pages(4,$shop_obj->ID);
/*第二引数の$shop_obj->IDは、固定ページの「店舗情報」の記事IDを指定している
$shop_objには、<section class="contents" id="shop">のすぐ下で、get_page_by_path('shop')で取得した固定ページ
「店舗情報」のオブジェクトが格納されている*/
if($shop_pages->have_posts()):
  while($shop_pages->have_posts()):$shop_pages->the_post();
?>
          <li class="shops-item">
            <a class="shop-link" href="<?php the_permalink();?>">
              <div class="shop-image">
                <?php the_post_thumbnail('common');?>
              </div>
              <div class="shop-body">
                <p class="name"><?php the_title();?></p>
                <p class="location"><?php the_field('location');?></p>
                <div class="buttonBox">
                  <button type="button" class="seeDetail">MORE</button>
                </div>
              </div>
            </a>
          </li><!--.shop-item-->
<?php
  endwhile;
  wp_reset_postdata();
endif;
?>
        </ul><!--.shops-->
        <div class="section-buttons">
          <button type="button" class="button button-ghost" 
          onclick="javascript:location.href = '<?php echo esc_url(home_url('shop')); ?>';//esc_url()はURLを無害化する関数">
            <?php echo $shop_title; //get_the_title()の戻り値を格納しておいた変数?>
          </button>
        </div>
      </div>
    </section>

    <section class="section-contents" id="contribution">
      <div class="wrapper">
<?php
$contribution_obj = get_page_by_path('contribution');/*引数に固定ページのスラッグを指定することでそのページのオブジェクトを取得できる。
ここでは地域貢献のオブジェクトを取得している。*/
$post = $contribution_obj;
setup_postdata($psot);
$contribution_title = get_the_title();
?>
        <span class="section-title-en"><?php the_field('english_title')?></span>
        <h2 class="section-title"><?php the_title();?></h2>
        <p class="section-lead"><?php echo get_the_excerpt();?></p>
<?php wp_reset_postdata();?>
        <div class="articles">
<?php
$contribution_pages = get_specific_posts('daily_contribution','event','',3);
if($contribution_pages->have_posts()):
  while($contribution_pages->have_posts()):
    $contribution_pages->the_post();
?>
          <article class="article-card">
            <a class="card-link" href="<?php the_permalink();?>">
              <div class="card-inner">
                <div class="card-image">
	                <img src="<?php the_post_thumbnail('front-cntribution');?>">
                </div>
                <div class="card-body">
                  <p class="title"><?php the_title();?></p>
                  <p class="excerpt"><?php echo get_the_excerpt();?></p>
                  <div class="buttonBox">
                    <button type="button" class="seeDetail">MORE</button>
                  </div>
                </div>
              </div>
            </a>
          </article>
<?php
    endwhile;
  wp_reset_postdata();
endif;
?>
        </div><!--.articles-->
        <div class="section-buttons">
          <button type="button" class="button button-ghost" 
          onclick="javascript:location.href = '<?php echo esc_url(home_url('contribution'));?>';">
            <?php echo $contribution_title; ?>を見る
          </button>
        </div><!--.section-buttons -->
      </div>
    </section>
    <section class="section-contents" id="news">
      <div class="wrapper">
<?php $term_obj = get_term_by('slug','news','category');
 /*この関数を使用することで取得したいタームの条件を指定して、タームのオブジェクトを取得する事ができます。
 第一引数にどのフィールドをもとに情報を取得したいか、第二引数にフィールドの具体的な値、第三引数にタームが属するタクソノミーを指定します
 */
?>
        <span class="section-title-en"><?php the_field('english_title',$term->obj->taxonomy.'_'.$term_obj->term_id);?></span>
        <h2 class="section-title"><?php echo $term_obj->name;?></h2>
        <p class="section-lead"><?php echo $term_obj->description;?></p>
        <ul class="news">
<?php
$args = [
  'post_type'=>'post',
  'category_name' => 'news',
  'posts_per_page' => 3,
];
$news_posts = get_specific_posts('post','category','news',3);
if($news_posts->have_posts()):
  while($news_posts->have_posts()):
    $news_posts->the_post();
?>
          <li class="news-item">
            <a class="detail-link" href="<?php the_permalink();?>">
              <time class="time"><?php the_time('Y.m.d');?></time>
              <p class="title"><?php the_title();?></p>
              <p class="news-text"><?php echo get_the_excerpt();?></p>
            </a>
          </li>
<?php
    endwhile;
  wp_reset_postdata();
endif;
?>
        </ul>
        <div class="section-buttons">
          <button type="button" class="button button-ghost" 
          onclick="javascript:location.href = '<?php echo esc_url(get_term_link($term_obj));?>';//タームのオブジェクト、IDまたはスラッグを引数に指定することで、指定したターム一覧ページのURLを取得する事ができる">
            <?php echo $term->obj->name;?>一覧を見る
          </button>
        </div>
      </div>
    </section>
    <section class="section-contents" id="company">
      <div class="wrapper">
<?php
$company_page = get_page_by_path('company');/*引数に固定ページのスラッグを指定することでそのページのオブジェクトを取得できる。
ここでは企業情報のオブジェクトを取得している。*/
$post = $company_page;
setup_postdata($post);
?>
        <span class="section-title-en"><?php the_field('english_title');?></span>
        <h2 class="section-title"><?php the_title();?></h2>
        <p class="section-lead">
          <?php echo get_the_excerpt();?>
        </p>
        <div class="section-buttons">
          <button type="button" class="button button-ghost" 
          onclick="javascript:location.href = '<?php echo esc_url(home_url('company'));?>';">
            <?php the_title()?>一覧を見る
          </button>
        </div>
      <?php wp_reset_postdata();?>
      </div>
    </section>
    <?php get_footer();?>