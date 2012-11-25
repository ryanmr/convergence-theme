<?php
/**
 * Template Name: Front
 *
 * This a custom template for the front page.
 * This is the new (late 2012) front page. This front page will display the Villain block,
 * a large 1-by-3 row of block images promoting three recent episodes.
 * Below that, there is a 3-by-3 grid of episodes in posting order,
 * and below that, the fridge or auxillary episodes are listed with the show more link.
 */

get_header(); // Loads the header.php template. ?>

    <div id="villain">
        <!-- intentionally no wrapping -->

<?php
   $v_args = array(
        "post_type" => "episode",
        "posts_per_page" => 3,
    );
    $v_args = convergence_exclude_category('tf', $v_args);
    $v_args['tax_query'] = array(convergence_exclude_episode_attributes('hidden'));
    $v_loop = new WP_Query($v_args);
    $villain_episodes = array();
    while ($v_loop->have_posts()): $v_loop->the_post();
    $villain_episodes[] = get_the_ID();
?>
        <?php
            $f_img = get_the_image(array('size'=>'large', 'link_to_post'=>false, 'format'=>'array' ));
        ?>
        <div class="feature" style="background-image: url('<?php echo $f_img['url']; ?>');">
            <a class="cover" href="<?php echo get_permalink() ?>">
                <div class="mask">
                    <?php
                        $show_title = get_the_title();
                        $show_title_length = strlen($show_title);
                        $show_title_class = "";
                        if ($show_title_length > 24) {
                            $show_title_class = 'long-title ';
                        } else if ( $show_title_length > 35 ) {
                            $show_title_class = 'epic-title';
                        }
                    ?>
                    <h2 class="show-title <?php echo $show_title_class; ?>"><?php echo $show_title; ?></h2>

                      <h3 class="show-name">
                        <span class="name">
                        <?php $category = get_the_category(); echo($category[0]->name); ?></span>
                        <span class="sep">#</span><span class="number"><?php echo( get_episode_number( get_permalink() ) ); ?></span>
                      </h4>

                    <h4 class="show-date">
                    <?php echo get_the_date("F j") ?>
                    <?php
                        convergence_new_episode(7);
                    ?>
                    </h5>

                </div>
            </a>
        </div>

    <?php endwhile; ?>


        <!-- celebrate #villain -->
    </div>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content home">
                
                <div id="showboard">
                    <div id="showboard-wrapper">
                    
                    <!-- new front page events coming soon! -->

                <?php
                    $showboard_top_arguments = array(
                        "post_type" => "episode",
                        "posts_per_page" => 6,
                        'post__not_in' => $villain_episodes
                    );
                    $showboard_top_arguments = convergence_exclude_category('tf', $showboard_top_arguments);
                    $showboard_top_arguments['tax_query'] = array(convergence_exclude_episode_attributes('hidden'));
                    $loop_top = new WP_Query($showboard_top_arguments);
                ?>

                    <div id="top-shelf">
                        <?php while ($loop_top->have_posts()): $loop_top->the_post(); ?>
                        <?php get_template_part('showboard-loop'); ?>
                        <?php endwhile; ?>
                    </div>

                    <?php /* ============================================================= */ ?>
                    <!-- #top-shelf -->

                <?php
                    $showboard_bottom_arguments = array(
                        "post_type" => "episode",
                        "posts_per_page" => 2,
                        'category_name' => 'tf'
                    );
                    $showboard_bottom_arguments['tax_query'] = array(convergence_exclude_episode_attributes('hidden'));
                    $loop_bottom = new WP_Query($showboard_bottom_arguments);
                ?>

                    <div id="bottom-shelf">
                        <?php while ($loop_bottom->have_posts()): $loop_bottom->the_post(); ?>
                        <?php get_template_part('showboard-loop'); ?>
                        <?php endwhile; ?>

                        <div class="episode-block overflow">
                            <h3><a href="<?php echo get_bloginfo('site_url'); ?>/latest">More Episodes &raquo;</a></h3>
                        </div>

                    </div><!-- #bottom-shelf -->

                    </div><!-- #showboard-wrapper -->
                </div><!-- #showboard -->
                
            </div><!-- .content .hfeed -->
        </div><!-- #content-wrapper -->
    </div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>
