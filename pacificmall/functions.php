<?php
function my_enqueue_scripts(){//スクリプト,スタイルシートを追加する
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'bundle_js', get_template_directory_uri(). '/assets/js/bundle.js', array() );
    wp_enqueue_style('my_styles',get_template_directory_uri().'/assets/css/styles.css',array());
}
add_action('wp_enqueue_scripts','my_enqueue_scripts');

register_nav_menus(//ナビゲーションメニューを設定する
    [
        'place_global' => 'グローバル',
        'place_footer' => 'フッターナビ',
    ]
    );


function get_main_title(){//タイトルを取得する
    if(is_singular('post'))://postを引数に渡すことで、通常の個別投稿でtrue,固定ページでfalseを返す
        $category_obj = get_the_category();//get_the_category()はオブジェクトの配列を返す。
        return $category_obj[0]->name;
    elseif(is_page()):
        return get_the_title();
    elseif(is_category() || is_tax())://カテゴリーアーカイブページまたはたくそのミーであれば true、そうでなければ false
        return single_cat_title();//カテゴリーまたはタグアーカイブがクエリされているときに使用すると、ページタイトル（カテゴリー名またはタグ名）を表示または返します。
    elseif(is_search())://is_searchは条件分岐タグで、検索結果ページが表示されていればTrueを返す
        return 'サイト内検索結果';
    elseif(is_404()):
        return 'ページが見つかりません';
    elseif(is_singular('daily_contribution')):
        global $post;
        $term_obj = get_the_terms($post->ID,'event');
        return $term_obj[0]->name;
    endif;
}

//子ページを取得する関数
function get_child_pages($number = -1,$specified_id = null){//関数の第二引数に特定の親ページのIDを指定した
    if(isset($specified_id))://第二引数が指定されていれば$parent_idに指定された値が格納される
        $parent_id = $specified_id;
    else:
        $parent_id = get_the_ID();//現在の投稿のIDを取得する ループの中で使う
    endif;
    $args = array(//$argsはargumentsの略引数を指す。
  'posts_per_page' => $number,//取得したい記事数を指定 -1は全件取得するの意味
  'post_type' => 'page',//取得したい投稿タイプを指定するpageは固定ページを意味する
  'orderby' => 'menu_order',//並べ替えの際に何を元に並べ替えるかを指定「投稿」→ページ属性→並び順を参照している
  'order' => 'ASC',//昇順か降順かを選べる
  'post_parent' => $parent_id,//表示したい子ページが紐づく親ページの記事IDを指定することで、その親ページの情報を取得することができる
);

$child_pages = new WP_Query($args);//固定ページ「企業情報」のすべての子ページの記事を対象とするため、WP_Queryクラスの引数に抽出条件を指定して、
// インスタンスchild_pagesを生成し、利用している。
 return $child_pages;
}

//アイキャッチ画像を利用できるようにする
add_theme_support('post-thumbnails');

//トップページのメイン画像用のサイズ設定
add_image_size('top',1077,622,true);

//地域貢献活動一覧用のサイズ設定
add_image_size('contribution',577,280,true);

//トップページの地域貢献活動にて使用している画像用のサイズ設定
add_image_size('front-contribution',255,189,true);

//企業情報・店舗情報一覧画像用のサイズ設定
add_image_size('common',465,252,true);

//各ページのメイン画像用のサイズ設定
add_image_size('detail',1100,330,true);

//検索一覧画像用のサイズ設定
add_image_size('search',168,168,true);

//各テンプレートごとのメイン画像を表示
function get_main_image(){
    if(is_page()||is_singular('daily_contribution')):
        $attachment_id = get_field('main_image');
        if(is_front_page()):
            return wp_get_attachment_image($attachment_id ,'top');
        else:
            return wp_get_attachment_image($attachment_id ,'detail');
        endif;
    elseif(is_category('news')||is_singular('post')):
        return '<img src="'.get_template_directory_uri().'/assets/images/bg-page-news.jpg"/>';
    elseif(is_search()||is_404()):
        return '<img src="'.get_template_directory_uri().'/assets/images/bg-page-search.jpg"/>';
    elseif(is_tax('event'))://カスタム分類のアーカイブページが表示されているか
        $term_obj = get_queried_object();//現在クエリされているオブジェクトを取得
        $image_id = get_field('event_image',$term_obj->taxonomy.'_'.$term_obj->term_id);
        /*タームのメタデータを取得する場合、get_field('フィールド名','カスタム分類のスラッグ_タームID')という形で
        引数を指定する必要がありますここではget_queried_object()で取得したタームのオブジェクトを使用して第二引数を指定しています */
        return wp_get_attachment_image($image_id,'detail');
    else:
        return '<img src="'.get_template_directory_uri().'/assets/images/bg-page-dummy.png"/>';
    endif;
}

//特定の記事を抽出する関数
function get_specific_posts($post_type,$taxonomy = null,$term = null,$number=-1){
    if ( ! $term ):
		$terms_obj = get_terms( 'event' );
		$term = wp_list_pluck( $terms_obj, 'slug' );
	endif;
    $args =[
        'post_type' => $post_type,
        'tax_query' => [
            [
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term,
            ],
        ],
        'posts_per_page' => $number,
    ];
    $specific_posts = new WP_Query($args);
    return $specific_posts;
}

function cms_excerpt_more(){//抜粋文の最後に付く文字列を変更します
    return'...';
}
add_filter('excerpt_more','cms_excerpt_more');

function cms_excerpt_length() {//文字数をWP Multibyte Patch 標準の１１０文字から80文字に変更します
	return 80;
}
add_filter( 'excerpt_mblength', 'cms_excerpt_length' );

//抜粋機能を固定ページに使えるよう設定
add_post_type_support('page','excerpt');

function get_flexible_excerpt($number){
    /*引数に指定した文字数を抜粋または本文から取得する独自のテンプレートタグとして定義しています
    関数内では、抜粋分を取得して$valueという変数に格納し、その抜粋文を$wp_trim_wordsというテンプレートタグを
    使用して長さを調整しています。*/
    $value = get_the_excerpt();
    $value = wp_trim_words($value,$number,'...');
    /*wp_trim_words()第一引数に文字列、第二引数にget_flexibleexcerpt関数の引数に指定された数値、
    第三引数に抜粋文の最後に表示する内容を指定しています */
    return $value;
}

//get_the_excerptで取得する文字列に改行タグを挿入
function apply_excerpt_br($value){
    return nl2br($value);
}
add_filter('get_the_excerpt','apply_excerpt_br');

//ウィジェット機能を有効化
function theme_widgets_init(){
    register_sidebar([
        'name'=>'サイドバーウィジェットエリア',//ウィジェットの名前
        'id'=>'primary-widget-area',//ウィジェットのID
        'description'=>'固定ページのサイドバー',//ウィジェットエリアの説明
        'before_widget'=>'<aside class="side-inner">',//ウィジェットエリアの前に出力されるHTML
        'after_widget'=>'</aside>',//ウィジェットエリアの後に出力されるHTML
        'before_title'=>'<h4 class="title">',//ウィジェットが出力するタイトルの前に出力されるHTML
        'after_title'=>'</h4>',//ウィジェットが出力するタイトルの後に出力されるHTML
    ]);
}
add_action('widgets_init','theme_widgets_init');


//メイン画像上にテンプレート毎の英語タイトルを表示

function get_main_en_title(){
    if(is_category()):
        $term_obj = get_queried_object();
        $english_title = get_field('english_title',$term_obj->taxonomy.'_'.$term_obj->term_id);
        return $english_title;
    elseif(is_singular('post')):
        $term_obj = get_the_category();
        $english_title = get_field('english_title',$term_obj[0]->taxonomy.'_'.$term[0]->term_id);
        return $english_title;
    elseif(is_page()||is_singular('daily_contribution')):
        return get_field('english_title');
    elseif(is_search()):
        return 'Search Result';
    elseif(is_404()):
        return '404 Not Found';
    elseif(is_tax()):
        $term_obj = get_queried_object();
        $english_title = get_field('english_title',$term_obj->taxonomy.'_'.$term_obj->term_id);
        return $english_title;
    endif;
}
?>
