<?php
/**
** A base module for [select] and [select*]
**/

/* form_tag handler */

add_action( 'wpcf7_init', 'wpcf7cms_add_form_tag_select', 10, 0 );

function wpcf7cms_add_form_tag_select() {
	wpcf7_add_form_tag( array( 'select', 'select*' ),
		'wpcf7cms_select_form_tag_handler',
		array(
			'name-attr' => true,
			'selectable-values' => true,
		)
	);
}

function wpcf7cms_select_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}

	$atts = array();

	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	if ( $validation_error ) {
		$atts['aria-invalid'] = 'true';
		$atts['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts['aria-invalid'] = 'false';
	}

	$multiple = $tag->has_option( 'multiple' );
	$include_blank = $tag->has_option( 'include_blank' );
	$first_as_label = $tag->has_option( 'first_as_label' );

	if ( $tag->has_option( 'size' ) ) {
		$size = $tag->get_option( 'size', 'int', true );

		if ( $size ) {
			$atts['size'] = $size;
		} elseif ( $multiple ) {
			$atts['size'] = 4;
		} else {
			$atts['size'] = 1;
		}
	}

	if ( $data = (array) $tag->get_data_option() ) {
		$tag->values = array_merge( $tag->values, array_keys( $data ) );
		$tag->labels = array_merge( $tag->labels, array_values( $data ) );
	}

	$values = $tag->values;
	$labels = $tag->labels;

	$default_choice = $tag->get_default_option( null, array(
		'multiple' => $multiple,
		'shifted' => $include_blank,
	) );

	if ( $include_blank
	or empty( $values ) ) {
		array_unshift( $labels, '---' );
		array_unshift( $values, '' );
	} elseif ( $first_as_label ) {
		$values[0] = '';
	}

	$values = apply_filters( 'wpcf7_form_tag_values', $values, $tag);
	$values = apply_filters( 'wpcf7_form_tag_values_select', $values, $tag);

	$labels = apply_filters( 'wpcf7_form_tag_labels', $labels, $tag);
	$labels = apply_filters( 'wpcf7_form_tag_labels_select', $labels, $tag);

	$html = '';
	$hangover = wpcf7_get_hangover( $tag->name );

    $default_values = $hangover ? $hangover : $default_choice;
	$default_values = apply_filters( 'wpcf7_default_values', $default_values, $tag );
	$default_values = apply_filters( 'wpcf7_default_values_select', $default_values, $tag );

	foreach ( $values as $key => $value ) {
		$selected = in_array( $value, (array) $default_values, true );

		$item_atts = array(
			'value' => $value,
			'selected' => $selected ? 'selected' : '',
		);

		$item_atts = wpcf7_format_atts( $item_atts );

		$label = isset( $labels[$key] ) ? $labels[$key] : $value;

		$html .= sprintf( '<option %1$s>%2$s</option>',
			$item_atts, esc_html( $label ) );
	}

	if ( $multiple ) {
		$atts['multiple'] = 'multiple';
	}

	$atts['name'] = $tag->name . ( $multiple ? '[]' : '' );

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
		sanitize_html_class( $tag->name ), $atts, $html, $validation_error
	);

	return $html;
}
