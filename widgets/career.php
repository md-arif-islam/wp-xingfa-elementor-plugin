<?php

class Elementor_Career_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return "XingfaCareer";
	}

	public function get_title() {
		return __( "Career • Xingfa", 'eletotallyunsigned' );
	}

	public function get_icon() {
		return 'far fa-window-frame';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function render() {

		?>
        <div class="row career">
            <div class="col-md-3 col-sm-12">
                <div class="career-cat-tax">
                    <div class="career-cat">
                        <ul class="career-cat-btns">
                            <li class="active" data-filter="*" id="a1">All</li>
							<?php
							$args       = array(
								'hide_empty' => 1,
								'order'      => 'asc',
								'parent'     => 0
							);
							$categories = get_terms( 'career-types', $args );

							foreach ( $categories as $category ) {

								?>
                                <li data-filter=".<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
							<?php } ?>
                        </ul>
                    </div>
                    <div class="career-tax">
                        <ul class="career-tax-btns">
							<?php
							$args  = array(
								'hide_empty' => 1,
								'order'      => 'asc',
								'parent'     => 0
							);
							$tags  = get_terms( 'career-tags', $args );
							$count = 0;
							foreach ( $tags as $tag ) {
								$count ++
								?>
                                <li data-filter=".<?php echo $tag->slug; ?>"><?php echo $tag->name . " (" . $tag->count . ")"; ?></li>
							<?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12 ">
                <div class="career-items">
                    <div class="row grid">
						<?php

						$args = array(
							'post_type'      => 'career',
							'posts_per_page' => - 1,
							'paged'          => - 1,
							'orderby'        => "date",
							'order'          => "DESC"
						);


						$query = new WP_Query();
						$query->query( $args );

						if ( $query->have_posts() ) {

							while ( $query->have_posts() ) {

								$query->the_post();
								$location = get_field( 'career_location', get_the_ID() );
								?>

                                <div class="col-lg-4 col-md-6 col-sm-6 d-flex align-items-stretch <?php
								$types = wp_get_object_terms( get_the_ID(), "career-types" );
								$tags  = wp_get_object_terms( get_the_ID(), "career-tags" );
								foreach ( $types as $type ) {
									echo $type->slug . " ";
								}
								foreach ( $tags as $tag ) {
									echo $tag->slug . " ";
								}
								?>">
                                    <div class="career-item">
                                        <?php
											$types = wp_get_object_terms( get_the_ID(), "career-types" );
											foreach ( $types as $type ) {
												echo "<p>{$type->name}</p>";
											} ?>
                                        <h1><?php the_title(); ?></h1>
                                        <h4><?php echo esc_html( $location ) ?></h4>

                                        <a href="">Apply Now</a>
                                    </div>
                                </div>

								<?php
							}
						}
						wp_reset_query();
						?>
                    </div>
                </div>
            </div>
        </div>

		<?php

	}


}