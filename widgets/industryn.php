<?php

class Elementor_IndustryNews_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return "XingfaIndustryNews";
	}

	public function get_title() {
		return __( "industry News • Xingfa", 'eletotallyunsigned' );
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

		if (! function_exists('xingfa_get_categories')) {
			function xingfa_get_categories($category)
			{
				$categories = get_categories(array(
					'taxonomy' => $category,
				));

				$array = array(
					'' => esc_html__('All', 'mfn-opts'),
				);

				foreach ($categories as $cat) {
					if (is_object($cat)) {
						$array[$cat->slug] = $cat->name;
					}
				}

				return $array;
			}
		}

		$this->add_control(
			'category',
			[
				'label'   => __( 'Category', 'xingfaelementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => xingfa_get_categories( 'industry_news-types' ),
				'default' => "",
			]
		);

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

		$this->add_control(
			'post_per_page',
			[
				'label' => __( 'Post Per Page', 'xingfaelementor' ),
				'type'  => \Elementor\Controls_Manager::NUMBER,
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
        <div class="row events">

			<?php

			// query args

			$settings      = $this->get_settings_for_display();
			$post_per_page = $this->get_settings( "post_per_page" );
			$order         = $this->get_settings( "order" );
			$orderby       = $this->get_settings( "orderby" );
			$post_cat      = $this->get_settings( "category" );


			if ( "featured" == $post_cat ) {
				$args = array(
					'post_type'      => 'industry_news',
					'posts_per_page' => $post_per_page,
					'paged'          => - 1,
					'orderby'        => $order,
					'order'          => $orderby,
					'tax_query'      => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'industry_news-types',
							'field'    => 'slug',
							'terms'    => "featured"
						)
					),
				);
			} else {
				$args = array(
					'post_type'      => 'industry_news',
					'posts_per_page' => $post_per_page,
					'paged'          => - 1,
					'orderby'        => $order,
					'order'          => $orderby,

				);
			}


			$query = new WP_Query();
			$query->query( $args );

			if ( $query->have_posts() ) {

				$number = 0;

				while ( $query->have_posts() ) {

					$number = $number + 1;
					$query->the_post();
					$img_url = get_the_post_thumbnail_url( get_the_ID(), 'news' );
					$link    = get_permalink( get_the_ID() );

					?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">

                        <div class="event">
                            <a href="<?php echo esc_url( $link ) ?>">
                                <img class="img-fluid"
                                     src="<?php echo $img_url ?>"
                                     alt="<?php the_title() ?>">
                            </a>
                            <div class="date">
                                <p><?php echo get_the_date( 'd M Y' ); ?></p>
                            </div>
                            <div class="title">
                                <h2><?php the_title() ?></h2>
                            </div>
                        </div>
                    </div>
					<?php
				}
			}
			wp_reset_query();
			?>

        </div>
		<?php

	}

}