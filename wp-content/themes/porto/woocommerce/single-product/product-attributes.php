<?php
/**
 * Product attributes
 *
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="table table-striped shop_attributes">
	<?php if ( $display_dimensions && $product->has_weight() ) : ?>
		<tr>
			<th><?php esc_html_e( 'Weight', 'porto' ); ?></th>
			<td class="product_weight"><?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $display_dimensions && $product->has_dimensions() ) : ?>
		<tr>
			<th><?php esc_html_e( 'Dimensions', 'porto' ); ?></th>
			<td class="product_dimensions"><?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?></td>
		</tr>
	<?php endif; ?>

	<?php foreach ( $attributes as $attribute ) : ?>
		<tr>
			<th><?php echo wc_attribute_label( $attribute->get_name() ); ?></th>
			<td>
			<?php
				$values = array();

			if ( $attribute->is_taxonomy() ) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

				foreach ( $attribute_values as $attribute_value ) {
					$value_name = esc_html( $attribute_value->name );

					if ( $attribute_taxonomy->attribute_public ) {
						$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
					} else {
						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ( $values as &$value ) {
					$value = make_clickable( esc_html( $value ) );
				}
			}

				echo apply_filters( 'woocommerce_attribute', function_exists( 'porto_shortcode_format_content' ) ? porto_shortcode_format_content( implode( ', ', $values ) ) : implode( ', ', $values ), $attribute, $values );
			?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
