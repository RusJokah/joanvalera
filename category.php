<?php
/**
 * Joan Valera Creative
 * Blog — Archivo de categoría
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_category = get_queried_object();
?>

<main class="jv-blog-archive jv-blog-category">

	<!-- ==================================================
	     CABECERA DE CATEGORÍA
	     ================================================== -->

	<header class="jv-blog-header">

		<span class="jv-blog-eyebrow">
			CATEGORÍA
		</span>

		<h1 class="jv-blog-title">
			<?php echo esc_html( $current_category->name ); ?>
		</h1>

		<?php if ( ! empty( $current_category->description ) ) : ?>

			<div class="jv-blog-description">
				<?php echo wp_kses_post( wpautop( $current_category->description ) ); ?>
			</div>

		<?php endif; ?>

	</header>


	<!-- ==================================================
	     CATEGORÍAS
	     ================================================== -->

	<nav class="jv-blog-categories" aria-label="Categorías del blog">

		<?php $blog_page_url = get_permalink( get_option( 'page_for_posts' ) ); ?>

		<a
			class="jv-blog-category-link"
			href="<?php echo esc_url( $blog_page_url ); ?>"
		>
			TODOS
		</a>

		<?php
		$categories = jv_get_blog_categories();

		foreach ( $categories as $category ) :

			$term = get_category_by_slug( $category['slug'] );

			if ( ! $term ) {
				continue;
			}

			$is_current = (
				(int) $term->term_id ===
				(int) $current_category->term_id
			);
			?>

			<a
				class="jv-blog-category-link <?php echo $is_current ? 'is-active' : ''; ?>"
				href="<?php echo esc_url( get_category_link( $term->term_id ) ); ?>"
				<?php echo $is_current ? 'aria-current="page"' : ''; ?>
			>
				<?php echo esc_html( $category['name'] ); ?>
			</a>

		<?php endforeach; ?>

	</nav>


	<!-- ==================================================
	     GRID DE ARTÍCULOS
	     ================================================== -->

	<?php if ( have_posts() ) : ?>

		<div class="jv-blog-grid">

			<?php
			while ( have_posts() ) :
				the_post();

				// Tarjeta compartida con home.php — ver functions.php > jv_render_blog_card().
				jv_render_blog_card();

			endwhile;
			?>

		</div>


		<!-- ==================================================
		     PAGINACIÓN
		     ================================================== -->

		<?php
		$pagination = paginate_links(
			array(
				'type'      => 'array',
				'mid_size'  => 2,
				'end_size'  => 1,
				'prev_text' => '←',
				'next_text' => '→',
			)
		);

		if ( $pagination ) :
			?>

			<nav
				class="jv-blog-pagination"
				aria-label="Paginación de artículos"
			>

				<?php foreach ( $pagination as $page ) : ?>

					<?php echo wp_kses_post( $page ); ?>

				<?php endforeach; ?>

			</nav>

		<?php endif; ?>


	<?php else : ?>

		<div class="jv-blog-empty">

			<p>
				Todavía no hay artículos en esta categoría.
			</p>

		</div>

	<?php endif; ?>

</main>

<?php
get_footer();
