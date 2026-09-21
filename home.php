<?php
/**
 * Joan Valera Creative
 * Blog — Todos los artículos
 *
 * Nota: en WordPress, home.php es la plantilla que se usa para la
 * "página de entradas" (Ajustes > Lectura > tu página estática y una
 * página de entradas por separado), es decir, /blog/articulos/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="jv-blog-archive jv-blog-all">

	<!-- ==================================================
	     CABECERA DEL BLOG
	     ================================================== -->

	<header class="jv-blog-header">

		<span class="jv-blog-eyebrow">
			BLOG
		</span>

		<h1 class="jv-blog-title">
			ARTÍCULOS
		</h1>

		<p class="jv-blog-description">
			Conocimiento, inspiración y cultura visual desde la mirada de un fotógrafo profesional.
		</p>

	</header>


	<!-- ==================================================
	     CATEGORÍAS
	     ================================================== -->

	<nav class="jv-blog-categories" aria-label="Categorías del blog">

		<?php $blog_page_url = get_permalink( get_option( 'page_for_posts' ) ); ?>

		<a
			class="jv-blog-category-link is-active"
			href="<?php echo esc_url( $blog_page_url ); ?>"
			aria-current="page"
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
			?>

			<a
				class="jv-blog-category-link"
				href="<?php echo esc_url( get_category_link( $term->term_id ) ); ?>"
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

				// Tarjeta compartida con category.php — ver functions.php > jv_render_blog_card().
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
				Todavía no hay artículos publicados.
			</p>

		</div>

	<?php endif; ?>

</main>

<?php
get_footer();
