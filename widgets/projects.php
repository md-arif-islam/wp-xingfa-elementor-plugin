<?php

class Elementor_Project_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return "XingfaProjects";
	}

	public function get_title() {
		return __( "Projects • Xingfa", 'eletotallyunsigned' );
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
        <div class="projects-div">
            <div class="row projects">

				<?php

				$args = array(
					'post_type'      => 'project',
					'posts_per_page' => 2,
					'paged'          => - 1,
					'orderby'        => "date",
					'order'          => "DESC",
					'tax_query'      => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'project-types',
							'field'    => 'slug',
							'terms'    => "featured"
						)
					),
				);


				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {

					while ( $query->have_posts() ) {

						$query->the_post();
						$img_url  = get_the_post_thumbnail_url( get_the_ID(), 'large' );
						$link     = get_permalink( get_the_ID() );
						$location = get_field( 'project_location', get_the_ID() );

						?>

                        <div class="col-md-6">
                            <div class="project">
                                <a href="<?php echo esc_url( $link ) ?>">
                                    <img class="img-fluid" src="<?php echo esc_url( $img_url ) ?>" alt="">
                                </a>
                                <div class="title">
                                    <h2><?php echo the_title() ?></h2>
                                </div>
                                <div class="location">
                                    <h5>
                                        <img src="<?php echo plugins_url( 'assets/img/fluent_location-24-regular.png', dirname( __FILE__ ) ) ?>"
                                             alt=""><span><?php echo esc_html( $location ); ?></span></h5>

                                </div>
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