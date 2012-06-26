<?php
/**
 * Template Name: Front
 *
 * This a custom template for the front page.
 * This setups the Hero with the banner for the newest show and then 3by3 grid of recent shows.
 */

get_header(); // Loads the header.php template. ?>

    <div id="hero-container">
        <div id="hero-wrapper">
        
            <?php do_atomic('before_hero'); ?>
        
            <?php
                    $hero_arguments = array(
                        "post_type" => "episode",
                        "posts_per_page" => 1,
                    );
                    $hero_arguments = convergence_exclude_category('tf', $hero_arguments);
                    $hero_loop = new WP_Query($hero_arguments);
                    $hero_id = 0;
                    
            if ($hero_loop->have_posts()):
                while ($hero_loop->have_posts()):
                    $hero_loop->the_post();
                    $hero_id = get_the_ID();
            ?>
        
            <div id="hero">
                        
                <div class="hero-meta">
                
                  <h2 class="show-title"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h2>
                  
                  <h3 class="show-name">
                  <span class="name"><?php the_category(' '); ?></span> <span class="number">#<?php echo( get_episode_number( get_permalink() ) ); ?></span>
                  </h3>
                  
                  <h4 class="show-date"><a href="<?php echo get_permalink() ?>"> <?php echo get_the_date("F j"); ?></a></h4>
                  
                  <div class="episode-description">
                    <?php the_excerpt(); ?>
                  </div>
                  
                </div>
                
                <div class="hero-image">
                    <?php get_the_image( array('size'=>'medium') ); ?>
                </div>
            
            </div>
            <?php endwhile; endif; ?>
            
            <?php do_atomic('after_hero'); ?>
            
        </div>
    </div>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content home">
                
                <div id="showboard">
                    <div id="showboard-wrapper">
                    
                <?php
                    $showboard_top_arguments = array(
                        "post_type" => "episode",
                        "posts_per_page" => 6,
                        'post__not_in' => array($hero_id)
                    );
                    $showboard_top_arguments = convergence_exclude_category('tf', $showboard_top_arguments);
                    $loop_top = new WP_Query($showboard_top_arguments);
                ?>

                    <div id="top-shelf">
                        <?php while ($loop_top->have_posts()): $loop_top->the_post(); ?>
                        <?php get_template_part('showboard-loop'); ?>
                        <?php endwhile; ?>
                    </div><!-- #top-shelf -->

                <?php
                    $showboard_bottom_arguments = array(
                        "post_type" => "episode",
                        "posts_per_page" => 3,
                        'category_name' => 'tf'
                    );
                    $loop_bottom = new WP_Query($showboard_bottom_arguments);
                ?>

                    <div id="bottom-shelf">
                        <?php while ($loop_bottom->have_posts()): $loop_bottom->the_post(); ?>
                        <?php get_template_part('showboard-loop'); ?>
                        <?php endwhile; ?>

                        <div class="episode-block overflow">
                            <h3><a href="<?php echo get_bloginfo('site_url'); ?>/latest">More New Episodes &raquo;</a></h3>
                        </div>

                    </div><!-- #bottom-shelf -->

                    </div><!-- #showboard-wrapper -->
                </div><!-- #showboard -->
                
            </div><!-- .content .hfeed -->
        </div><!-- #content-wrapper -->
    </div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>
