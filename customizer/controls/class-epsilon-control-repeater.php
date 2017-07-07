<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Control_Repeater
 *
 * @since 1.2.0
 */
class Epsilon_Control_Repeater extends WP_Customize_Control {
	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.2.0
	 * @access public
	 * @var    string
	 */
	public $type = 'epsilon-repeater';
	/**
	 * @since 1.2.0
	 * @var array
	 */
	public $choices = array();
	/**
	 * @since 1.2.0
	 * @var array|mixed
	 */
	public $fields = array();
	/**
	 * @since 1.2.0
	 * @var array
	 */
	public $row_label = array();
	/**
	 * Will store a filtered version of value for advanced fields.
	 *
	 * @since  1.2.0
	 * @access protected
	 * @var array
	 */
	protected $filtered_value = array();

	/**
	 * Epsilon_Control_Repeater constructor.
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$manager->register_control_type( 'Epsilon_Control_Repeater' );

		// Set up defaults for row labels.
		$this->row_label = array(
			'type'  => 'text',
			'value' => esc_attr__( 'row', 'kirki' ),
			'field' => false,
		);

		if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
			$args['fields'] = array();
		}

		foreach ( $args['fields'] as $key => $value ) {
			if ( ! isset( $value['default'] ) ) {
				$args['fields'][ $key ]['default'] = '';
			}
			if ( ! isset( $value['label'] ) ) {
				$args['fields'][ $key ]['label'] = '';
			}
			$args['fields'][ $key ]['id'] = $key;
		} // End foreach().

		$this->fields = $args['fields'];
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.2.0
	 * @access public
	 */
	public function json() {
		$json = parent::json();

		$json['id']       = $this->id;
		$json['link']     = $this->get_link();
		$json['value']    = $this->value();
		$json['choices']  = $this->choices;
		$json['fields']   = $this->fields;
		$json['rowLabel'] = $this->row_label;
		$json['default']  = ( isset( $this->default ) ) ? $this->default : $this->setting->default;

		return $json;
	}

	/**
	 * As it should be
	 *
	 * @since 1.2.0
	 */
	public function render_content() {

	}

	/**
	 * Displays the control content.
	 *
	 * @since 1.2.0
	 */
	public function content_template() {
		//@formatter:off  ?>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
				<# if( data.description ){ #>
					<i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
						<span class="mte-tooltip">
							{{{ data.description }}}
						</span>
					</i>
				<# } #>
			</span>
		</label>

		<ul class="repeater-fields"></ul>
		<button class="button-secondary epsilon-repeater-add"><?php echo __( 'Add', 'epsilon-framework' ); ?></button>
		<?php //@formatter:on
	}
}
