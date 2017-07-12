<?php
/*
Plugin Name: Memory Game (Memorama)
Plugin URI: http://develoteca.com/memorama
Description: Memory Game (Memorama) use shortcode [memorygame] in pages (para distraer a nuestros visitas).
Version: 1.0
Author: Oscar Uh Pérez
Author URI: http://develoteca.com
*/
function _post_type_memorygame() {
	register_post_type( 'memorygame',
                array(
                'labels' => array(
				'name' => __( 'Memory Game' ),
				'singular_name' => __( 'Memory' ),
				'add_new'=>__('New Imagen'),
                                'add_new_item' => __( 'Add New Image' )
			         ),
                'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'rewrite' => true,
				'hierarchical' => true,
				'menu_position' => 5,
				'supports' => array(
						'title',
						'thumbnail')
					)
				);
}

add_action('init', '_post_type_memorygame');

define('PLUGIN_URL', plugin_dir_url( __FILE__ ));

// add jquery of memorygame
function jquery_init_memorygame() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jquery_init_memorygame');


/**
* The shortcode in memorygame
*/

add_shortcode('memorygame','memory_game_shortcode');

function memory_game_shortcode(){
		/*
		* enqueue_script of css
		*/
		wp_register_style( 'memorygame-style', plugin_dir_url( __FILE__).'css/memorygame.css' );
		wp_enqueue_style( 'memorygame-style' );
		
		?>
		
		<!-- display status and reset game -->
		<div id="boxbutton">
            <span class="link">
                <span id="count">0</span>
                Click
            </span>&nbsp;
            
			<a href="javascript:" class="link" onclick="resetGame();">
				Reset
			</a>
        </div>
		<!-- the cards to display -->
        <div id="boxcard">
		
			<?php 
			$query_memory = new WP_Query( 'post_type=memorygame&posts_per_page=-1' );
			$contador_card=1;
			
			if ($query_memory->have_posts()) :
				while ($query_memory->have_posts()) :
					$query_memory->the_post();
					if ( has_post_thumbnail() ) : ?>
							<div id="card<?php echo $contador_card;?>">
								<?php the_post_thumbnail(array(100,100)); ?>
							</div>
						<?php 
						$contador_card++;
					endif;
				endwhile;
				
			endif; 	
			
			
			if ($query_memory->have_posts()) : 
				while ($query_memory->have_posts()) :
					$query_memory->the_post();
					if ( has_post_thumbnail() ) : ?>
							<div id="card<?php echo $contador_card;?>">
								<?php the_post_thumbnail(array(100,100)); ?>
							</div>
							<?php $contador_card++;
					endif; 
				endwhile;
				
			endif; 	
			
			?>  
	    </div>
		<!-- the count of cards -->
		<input type="hidden" name="total_images" id="total_images" value="<?php echo $query_memory->post_count;?>"/>
		
		<?php
		/*
		* enqueue_script of javascript 
		*/
		wp_reset_query();
		
		wp_enqueue_script(
		'memorygame-script-js',
		plugins_url('/js/memorygame.js', __FILE__),
		array('jquery')
		);
		
	}
?>