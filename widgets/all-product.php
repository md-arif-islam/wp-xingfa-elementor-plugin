<?php

class Elementor_AllProduct_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return "XingfaAllProduct";
	}

	public function get_title() {
		return __( "All Product • Xingfa", 'eletotallyunsigned' );
	}

	public function get_icon() {
		return 'far fa-window-frame';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'options_section',
			[
				'label' => __( 'Options', 'xingfaelementor' ),
			]
		);

		/*$this->add_control(
			'category',
			[
				'label'   => __( 'Category', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => ( 'slide-types' ),
				'default' => "",
			]
		);*/

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order by', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'date'  => __( 'Date', 'xingfaelementor' ),
					'title' => __( 'Title', 'xingfaelementor' ),
					'rand'  => __( 'Random', 'xingfaelementor' ),
				),
				'default' => "date",
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'ASC'  => __( 'Ascending', 'xingfaelementor' ),
					'DESC' => __( 'Descending', 'xingfaelementor' ),
				),
				'default' => "DESC",
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_section',
			[
				'label' => __( 'Advanced', 'xingfaelementor' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''            => __( 'Default', 'xingfaelementor' ),
					'flat'        => __( 'Flat', 'xingfaelementor' ),
					'description' => __( 'Flat with title and description', 'xingfaelementor' ),
					'carousel'    => __( 'Flat carousel with titles', 'xingfaelementor' ),
					'center'      => __( 'Center mode', 'xingfaelementor' ),
				),
				'default' => '',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''            => __( 'Default', 'xingfaelementor' ),
					'hide-arrows' => __( 'Hide Arrows', 'xingfaelementor' ),
					'hide-dots'   => __( 'Hide Dots', 'xingfaelementor' ),
					'hide'        => __( 'Hide', 'xingfaelementor' ),
				),
				'default' => '',
			]
		);

		$this->end_controls_section();

	}


	protected function render() {

		?>
        <div class="products-div">
            <div class="row products">

				<?php

				$args = array(
					'post_type'      => 'product',
					'posts_per_page' => -1,
					'paged'          => - 1,
					'orderby'        => "date",
					'order'          => "ASC",
				);


				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {

					while ( $query->have_posts() ) {

						$query->the_post();
						$img_url  = get_the_post_thumbnail_url( get_the_ID(), 'large' );
						$link     = get_permalink( get_the_ID() );

						?>
                        <div class="col-lg-4 col-md-6 col-sm-12 item">
                            <div class="products__content">
                                <a href="<?php echo esc_url($link) ?>">
                                    <img src="<?php echo esc_url( $img_url ) ?>" alt="">
                                    <h2 class="title"><?php the_title(); ?></h2>
                                    <?php the_excerpt(); ?>
                                </a>
                                <p class="view_more">
                                    <a href="<?php echo esc_url($link) ?>"
                                       class="view_more_btn">Explore More</a>
                                </p>
                            </div>
                        </div>

						<?php
					}
				}
				wp_reset_query();
				?>
                </div>
        </div>

		<?php

	}

}