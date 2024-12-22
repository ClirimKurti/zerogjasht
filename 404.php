<?php
// Remove default loop.
remove_action('genesis_loop', 'genesis_do_loop');

add_action('genesis_loop', 'custom_404_loop');
/**
 * This function outputs a 404 "Not Found" error message.
 *
 * @since 1.6
 */
function custom_404_loop()
{

	genesis_markup(
		[
			'open'    => '<article class="entry">',
			'context' => 'entry-404',
		]
	);

	genesis_markup(
		[
			'open'    => '<h2 %s>',
			'close'   => '</h2>',
			'content' => apply_filters('genesis_404_entry_title', __('Faqja që kerkuat nuk egziston, error 404', 'genesis')),
			'context' => 'entry-title',
		]
	);

	$genesis_404_content = sprintf(
		/* translators: %s: URL for current website. */
		__('Faqja që po kërkoni nuk ekziston më. Ndoshta mund të ktheheni te <a href="%s">faqja kryesore</a> dhe të shihni nëse mund të gjeni atë që po kërkoni. Ose, mund të provoni ta gjeni duke përdorur formularin e kërkimit më poshtë.', 'genesis'),
		esc_url(trailingslashit(home_url()))
	);

	$genesis_404_content = sprintf('<p>%s</p>', $genesis_404_content);

	/**
	 * The 404 content (wrapped in paragraph tags).
	 *
	 * @since 2.2.0
	 *
	 * @param string $genesis_404_content The content.
	 */
	$genesis_404_content = apply_filters('genesis_404_entry_content', $genesis_404_content);

	genesis_markup(
		[
			'open'    => '<div %s>',
			'close'   => '</div>',
			'content' => $genesis_404_content . get_search_form(0),
			'context' => 'entry-content',
		]
	);

	genesis_markup(
		[
			'close'   => '</article>',
			'context' => 'entry-404',
		]
	);
	show_custom_view_after_the_404_message();
}

function show_custom_view_after_the_404_message() {}

genesis();
