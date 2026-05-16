<?php
/**
 * Enix Advanced Accordion Widget
 *
 * Interactive split-screen accordion with smooth crossfade image panel.
 *
 * @package Enix_Addons
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'Enix_Advanced_Accordion' ) ) { return; }

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

/**
 * Class Enix_Advanced_Accordion
 */
class Enix_Advanced_Accordion extends Widget_Base {

	public function get_name()           { return 'enix_advanced_accordion'; }
	public function get_title()          { return esc_html__( 'Enix Advanced Accordion', 'enix-addons' ); }
	public function get_icon()           { return 'eicon-accordion'; }
	public function get_categories()     { return array( 'enix-elements' ); }
	public function get_keywords()       { return array( 'enix', 'accordion', 'faq', 'toggle', 'interactive', 'image' ); }
	public function get_style_depends()  { return array( 'enix-widgets' ); }
	public function get_script_depends() { return array( 'enix-widgets' ); }

	protected function register_controls() {

		// ═══════════════════════════════════════════════════════════
		// CONTENT TAB
		// ═══════════════════════════════════════════════════════════

		// ── Accordion Items ─────────────────────────────────────────
		$this->start_controls_section(
			'enix_section_items',
			array(
				'label' => esc_html__( 'Accordion Items', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'enix-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Title', 'enix-addons' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Left Icon', 'enix-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array( 'value' => 'fas fa-chevron-right', 'library' => 'fa-solid' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'enix-addons' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Add a short description for this accordion item.', 'enix-addons' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Right Side Image', 'enix-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'enix-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'       => esc_html__( 'What is Enix Addons?', 'enix-addons' ),
						'description' => esc_html__( 'Enix Addons is a premium Elementor widget library built for speed and design.', 'enix-addons' ),
					),
					array(
						'title'       => esc_html__( 'How do I add a new item?', 'enix-addons' ),
						'description' => esc_html__( 'Click "Add Item" in the Elementor panel and fill in the title, description and image.', 'enix-addons' ),
					),
					array(
						'title'       => esc_html__( 'Is this widget mobile friendly?', 'enix-addons' ),
						'description' => esc_html__( 'Yes! Every widget in Enix Addons is fully responsive and tested on all devices.', 'enix-addons' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h2'  => 'H2', 'h3' => 'H3', 'h4' => 'H4',
					'h5'  => 'H5', 'div' => 'div', 'p'  => 'p',
				),
				'default' => 'h3',
			)
		);

		$this->end_controls_section();

		// ── Layout ─────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_section_layout',
			array(
				'label' => esc_html__( 'Layout', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'      => esc_html__( 'Column Gap', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
				'default'    => array( 'size' => 40, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-accordion-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'accordion_col_ratio',
			array(
				'label'      => esc_html__( 'Accordion Column Width (%)', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array( '%' => array( 'min' => 20, 'max' => 80 ) ),
				'default'    => array( 'size' => 45, 'unit' => '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-accordion-left'  => 'flex: 0 0 {{SIZE}}%;',
					'{{WRAPPER}} .enix-accordion-right' => 'flex: 1 1 0;',
				),
			)
		);

		$this->add_control(
			'enix_image_size',
			array(
				'label'   => esc_html__( 'Image Size', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'thumbnail' => esc_html__( 'Thumbnail', 'enix-addons' ),
					'medium'    => esc_html__( 'Medium', 'enix-addons' ),
					'large'     => esc_html__( 'Large', 'enix-addons' ),
					'full'      => esc_html__( 'Full', 'enix-addons' ),
				),
				'default' => 'full',
			)
		);

		$this->add_control(
			'enix_sep_order',
			array( 'type' => Controls_Manager::DIVIDER )
		);

		$this->add_control(
			'desktop_layout_order',
			array(
				'label'   => esc_html__( 'Desktop Column Order', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'accordion_image' => array(
						'title' => esc_html__( 'Accordion | Image', 'enix-addons' ),
						'icon'  => 'eicon-order-start',
					),
					'image_accordion' => array(
						'title' => esc_html__( 'Image | Accordion', 'enix-addons' ),
						'icon'  => 'eicon-order-end',
					),
				),
				'default' => 'accordion_image',
				'toggle'  => false,
			)
		);

		$this->add_control(
			'mobile_layout_order',
			array(
				'label'   => esc_html__( 'Mobile – Show First', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'image_first'     => array(
						'title' => esc_html__( 'Image First', 'enix-addons' ),
						'icon'  => 'eicon-image',
					),
					'accordion_first' => array(
						'title' => esc_html__( 'Accordion First', 'enix-addons' ),
						'icon'  => 'eicon-menu-bar',
					),
				),
				'default' => 'image_first',
				'toggle'  => false,
			)
		);

		$this->end_controls_section();

		// ── Left Icon Settings ──────────────────────────────────────
		$this->start_controls_section(
			'enix_section_left_icon',
			array(
				'label' => esc_html__( 'Left Icon', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_left_icon',
			array(
				'label'        => esc_html__( 'Show Left Icon', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'enix-addons' ),
				'label_off'    => esc_html__( 'Hide', 'enix-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_responsive_control(
			'left_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 8, 'max' => 60 ) ),
				'default'    => array( 'size' => 16, 'unit' => 'px' ),
				'condition'  => array( 'show_left_icon' => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-accordion-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .enix-accordion-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ── Right Arrow Icon Settings ───────────────────────────────
		$this->start_controls_section(
			'enix_section_right_icon',
			array(
				'label' => esc_html__( 'Right Arrow Icon', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_right_icon',
			array(
				'label'        => esc_html__( 'Show Right Arrow Icon', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'enix-addons' ),
				'label_off'    => esc_html__( 'Hide', 'enix-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'right_icon_type',
			array(
				'label'     => esc_html__( 'Icon Source', 'enix-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default' => esc_html__( 'Default (Built-in Chevron SVG)', 'enix-addons' ),
					'custom'  => esc_html__( 'Custom (Choose from Icon Library)', 'enix-addons' ),
				),
				'default'   => 'default',
				'condition' => array( 'show_right_icon' => 'yes' ),
			)
		);

		$this->add_control(
			'right_icon_custom',
			array(
				'label'     => esc_html__( 'Select Icon', 'enix-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array( 'value' => 'fas fa-chevron-down', 'library' => 'fa-solid' ),
				'condition' => array(
					'show_right_icon'  => 'yes',
					'right_icon_type'  => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'right_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 8, 'max' => 40 ) ),
				'default'    => array( 'size' => 14, 'unit' => 'px' ),
				'condition'  => array( 'show_right_icon' => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-accordion-arrow i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .enix-accordion-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════════════
		// STYLE TAB
		// ═══════════════════════════════════════════════════════════

		// ── Item Header ─────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_header',
			array(
				'label' => esc_html__( 'Item Header', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'enix_tabs_header' );

		// Normal tab
		$this->start_controls_tab(
			'enix_tab_header_normal',
			array( 'label' => esc_html__( 'Normal', 'enix-addons' ) )
		);
		$this->add_control( 'header_bg', array(
			'label'     => esc_html__( 'Background', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#f0f4ff',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-header' => 'background-color: {{VALUE}};' ),
		) );
		$this->add_control( 'title_color', array(
			'label'     => esc_html__( 'Title Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#1a1f3c',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-title' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'icon_color', array(
			'label'     => esc_html__( 'Left Icon Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#3b5bdb',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-icon' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'right_icon_color', array(
			'label'     => esc_html__( 'Right Arrow Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#3b5bdb',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-arrow' => 'color: {{VALUE}};' ),
		) );
		$this->end_controls_tab();

		// Active tab
		$this->start_controls_tab(
			'enix_tab_header_active',
			array( 'label' => esc_html__( 'Active', 'enix-addons' ) )
		);
		$this->add_control( 'header_bg_active', array(
			'label'     => esc_html__( 'Background', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#3b5bdb',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-item.enix-active .enix-accordion-header' => 'background-color: {{VALUE}};' ),
		) );
		$this->add_control( 'title_color_active', array(
			'label'     => esc_html__( 'Title Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-item.enix-active .enix-accordion-title' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'icon_color_active', array(
			'label'     => esc_html__( 'Left Icon Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#74c0fc',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-item.enix-active .enix-accordion-icon' => 'color: {{VALUE}};' ),
		) );
		$this->add_control( 'right_icon_color_active', array(
			'label'     => esc_html__( 'Right Arrow Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#74c0fc',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-item.enix-active .enix-accordion-arrow' => 'color: {{VALUE}};' ),
		) );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'header_padding', array(
			'label'      => esc_html__( 'Padding', 'enix-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'separator'  => 'before',
			'selectors'  => array( '{{WRAPPER}} .enix-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			'default'    => array( 'top' => '18', 'right' => '24', 'bottom' => '18', 'left' => '24', 'unit' => 'px' ),
		) );

		$this->add_group_control( Group_Control_Typography::get_type(), array(
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'enix-addons' ),
			'selector' => '{{WRAPPER}} .enix-accordion-title',
		) );

		$this->add_group_control( Group_Control_Border::get_type(), array(
			'name'     => 'header_border',
			'selector' => '{{WRAPPER}} .enix-accordion-header',
		) );

		$this->add_responsive_control( 'header_border_radius', array(
			'label'      => esc_html__( 'Border Radius', 'enix-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%' ),
			'selectors'  => array( '{{WRAPPER}} .enix-accordion-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );

		$this->end_controls_section();

		// ── Description ─────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_desc',
			array(
				'label' => esc_html__( 'Description', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control( 'desc_color', array(
			'label'     => esc_html__( 'Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#555e7b',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-desc' => 'color: {{VALUE}};' ),
		) );
		$this->add_group_control( Group_Control_Typography::get_type(), array(
			'name'     => 'desc_typography',
			'selector' => '{{WRAPPER}} .enix-accordion-desc',
		) );
		$this->add_responsive_control( 'desc_padding', array(
			'label'      => esc_html__( 'Padding', 'enix-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array( '{{WRAPPER}} .enix-accordion-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			'default'    => array( 'top' => '12', 'right' => '24', 'bottom' => '16', 'left' => '24', 'unit' => 'px' ),
		) );
		$this->add_control( 'desc_bg', array(
			'label'     => esc_html__( 'Background Color', 'enix-addons' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array( '{{WRAPPER}} .enix-accordion-desc' => 'background-color: {{VALUE}};' ),
		) );
		$this->end_controls_section();

		// ── Item Spacing & Shadow ────────────────────────────────────
		$this->start_controls_section(
			'enix_style_item',
			array(
				'label' => esc_html__( 'Item Spacing & Shadow', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control( 'item_gap', array(
			'label'      => esc_html__( 'Gap Between Items', 'enix-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
			'default'    => array( 'size' => 10, 'unit' => 'px' ),
			'selectors'  => array( '{{WRAPPER}} .enix-accordion-item + .enix-accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};' ),
		) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array(
			'name'     => 'item_shadow',
			'selector' => '{{WRAPPER}} .enix-accordion-item.enix-active',
		) );
		$this->end_controls_section();

		// ── Image ────────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_image',
			array(
				'label' => esc_html__( 'Image', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control( 'enix_crossfade_speed', array(
			'label'       => esc_html__( 'Crossfade Speed (ms)', 'enix-addons' ),
			'type'        => Controls_Manager::NUMBER,
			'min'         => 100,
			'max'         => 1500,
			'step'        => 50,
			'default'     => 500,
			'description' => esc_html__( 'Transition duration for image crossfade.', 'enix-addons' ),
			'selectors'   => array(
				'{{WRAPPER}} .enix-accordion-img' => 'transition-duration: calc({{VALUE}} * 1ms);',
			),
		) );

		$this->add_responsive_control( 'enix_image_align', array(
			'label'   => esc_html__( 'Alignment', 'enix-addons' ),
			'type'    => Controls_Manager::CHOOSE,
			'options' => array(
				'start'  => array( 'title' => esc_html__( 'Left', 'enix-addons' ),   'icon' => 'eicon-h-align-left' ),
				'center' => array( 'title' => esc_html__( 'Center', 'enix-addons' ), 'icon' => 'eicon-h-align-center' ),
				'end'    => array( 'title' => esc_html__( 'Right', 'enix-addons' ),  'icon' => 'eicon-h-align-right' ),
			),
			'default'   => 'center',
			'selectors' => array(
				'{{WRAPPER}} .enix-accordion-img' => 'align-self: {{VALUE}};',
			),
		) );

		$this->add_responsive_control( 'enix_image_width', array(
			'label'      => esc_html__( 'Width', 'enix-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px', '%', 'vw' ),
			'range'      => array(
				'px' => array( 'min' => 1, 'max' => 1200 ),
				'%'  => array( 'min' => 1, 'max' => 100 ),
			),
			'selectors' => array( '{{WRAPPER}} .enix-accordion-img img' => 'width: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'enix_image_height', array(
			'label'      => esc_html__( 'Height', 'enix-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'vh' ),
			'range'      => array(
				'px' => array( 'min' => 1, 'max' => 1200 ),
				'vh' => array( 'min' => 1, 'max' => 100 ),
			),
			'selectors' => array( '{{WRAPPER}} .enix-accordion-img img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;' ),
		) );

		$this->add_control( 'enix_img_sep1', array( 'type' => Controls_Manager::DIVIDER ) );

		$this->start_controls_tabs( 'enix_tabs_image' );

		$this->start_controls_tab( 'enix_tab_image_normal', array( 'label' => esc_html__( 'Normal', 'enix-addons' ) ) );
		$this->add_responsive_control( 'enix_image_opacity', array(
			'label'     => esc_html__( 'Opacity', 'enix-addons' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 ) ),
			'default'   => array( 'size' => 1 ),
			'selectors' => array( '{{WRAPPER}} .enix-accordion-img.enix-img-active img' => 'opacity: {{SIZE}};' ),
		) );
		$this->add_group_control( Group_Control_Css_Filter::get_type(), array(
			'name'     => 'enix_image_css_filters',
			'selector' => '{{WRAPPER}} .enix-accordion-img.enix-img-active img',
		) );
		$this->end_controls_tab();

		$this->start_controls_tab( 'enix_tab_image_hover', array( 'label' => esc_html__( 'Hover', 'enix-addons' ) ) );
		$this->add_responsive_control( 'enix_image_opacity_hover', array(
			'label'     => esc_html__( 'Opacity', 'enix-addons' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 ) ),
			'selectors' => array( '{{WRAPPER}} .enix-accordion-img:hover img' => 'opacity: {{SIZE}};' ),
		) );
		$this->add_group_control( Group_Control_Css_Filter::get_type(), array(
			'name'     => 'enix_image_css_filters_hover',
			'selector' => '{{WRAPPER}} .enix-accordion-img:hover img',
		) );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'enix_img_sep2', array( 'type' => Controls_Manager::DIVIDER ) );

		$this->add_group_control( Group_Control_Border::get_type(), array(
			'name'     => 'enix_image_border',
			'selector' => '{{WRAPPER}} .enix-accordion-img img',
		) );

		$this->add_responsive_control( 'image_border_radius', array(
			'label'      => esc_html__( 'Border Radius', 'enix-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%' ),
			'selectors'  => array( '{{WRAPPER}} .enix-accordion-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			'default'    => array( 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px' ),
		) );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array(
			'name'     => 'image_shadow',
			'selector' => '{{WRAPPER}} .enix-accordion-img img',
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$items           = $settings['items'];
		$title_tag       = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
		$widget_id       = $this->get_id();
		$img_size        = ! empty( $settings['enix_image_size'] ) ? $settings['enix_image_size'] : 'full';
		$show_left_icon  = isset( $settings['show_left_icon'] ) && 'yes' === $settings['show_left_icon'];
		$show_right_icon = isset( $settings['show_right_icon'] ) && 'yes' === $settings['show_right_icon'];
		$right_icon_type = ! empty( $settings['right_icon_type'] ) ? $settings['right_icon_type'] : 'default';
		$mobile_order    = ! empty( $settings['mobile_layout_order'] ) ? $settings['mobile_layout_order'] : 'image_first';
		$desktop_order   = ! empty( $settings['desktop_layout_order'] ) ? $settings['desktop_layout_order'] : 'accordion_image';

		if ( empty( $items ) ) {
			return;
		}

		// Build wrapper classes.
		$wrapper_classes = array( 'enix-accordion-wrapper' );
		if ( 'image_accordion' === $desktop_order ) {
			$wrapper_classes[] = 'enix-desktop-image-first';
		}
		$wrapper_classes[] = ( 'accordion_first' === $mobile_order )
			? 'enix-mobile-accordion-first'
			: 'enix-mobile-image-first';
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
			data-widget-id="<?php echo esc_attr( $widget_id ); ?>"
			role="tablist"
			aria-label="<?php esc_attr_e( 'Interactive Accordion', 'enix-addons' ); ?>">

			<!-- ── Accordion list (left) ──────────────────────── -->
			<div class="enix-accordion-left">
				<?php foreach ( $items as $index => $item ) :
					$is_active    = ( 0 === $index );
					$item_id      = 'enix-item-' . esc_attr( $widget_id ) . '-' . esc_attr( $index );
					$panel_id     = 'enix-panel-' . esc_attr( $widget_id ) . '-' . esc_attr( $index );
					$item_classes = array_filter( array(
						'enix-accordion-item',
						'elementor-repeater-item-' . esc_attr( $item['_id'] ),
						$is_active ? 'enix-active' : '',
					) );
				?>
					<div id="<?php echo esc_attr( $item_id ); ?>"
						class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>"
						role="tab"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
						data-index="<?php echo esc_attr( $index ); ?>">

						<div class="enix-accordion-header">

							<?php if ( $show_left_icon && ! empty( $item['icon']['value'] ) ) : ?>
								<span class="enix-accordion-icon" aria-hidden="true">
									<?php Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</span>
							<?php endif; ?>

							<<?php echo esc_html( $title_tag ); ?> class="enix-accordion-title">
								<?php echo esc_html( $item['title'] ); ?>
							</<?php echo esc_html( $title_tag ); ?>>

							<?php if ( $show_right_icon ) : ?>
								<span class="enix-accordion-arrow" aria-hidden="true">
									<?php if ( 'custom' === $right_icon_type && ! empty( $settings['right_icon_custom']['value'] ) ) :
										Icons_Manager::render_icon( $settings['right_icon_custom'], array( 'aria-hidden' => 'true' ) );
									else : ?>
										<svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									<?php endif; ?>
								</span>
							<?php endif; ?>

						</div><!-- .enix-accordion-header -->

						<div class="enix-accordion-desc"
							id="<?php echo esc_attr( $panel_id ); ?>"
							role="tabpanel"
							aria-labelledby="<?php echo esc_attr( $item_id ); ?>">
							<?php echo wp_kses_post( $item['description'] ); ?>
						</div><!-- .enix-accordion-desc -->

					</div><!-- .enix-accordion-item -->
				<?php endforeach; ?>
			</div><!-- .enix-accordion-left -->

			<!-- ── Image panel (right) ────────────────────────── -->
			<div class="enix-accordion-right" aria-live="polite">
				<?php foreach ( $items as $index => $item ) :
					$is_active = ( 0 === $index );
					$img_id    = ! empty( $item['image']['id'] ) ? intval( $item['image']['id'] ) : 0;
					$img_url   = ! empty( $item['image']['url'] ) ? $item['image']['url'] : Utils::get_placeholder_image_src();
				?>
					<div class="enix-accordion-img<?php echo $is_active ? ' enix-img-active' : ''; ?>"
						data-index="<?php echo esc_attr( $index ); ?>"
						aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>">
						<?php if ( $img_id ) :
							echo wp_get_attachment_image( $img_id, $img_size, false, array(
								'alt'     => esc_attr( $item['title'] ),
								'loading' => $is_active ? 'eager' : 'lazy',
							) );
						else : ?>
							<img src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $item['title'] ); ?>"
								loading="<?php echo $is_active ? 'eager' : 'lazy'; ?>">
						<?php endif; ?>
					</div><!-- .enix-accordion-img -->
				<?php endforeach; ?>
			</div><!-- .enix-accordion-right -->

		</div><!-- .enix-accordion-wrapper -->
		<?php
	}
}
