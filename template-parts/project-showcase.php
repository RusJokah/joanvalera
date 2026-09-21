<?php
/**
 * Joan Valera - Project Showcase Template.
 *
 * Incluido desde jv_project_shortcode() en functions.php.
 *
 * Variable disponible:
 * @var array $project Datos del proyecto (ver jv_get_project_data()).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $project ) || ! is_array( $project ) ) {
	return;
}


/*
|--------------------------------------------------------------------------
| Project image
|--------------------------------------------------------------------------
*/

$image_url = '';

if ( ! empty( $project['image_id'] ) ) {

	$image_url = wp_get_attachment_image_url(
		absint( $project['image_id'] ),
		'full'
	);

}


/*
|--------------------------------------------------------------------------
| Project variant
|--------------------------------------------------------------------------
*/

$variant = '';

if ( ! empty( $project['variant'] ) ) {

	$variant = sanitize_html_class( $project['variant'] );

}


/*
|--------------------------------------------------------------------------
| CTA label
|--------------------------------------------------------------------------
*/

$cta_label = 'VER PROYECTO';

if ( ! empty( $project['cta_label'] ) ) {

	$cta_label = sanitize_text_field( $project['cta_label'] );

}


/*
|--------------------------------------------------------------------------
| Showcase classes
|--------------------------------------------------------------------------
*/

$showcase_classes = 'jv-project';

if ( $variant ) {

	$showcase_classes .= ' jv-project--' . $variant;

}


/*
|--------------------------------------------------------------------------
| Accessibility label
|--------------------------------------------------------------------------
*/

$aria_label_text = 'Ver proyecto ' . $project['title'];

if ( ! empty( $project['cta_label'] ) ) {

	$aria_label_text = $cta_label . ' ' . $project['title'];

}
?>


<a
	class="<?php echo esc_attr( $showcase_classes ); ?>"
	href="<?php echo esc_url( home_url( $project['url'] ) ); ?>"
	aria-label="<?php echo esc_attr( $aria_label_text ); ?>"
	data-project-url="<?php echo esc_url( home_url( $project['url'] ) ); ?>"
>


	<div
		class="jv-project__image"
		<?php if ( $image_url ) : ?>
			style="background-image: url('<?php echo esc_url( $image_url ); ?>');"
		<?php endif; ?>
		aria-hidden="true"
	></div>


	<div
		class="jv-project__overlay"
		aria-hidden="true"
	></div>


	<div class="jv-project__content">


		<div class="jv-project__meta">

			<span>
				<?php echo esc_html( $project['category'] ); ?>
			</span>

		</div>


		<h2 class="jv-project__title">

			<?php echo esc_html( $project['title'] ); ?>

		</h2>


		<div class="jv-project__details">

			<span>
				<?php echo esc_html( $project['city'] ); ?>
			</span>

			<span aria-hidden="true">
				·
			</span>

			<span>
				<?php echo esc_html( $project['year'] ); ?>
			</span>

		</div>


		<div class="jv-project__cta">

			<span>
				<?php echo esc_html( $cta_label ); ?>
			</span>

			<span
				class="jv-project__arrow"
				aria-hidden="true"
			>
				→
			</span>

		</div>


	</div>

</a>
