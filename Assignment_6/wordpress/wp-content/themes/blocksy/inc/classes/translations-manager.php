<?php

class Blocksy_Translations_Manager {
	public function init() {
		add_action(
			'customize_save_after',
			[$this, 'register_wpml_translation_keys']
		);

		if (is_admin()) {
			add_action(
				'admin_init',
				[$this, 'register_translation_keys']
			);
		}

		add_action(
			'init',
			function () {
				if (! class_exists('PLL_Translate_Option')) {
					return;
				}

				$prefixes = blocksy_manager()->screen->get_single_prefixes();

				$all_keys = [];

				foreach ($prefixes as $prefix) {
					if (
						$prefix === 'single_blog_post'
						||
						$prefix === 'single_page'
					) {
						continue;
					}

					$related_label = blocksy_get_theme_mod(
						$prefix . '_related_label',
						'__empty__'
					);

					if ($related_label === '__empty__') {
						continue;
					}

					$all_keys[$prefix . '_related_label'] = 1;
				}

				if (empty($all_keys)) {
					return;
				}

				new PLL_Translate_Option('theme_mods_blocksy', $all_keys);
				new PLL_Translate_Option('theme_mods_blocksy-child', $all_keys);

				blocksy_manager()->db->wipe_cache();
			}
		);
	}

	public function get_all_translation_keys() {
		$builder_keys = Blocksy_Manager::instance()->builder->translation_keys();
		$all_cpt = blocksy_manager()->post_types->get_all([
			'exclude_built_in' => true,
			'exclude_woo' => true
		]);

		$all_cpt_archive_keys = [];
		$all_cpt_single_keys = [];

		foreach ($all_cpt as $cpt) {
			$all_cpt_archive_keys[] = $cpt . '_archive';
			$all_cpt_single_keys[] = $cpt . '_single';
		}

		foreach (
			array_merge(
				['blog', 'categories', 'search', 'author'],
				$all_cpt_archive_keys
			) as $prefix
		) {
			$archive_order = blocksy_get_theme_mod($prefix . '_archive_order', null);

			if (! $archive_order) {
				continue;
			}

			foreach ($archive_order as $single_archive_component) {
				if ($single_archive_component['id'] !== 'read_more') {
					continue;
				}

				if (blocksy_akg('read_more_text', $single_archive_component)) {
					$builder_keys[] = [
						'key' => $prefix . '_archive_read_more_text',
						'value' => blocksy_akg(
							'read_more_text',
							$single_archive_component
						)
					];
				}
			}
		}

		foreach (
			array_merge(
				['blog', 'single_blog_post', 'single_page'],
				$all_cpt_single_keys
			) as $prefix
			) {
			$hero_elements = blocksy_get_theme_mod($prefix . '_hero_elements', null);

			if (! $hero_elements) {
				continue;
			}

			foreach ($hero_elements as $single_hero_component) {
				if (
					$single_hero_component['id'] === 'custom_meta'
					&&
					is_array($single_hero_component['meta_elements'])
				) {
					foreach ($single_hero_component['meta_elements'] as $single_meta_element) {
						if (empty($single_meta_element['label'])) {
							continue;
						}

						$builder_keys[] = [
							'key' => $prefix . '_hero_meta_' . $single_meta_element['id'] . '_label',
							'value' => $single_meta_element['label']
						];
					}
				}

				if (
					$single_hero_component['id'] === 'custom_title'
					&&
					blocksy_akg('title', $single_hero_component)
				) {
					$builder_keys[] = [
						'key' => $prefix . '_hero_custom_title',
						'value' => blocksy_akg('title', $single_hero_component)
					];
				}

				if (
					$single_hero_component['id'] === 'custom_description'
					&&
					blocksy_akg('description', $single_hero_component)
				) {
					$builder_keys[] = [
						'key' => $prefix . '_hero_custom_description',
						'value' => blocksy_akg('description', $single_hero_component)
					];
				}
			}
		}

		return apply_filters(
			'blocksy:translations-manager:all-translation-keys',
			$builder_keys
		);
	}

	public function register_translation_keys() {
		if (! function_exists('pll_register_string')) {
			return;
		}

		$builder_keys = $this->get_all_translation_keys();

		foreach ($builder_keys as $single_key) {
			if (! is_string($single_key['value'])) {
				continue;
			}

			pll_register_string(
				$single_key['key'],
				$single_key['value'],
				'Blocksy',
				isset($single_key['multiline']) ? $single_key['multiline'] : false
			);
		}
	}

	public function register_wpml_translation_keys() {
		if (! function_exists('icl_object_id')) {
			return;
		}

		$builder_keys = $this->get_all_translation_keys();

		foreach ($builder_keys as $single_key) {
			if (! is_string($single_key['value'])) {
				continue;
			}

			do_action(
				'wpml_register_single_string',
				'Blocksy',
				$single_key['key'],
				$single_key['value']
			);
		}
	}
}

if (! function_exists('blocksy_get_all_i18n_languages')) {
	function blocksy_get_all_i18n_languages() {
		$result = [];

		if (function_exists('pll_languages_list')) {
			$locales = pll_languages_list(['fields' => '']);

			foreach ($locales as $locale) {
				$result[] = [
					'id' => $locale->locale,
					'name' => $locale->name
				];
			}
		}

		if (
			! function_exists('pll_languages_list')
			&&
			function_exists('icl_get_languages')
		) {
			$locales = icl_get_languages();

			foreach ($locales as $locale_key => $locale) {
				$result[] = [
					'id' => $locale['default_locale'],
					'name' => $locale['native_name']
				];
			}
		}

		if (class_exists('TRP_Translate_Press')) {
			$settings = new TRP_Settings();
			$settings_array = $settings->get_settings();

			$trp = TRP_Translate_Press::get_trp_instance();

			$trp_languages = $trp->get_component('languages');

			if (current_user_can(apply_filters(
				'trp_translating_capability',
				'manage_options'
			))) {
				$languages_to_display = $settings_array['translation-languages'];
			} else {
				$languages_to_display = $settings_array['publish-languages'];
			}

			$languages_info = $trp_languages->get_language_names(
				$languages_to_display
			);

			foreach ($languages_to_display as $code) {
				$result[] = [
					'id' => $code,
					'name' => $languages_info[$code]
				];
			}
		}

		if (function_exists('weglot_get_current_language')) {
			$languages_available = array_values((array)weglot_get_languages_available())[0];
			$original_language = weglot_get_original_language();
			$destination_languages = array_map(function ($object) {
				return $object['language_to'];
			}, weglot_get_destination_languages());
			$languages_to_display = array_merge(array($original_language), $destination_languages);

			foreach ($languages_to_display as $code) {
				$result[] = [
					'id' => $languages_available[$code]->getExternalCode(),
					'name' => $languages_available[$code]->getLocalName()
				];
			}
		}

		return $result;
	}
}

if (! function_exists('blocksy_get_current_language')) {
	function blocksy_get_current_language($format = 'locale') {
		if ($format === 'slug') {
			if (function_exists('pll_current_language')) {
				return pll_current_language();
			}

			if (class_exists('Sitepress')) {
				return apply_filters('wpml_current_language', null);
			}

			return '__NOT_KNOWN__';
		}

		if (function_exists('pll_current_language')) {
			return pll_current_language('locale');
		}

		if (
			function_exists('icl_get_languages')
			&&
			class_exists('Sitepress')
		) {
			$all_languages = icl_get_languages();
			$current_language = apply_filters('wpml_current_language', null);

			if (isset($all_languages[$current_language])) {
				return $all_languages[$current_language]['default_locale'];
			}
		}

		global $TRP_LANGUAGE;

		if (
			class_exists('TRP_Translate_Press')
			&&
			isset($TRP_LANGUAGE)
		) {
			return $TRP_LANGUAGE;
		}

		if (function_exists('weglot_get_current_language')) {
			return weglot_get_current_language();
		}

		return '__NOT_KNOWN__';
	}
}

if (! function_exists('blocksy_translate_dynamic')) {
	function blocksy_translate_dynamic($text, $key = null) {
		if (function_exists('pll__')) {
			return pll__($text); // PHPCS:ignore WordPress.WP.I18n
		}

		if ($key) {
			return apply_filters(
				'wpml_translate_single_string',
				$text,
				'Blocksy',
				$key
			);
		}

		return $text;
	}
}

function blocksy_translate_post_id($post_id, $args = []) {
	$args = wp_parse_args($args, [
		'use_wpml_default_language_woo' => false
	]);

	$language = null;

	if ($args['use_wpml_default_language_woo']) {
		global $sitepress, $woocommerce_wpml;

		if (
			$sitepress
			&&
			$woocommerce_wpml
		) {
			$language = $sitepress->get_default_language();
		}
	}

	$post_type = get_post_type($post_id);

	return apply_filters(
		'wpml_object_id',
		$post_id,
		$post_type,
		true,
		$language
	);
}

function blocksy_safe_sprintf($format, ...$args) {
	$result = $format;

	$is_error = false;

	// vsprintf() triggers a warning on PHP < 8 and throws an exception on PHP 8+
	// We need to handle both.
	// https://www.php.net/manual/en/function.vsprintf.php#refsect1-function.vsprintf-errors

	set_error_handler(function () use (&$is_error) {
		$is_error = true;
	});

	if (interface_exists('Throwable')) {
		try {
			$result = vsprintf($format, $args);
		} catch (\Throwable $e) {
			$is_error = true;
		}
	} else {
		$result = vsprintf($format, $args);
	}

	restore_error_handler();

	if ($is_error) {
		// TODO: maybe cleanup format from %s, %d, etc
		return $format;
	}

	return $result;
}
