<?php 

if ( !class_exists('UC_Settings' ) ):
class UC_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new UC_Registration();
       
        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {
        //set the settings        
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );
        //initialize settings    
        
        $this->settings_api->initialize();
    }
	
    function admin_menu() {
        add_theme_page(
         __( 'UC Zoom', 'uc-woocommerce-zoom' ),	// The title to be displayed in the browser window for   this page.
         __( 'UC Zoom', 'uc-woocommerce-zoom' ),  // The text to be displayed for this menu item
         'administrator',								// Which type of users can see this menu item
         'uc_woo_settings',								// The unique ID - that is, the slug - for this menu item
         array($this, 'uc_woo_display')					// The name of the function to call when rendering this menu's page
        );
    }

	// setings tabs
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'general_uc_section',
                'title' => __( 'Display Options', 'uc-woocommerce-zoom' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
		    'general_uc_section' => array(
                  array(
                    'name'      => 'innerzoom',
                    'label'     => __( 'Inner zoom', 'uc-woocommerce-zoom' ),
                    'desc'      => __( 'Displaying zoom magnifier inside image.', 'uc-woocommerce-zoom' ),
                    'type'      => 'radio',
                    'default'   => 'false',
                    'options'   => array(
                        'true'  => 'Yes',
                        'false' => 'No'
                    )
                ),
				array(
		            'name'      => 'cursorshade',
		            'label'     => __( 'Cursor shade', 'uc-woocommerce-zoom' ),
		            'desc'      => __( 'Displaying rectangle under cursor.', 'uc-woocommerce-zoom' ),
		            'type'      => 'radio',
		            'default'   => 'true',
                    'options'   => array(
                        'true'  => 'Yes',
                        'false' => 'No'
                	)
                ),
                array(
                    'name'      => 'magnifierpos',
                    'label'     => __( 'Magnifier position', 'uc-woocommerce-zoom' ),
                    'desc'      => __( 'Displaying where container been. Default right.', 'uc-woocommerce-zoom' ),
                    'type'      => 'radio',
                    'default'   => 'right',
                    'options'   => array(
                        'right'  => 'Right',
                        'left'   => 'Left'
                    )
                ),                 
                array(
                    'name'      => 'zoomstart',
                    'label'     => __( 'Zoom level', 'uc-woocommerce-zoom' ),
                    'desc'      => __( 'Change zoom on hover. Default zoom 2 times.', 'uc-woocommerce-zoom' ),
                    'type'      => 'number',
                    'default'   => '2'                   
                ),
                 array(
                    'name'      => 'magnifycursor',
                    'label'     => __( 'Cursor view', 'uc-woocommerce-zoom' ),
                    'desc'      => __( 'Change cursor style on hover. Default CSS cursor "crosshair".', 'uc-woocommerce-zoom' ),
                    'type'      => 'select',
                    'default'   => 'crosshair',
                    'options'   => array(
                        'crosshair' => 'Default cursor',
                        'pointer'   => 'Pointer cursor',
                        'cursor'    => 'Windows cursor'
                    )
                ),
                array(
		            'name'      => 'cursorshadecolor',
		            'label'     => __( 'Cursor color shade', 'uc-woocommerce-zoom' ),
		            'desc'      => __( 'Change color rectangle under cursor. Default grey.', 'uc-woocommerce-zoom' ),
		            'type'		=> 'color',
		            'default'   => '#cecece'                   
				),
                array(
                    'name'      => 'cursorshadeopacity',
                    'label'     => __( 'Cursor color shade opacity', 'uc-woocommerce-zoom' ),
                    'desc'      => __( 'Change cursor color shade opacity. Default opacity 0.3.', 'uc-woocommerce-zoom' ),
                    'type'      => 'select',
                    'default'   => '0.3',
                    'options'   => array(
                        '0.1' => '0.1',
                        '0.2' => '0.2',
                        '0.3' => '0.3',
                        '0.4' => '0.4',
                        '0.5' => '0.5',
                        '0.6' => '0.6',
                        '0.7' => '0.7',
                        '0.8' => '0.8',
                        '0.9' => '0.9'
                    )
                )
			)
		);
		return $settings_fields;
    }

    function uc_woo_display() {
		?>
		<div class="wrap">
			<?php
                $this->settings_api->show_navigation();
                $this->settings_api->show_forms();
            ?>
		</div>
		<?php
	}

} // end class
endif;

$settings = new UC_Settings();

?>