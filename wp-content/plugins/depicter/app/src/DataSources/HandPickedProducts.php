<?php
namespace Depicter\DataSources;

use Averta\Core\Utility\Data;

class HandPickedProducts extends Posts {

    /**
	 * Source name
	 *
	 * @var string
	 */
	protected $type = 'wcHandPickedProduct';

    /**
	 * Input params to filter source result
	 *
	 * @var array
	 */
	protected $params = [
		'postType' => 'product',
		'excerptLength' => 100,
		'linkSlides' => true,
		'orderBy' => 'date',
		'order' => 'DESC',
		'imageSource' => 'featured',
		'productIds' => '',
		'excludeNonThumbnail' => true,
        'inStockOnly' => true,
	];

    /**
	 * Retrieves the list of records based on query params
	 *
	 * @param $args
	 *
	 * @return \WP_Query
	 */
	protected function getRecords( $args ){

		$queryArgs = [
		    'post_type'       => $args['postType'],
		    'order'           => $args['order'],
		    'orderBy'         => $args['orderBy'],
		    'post__in'        => $args['productIds'],
		    'tax_query'       => [],
			'meta_query'      => []
	    ];

		if( Data::isTrue( $args['excludeNonThumbnail'] ) ){
			$queryArgs['meta_query'][] = [
	    		'key'     => '_thumbnail_id',
                'compare' => 'EXISTS'
		    ];
		}

	    if ( !empty( $args['excerptLength'] ) ) {
	    	add_filter( 'excerpt_length', function () use ($args) {
	    		return $args['excerptLength'];
		    });
	    }

        if ( Data::isTrue( $args['inStockOnly'] ) ) {
            $queryArgs['meta_query'][] = [
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            ];
        }

		return new \WP_Query( $queryArgs );
	}

    /**
	 * Renders preview for query params
	 *
	 * @param array $args
	 *
	 * @return array
	 */
    public function previewRecords( array $args = [] ) {
		$args = $this->prepare( $args );
		$availableRecords = $this->getRecords( $args );

		$records = [];

		if ( $availableRecords && $availableRecords->have_posts() ) {

			foreach( $availableRecords->posts as $post ) {
				$featuredImage = [];
				if( has_post_thumbnail( $post->ID ) ){
					$featuredImageId = get_post_thumbnail_id( $post->ID );
					$imageInfo = wp_get_attachment_image_src( $featuredImageId, 'full' );
					$featuredImage = [
						'id'     => $featuredImageId,
						'url'    => $imageInfo[0]  ?: '',
						'width'  => $imageInfo[1] ?: '',
						'height' => $imageInfo[2] ?: '',
					];
				}
				$postInfo = [
					'id'        => $post->ID,
					'title'     => get_the_title( $post->ID ),
					'url'       => get_permalink( $post->ID ),
					'featuredImage' => $featuredImage,
					'date'      => get_the_date('', $post->ID ),
					'excerpt'   => get_the_excerpt( $post->ID ),
					'author' => [
						'name' => get_the_author_meta( 'display_name', $post->post_author ),
						'page' => get_author_posts_url( $post->post_author ),
					],
					'content'   => get_the_content(null, false, $post->ID ),
					'taxonomies'=> []
				];

				$taxonomies = get_object_taxonomies( $args['postType'], 'objects' );

				if ( !empty( $taxonomies ) ) {
					foreach( $taxonomies as $taxonomySlug => $taxonomy ) {
						$taxonomyInfo = [
							"id"    => $taxonomySlug,
							"label" => $taxonomy->label,
							"terms" => []
						];

						if ( $terms = wp_get_post_terms( $post->ID, $taxonomySlug ) ) {
							foreach( $terms as $term ) {
								$taxonomyInfo[ "terms" ][] = [
									'id' => $term->term_id,
							        'value' => $term->slug,
							        'label' => $term->name,
									'link' => get_term_link( $term->term_id )
								];
							}
						}

						$postInfo['taxonomies'][] = $taxonomyInfo;
					}
				}

				$records[] = $postInfo;
			}
		}

		return $records;
    }

	/**
	 * Get list of tags and their values for the query result
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function getRecordsWithTags( array $args = [] ){
		$args = $this->prepare( $args );
		$availableRecords = $this->getRecords( $args );

		$records = [];
		if ( $availableRecords && $availableRecords->have_posts() ) {

			foreach( $availableRecords->posts as $post ) {

			}
		}

		return $records;
	}
}
