<?php
/**
 * The upsell for the frontpage sections
 *
 * Pro customizer section.
 *
 * @package ThemeVision
 * @subpackage Agama
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Agama_Customizer_Upsell_Section
 */
class Agama_Customizer_Upsell_Section extends WP_Customize_Section {
    
	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    string
	 */
	public $type = 'agama-upsell-slider-sections';
    
	/**
	 * Upsell text to output.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    string
	 */
	public $upsell_text = '';
    
	/**
	 * Button text to output.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    string
	 */
	public $button_text = '';
    
	/**
	 * Button link to output.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    string
	 */
	public $button_url = '#';
    
	/**
	 * List of theme options to output.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    array
	 */
	public $options = array();
    
	/**
	 * List of additional explanations to output.
	 *
	 * @since  1.3.7
	 * @access public
	 * @var    array
	 */
	public $explained_features = array();
    
	/**
	 * Agama_Customizer_Upsell_Section constructor.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		$manager->register_section_type( 'Agama_Customizer_Upsell_Section' );
		parent::__construct( $manager, $id, $args );
	}
    
	/**
	 * Add custom parameters to pass to the JS via JSON.
	 */
	public function json() {
		$json                       = parent::json();
		$json['button_text']        = esc_html( $this->button_text );
		$json['button_url']         = esc_url( $this->button_url );
		$json['options']            = $this->options;
		$json['explained_features'] = $this->explained_features;
		return $json;
	}
    
	/**
	 * Outputs the Underscore.js template.
	 */
	protected function render_template() {
		?>
		<div class="themevision-upsell themevision-boxed-section">
			<# if ( data.options.length > 0 ) { #>
				<ul class="themevision-upsell-features">
					<# for (option in data.options) { #>
						<li><span class="upsell-pro-label"></span>{{ data.options[option] }}
						</li>
						<# } #>
				</ul>
				<# } #>

					<# if ( data.button_text && data.button_url ) { #>
						<a target="_blank" href="{{ data.button_url }}" class="btn btn-primary" target="_blank">{{
							data.button_text }}</a>
						<# } #>

							<# if ( data.explained_features.length > 0 ) { #>
								<hr>
								<ul class="themevision-upsell-feature-list">
									<# for (feature in data.explained_features) { #>
										<li>* {{ data.explained_features[feature] }}</li>
										<# } #>
								</ul>
								<# } #>
		</div>
	<?php
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */

