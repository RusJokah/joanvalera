<?php
/**
 * Hello Elementor Child Theme
 * Joan Valera Creative
 *
 * Índice de este archivo:
 * 1. Estilos del tema padre e hijo
 * 2. Project Showcase (shortcode [jv_project])
 * 3. Transiciones globales de página
 * 4. Portfolio Gallery (ajustes visuales)
 * 5. Blog: categorías, consulta principal, assets, tarjeta compartida
 * 6. Blog: shortcode de últimos artículos ([jv_blog_posts])
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * =========================================================
 * 0. UTILIDADES
 * =========================================================
 */

/**
 * Devuelve un número de versión para un asset del child theme
 * basado en la fecha de modificación del archivo (filemtime).
 *
 * Esto evita que el navegador o la caché (LiteSpeed, etc.) sirvan
 * una versión antigua de un CSS/JS después de editarlo: cada vez
 * que se guarda el archivo, la "versión" cambia automáticamente
 * y fuerza la descarga de la copia nueva.
 *
 * Si el archivo no existe todavía, se usa la versión del tema
 * como respaldo para no romper el enqueue.
 *
 * @param string $relative_path Ruta relativa desde la raíz del child theme,
 *                               p. ej. '/assets/css/project-showcase.css'.
 * @return string Número de versión a pasar a wp_enqueue_style()/script().
 */
function jv_asset_version( $relative_path ) {

	$file_path = get_stylesheet_directory() . $relative_path;

	if ( file_exists( $file_path ) ) {
		return (string) filemtime( $file_path );
	}

	return wp_get_theme()->get( 'Version' );
}


/**
 * =========================================================
 * 1. ENQUEUE PARENT AND CHILD STYLES
 * =========================================================
 */

/**
 * Carga el CSS del tema padre (Hello Elementor) y del child theme.
 *
 * @return void
 */
function jv_enqueue_child_styles() {

	wp_enqueue_style(
		'hello-elementor-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( get_template() )->get( 'Version' )
	);

	wp_enqueue_style(
		'hello-elementor-child',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'hello-elementor-parent' ),
		wp_get_theme()->get( 'Version' )
	);

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_child_styles' );


/**
 * =========================================================
 * 2. PROJECT SHOWCASE
 * =========================================================
 */

/**
 * Carga el CSS y JS del componente "Project Showcase".
 *
 * @return void
 */
function jv_enqueue_project_showcase_assets() {

	wp_enqueue_style(
		'jv-project-showcase',
		get_stylesheet_directory_uri() . '/assets/css/project-showcase.css',
		array( 'hello-elementor-child' ),
		jv_asset_version( '/assets/css/project-showcase.css' )
	);

	wp_enqueue_script(
		'jv-project-showcase',
		get_stylesheet_directory_uri() . '/assets/js/project-showcase.js',
		array(),
		jv_asset_version( '/assets/js/project-showcase.js' ),
		true
	);

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_project_showcase_assets' );


/**
 * Devuelve los datos de un proyecto del showcase por su ID.
 *
 * Para añadir un proyecto nuevo, se añade una entrada más a este
 * array y se usa el shortcode [jv_project id="tu-id"] donde
 * corresponda.
 *
 * @param string $project_id Clave del proyecto dentro del array.
 * @return array|false Datos del proyecto, o false si no existe.
 */
function jv_get_project_data( $project_id ) {

	$projects = array(

		'inicio-luzyalma' => array(
			'title'       => 'REPORTAJES LUZ Y ALMA EN FAMILIA',
			'category'    => 'NOVEDAD  |  NUEVO SERVICIO',
			'city'        => 'Hacemos el reportaje donde tú decidas',
			'year'        => '2026',
			'description' => 'Nuevo servicio disponible, reportajes de familias y eventos personalizados.',
			'image_id'    => 3345,
			'image_fit'   => 'contain',
			'url'         => '/servicios-fotografo-profesional-espana/servicio-fotografo-luz-y-alma/',

			'variant'     => 'luzyalma',
			'cta_label'   => 'VER SERVICIO',
		),

		'disfrutar' => array(
			'title'       => 'DISFRUTAR',
			'category'    => 'Fotografía gastronómica',
			'city'        => 'Barcelona',
			'year'        => '2025',
			'client'      => 'Restaurante Disfrutar',
			'description' => 'Experiencia gastronómica contemporánea en Barcelona.',
			'image_id'    => 796,
			'image_fit'   => 'contain',
			'url'         => '/portfolio_page/restaurante-disfrutar-barcelona/',
		),

		'txapela' => array(
			'title'       => 'TXAPELA',
			'category'    => 'Fotografía gastronómica',
			'city'        => 'Madrid',
			'year'        => '2025',
			'client'      => 'Restaurante Txapela',
			'description' => 'Experiencia gastronómica contemporánea en Barcelona.',
			'image_id'    => 2106,
			'image_fit'   => 'contain',
			'url'         => '/portfolio_page/txapela-madrid-tradicion-vasca-tapas-gourmet-y-fotografia-con-alma-en-plena-ciudad/',
		),

		'hotel-consolacion' => array(
			'title'       => 'HOTEL CONSOLACIÓN',
			'category'    => 'Fotografía de hoteles',
			'city'        => 'Teruel',
			'year'        => '2024',
			'client'      => 'Hotel Consolación',
			'description' => 'Naturaleza, arquitectura y emoción en el corazón de Teruel.',
			'image_id'    => 733,
			'image_fit'   => 'contain',
			'url'         => '/portfolio_page/hotel-consolacion-teruel-fotografia-interiores-espana/',
		),

		'tapa-tapa' => array(
			'title'       => 'TAPA TAPA',
			'category'    => 'Fotografía de interiores',
			'city'        => 'Barcelona',
			'year'        => '2025',
			'client'      => 'Tapa Tapa',
			'description' => 'Descubriendo la elegancia cálida del emblemático Tapa Tapa del Passeig de Gràcia.',
			'image_id'    => 1733,
			'image_fit'   => 'contain',
			'url'         => '/portfolio_page/fotografo-interiores-barcelona-tapa-tapa/',
		),

	);

	if ( ! isset( $projects[ $project_id ] ) ) {
		return false;
	}

	return $projects[ $project_id ];
}


/**
 * Shortcode del Project Showcase.
 *
 * Uso: [jv_project id="disfrutar"]
 *
 * @param array $atts Atributos del shortcode.
 * @return string HTML del proyecto, o cadena vacía si no existe.
 */
function jv_project_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'id' => '',
		),
		$atts,
		'jv_project'
	);

	$project_id = sanitize_key( $atts['id'] );

	if ( empty( $project_id ) ) {
		return '';
	}

	$project = jv_get_project_data( $project_id );

	if ( ! $project ) {
		return '';
	}

	ob_start();

	include get_stylesheet_directory() . '/template-parts/project-showcase.php';

	return ob_get_clean();
}

add_shortcode( 'jv_project', 'jv_project_shortcode' );


/**
 * =========================================================
 * 3. GLOBAL PAGE TRANSITIONS
 * =========================================================
 */

/**
 * Carga el CSS de las transiciones globales de página.
 *
 * @return void
 */
function jv_enqueue_global_transitions() {

	wp_enqueue_style(
		'jv-global-transitions',
		get_stylesheet_directory_uri() . '/assets/css/global-transitions.css',
		array(),
		jv_asset_version( '/assets/css/global-transitions.css' )
	);

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_global_transitions' );


/**
 * Carga el JS de las transiciones globales de página.
 *
 * @return void
 */
function jv_enqueue_global_transition_script() {

	wp_enqueue_script(
		'jv-global-transitions',
		get_stylesheet_directory_uri() . '/assets/js/global-transitions.js',
		array(),
		jv_asset_version( '/assets/js/global-transitions.js' ),
		true
	);

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_global_transition_script' );


/**
 * =========================================================
 * 4. PORTFOLIO GALLERY
 * =========================================================
 */

/**
 * Carga el CSS de ajustes visuales para la galería de portfolio
 * (oculta títulos/descripciones autogenerados por el plugin de galería).
 *
 * @return void
 */
function jv_enqueue_portfolio_gallery_styles() {

	wp_enqueue_style(
		'jv-portfolio-gallery',
		get_stylesheet_directory_uri() . '/assets/css/portfolio-gallery.css',
		array(),
		jv_asset_version( '/assets/css/portfolio-gallery.css' )
	);

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_portfolio_gallery_styles' );


/**
 * =========================================================
 * 5. BLOG
 * =========================================================
 */

/**
 * Categorías oficiales del blog.
 *
 * Aquí controlamos:
 * - Nombre visible
 * - Slug de WordPress
 *
 * Si algún día quieres cambiar una categoría, solamente
 * modificamos este bloque (y la categoría correspondiente
 * en WordPress debe existir con ese mismo slug).
 *
 * @return array[] Lista de categorías con 'name' y 'slug'.
 */
function jv_get_blog_categories() {

	return array(

		array(
			'name' => 'FOTOGRAFÍA',
			'slug' => 'fotografia',
		),

		array(
			'name' => 'GASTRONOMÍA',
			'slug' => 'gastronomia',
		),

		array(
			'name' => 'INTERIORES',
			'slug' => 'interiores',
		),

		array(
			'name' => 'EQUIPO FOTOGRÁFICO',
			'slug' => 'equipo-fotografico',
		),

		array(
			'name' => 'CULTURA VISUAL',
			'slug' => 'cultura-visual',
		),

	);

}


/**
 * =========================================================
 * BLOG — 12 ARTÍCULOS POR PÁGINA
 * =========================================================
 *
 * Utilizamos la consulta principal de WordPress.
 *
 * Esto afecta únicamente a:
 * - Página de entradas (home.php)
 * - Archivos de categorías (category.php)
 *
 * No crea consultas adicionales.
 *
 * @param WP_Query $query Consulta principal de WordPress.
 * @return void
 */
function jv_blog_posts_per_page( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_home() || $query->is_category() ) {

		$query->set( 'posts_per_page', 12 );
		$query->set( 'ignore_sticky_posts', true );

	}

}

add_action( 'pre_get_posts', 'jv_blog_posts_per_page' );


/**
 * =========================================================
 * BLOG — CSS
 * =========================================================
 *
 * Cargamos el CSS solamente en:
 * - /blog/articulos/ (página de entradas)
 * - /category/... (archivos de categoría)
 *
 * No se carga en el resto de la web.
 *
 * @return void
 */
function jv_enqueue_blog_assets() {

	if ( is_home() || is_category() ) {

		wp_enqueue_style(
			'jv-blog-articulos',
			get_stylesheet_directory_uri() . '/assets/css/blog-articulos.css',
			array( 'hello-elementor-child' ),
			jv_asset_version( '/assets/css/blog-articulos.css' )
		);

	}

}

add_action( 'wp_enqueue_scripts', 'jv_enqueue_blog_assets' );


/**
 * =========================================================
 * BLOG — TARJETA COMPARTIDA
 * =========================================================
 *
 * Renderiza una tarjeta de artículo ("jv-blog-card") para el
 * post actual del loop de WordPress.
 *
 * Se usa tanto en home.php (página de entradas) como en
 * category.php (archivo de categoría) para no repetir el
 * mismo bloque de marcado en dos archivos distintos.
 *
 * IMPORTANTE: debe llamarse DENTRO de un bucle WordPress,
 * justo después de the_post(), igual que the_title(),
 * the_permalink(), etc.
 *
 * El HTML, las clases y el comportamiento son exactamente
 * los mismos que se usaban antes de forma duplicada en
 * home.php y category.php.
 *
 * @return void
 */
function jv_render_blog_card() {
	?>

	<article class="jv-blog-card">

		<?php if ( has_post_thumbnail() ) : ?>

			<a
				class="jv-blog-card-image"
				href="<?php the_permalink(); ?>"
				aria-label="<?php echo esc_attr( get_the_title() ); ?>"
			>

				<?php
				the_post_thumbnail(
					'large',
					array(
						'loading' => 'lazy',
						'alt'     => esc_attr( get_the_title() ),
					)
				);
				?>

			</a>

		<?php endif; ?>


		<div class="jv-blog-card-content">

			<?php
			$categories = get_the_category();

			if ( ! empty( $categories ) ) :
				?>

				<a
					class="jv-blog-card-category"
					href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"
				>
					<?php echo esc_html( $categories[0]->name ); ?>
				</a>

			<?php endif; ?>


			<h2 class="jv-blog-card-title">

				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>

			</h2>


			<div class="jv-blog-card-meta">

				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
				</time>

				<a
					class="jv-blog-card-link"
					href="<?php the_permalink(); ?>"
				>
					LEER →
				</a>

			</div>

		</div>

	</article>

	<?php
}


/**
 * =========================================================
 * BLOG — SHORTCODE
 * ÚLTIMOS ARTÍCULOS
 * =========================================================
 *
 * Uso: [jv_blog_posts]
 * Uso con parámetros: [jv_blog_posts posts="3" category="gastronomia"]
 *
 * Este shortcode se mantiene independiente del archivo
 * /blog/articulos/ (home.php) y del archivo de categoría
 * (category.php); genera su propio bloque de tarjetas para
 * usar, por ejemplo, dentro de Elementor.
 *
 * @param array $atts Atributos del shortcode.
 * @return string HTML del bloque de últimos artículos.
 */
function jv_blog_latest_posts( $atts ) {

	$atts = shortcode_atts(
		array(
			'posts'    => 6,
			'category' => '',
		),
		$atts,
		'jv_blog_posts'
	);

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => intval( $atts['posts'] ),
		'post_status'         => 'publish',
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $atts['category'] ) ) {

		$args['category_name'] = sanitize_title( $atts['category'] );

	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {

		return '<p class="jv-no-posts">Todavía no hay artículos publicados.</p>';

	}

	ob_start();

	/*
	 * CONTENEDOR PRINCIPAL + GRID
	 */
	echo '<section class="jv-blog-latest">';
	echo '<div class="jv-post-grid">';

	while ( $query->have_posts() ) {

		$query->the_post();

		$post_id = get_the_ID();

		/*
		 * CATEGORÍA PRINCIPAL
		 */
		$categories    = get_the_category();
		$category_name = ! empty( $categories ) ? $categories[0]->name : '';

		/*
		 * TARJETA
		 */
		echo '<article class="jv-post-card">';

		/*
		 * IMAGEN
		 */
		if ( has_post_thumbnail() ) {

			echo '<a class="jv-post-image" href="' . esc_url( get_permalink() ) . '">';

			echo get_the_post_thumbnail(
				$post_id,
				'large',
				array(
					'loading' => 'lazy',
					'alt'     => esc_attr( get_the_title() ),
				)
			);

			echo '</a>';

		}

		/*
		 * CONTENIDO
		 */
		echo '<div class="jv-post-content">';

		if ( ! empty( $category_name ) ) {

			echo '<div class="jv-post-category">';
			echo esc_html( $category_name );
			echo '</div>';

		}

		echo '<h3 class="jv-post-title">';
		echo '<a href="' . esc_url( get_permalink() ) . '">';
		echo esc_html( get_the_title() );
		echo '</a>';
		echo '</h3>';

		echo '<div class="jv-post-date">';
		echo esc_html( get_the_date( 'd/m/Y' ) );
		echo '</div>';

		echo '<p class="jv-post-excerpt">';
		echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) );
		echo '</p>';

		echo '<a class="jv-post-link" href="' . esc_url( get_permalink() ) . '">';
		echo 'LEER ARTÍCULO →';
		echo '</a>';

		echo '</div>';
		echo '</article>';

	}

	echo '</div>';
	echo '</section>';

	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'jv_blog_posts', 'jv_blog_latest_posts' );
