<?php
/**
 * Enix Timeline Steps Widget
 *
 * A beautiful animated timeline with full Elementor controls.
 *
 * @package EnixAddons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Guard: only define once.
if ( class_exists( 'Enix_Timeline_Steps' ) ) {
	return;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

/**
 * Class Enix_Timeline_Steps
 */
class Enix_Timeline_Steps extends Widget_Base {

	// ── Identity ─────────────────────────────────────────────────────────────

	public function get_name() {
		return 'enix_timeline_steps';
	}

	public function get_title() {
		return esc_html__( 'Enix Timeline Steps', 'enix-addons' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return array( 'enix-elements' );
	}

	public function get_keywords() {
		return array( 'enix', 'timeline', 'steps', 'process', 'workflow', 'history' );
	}

	public function get_style_depends() {
		return array( 'enix-timeline-steps' );
	}

	public function get_script_depends() {
		return array( 'enix-timeline-steps' );
	}

	// ── Controls ─────────────────────────────────────────────────────────────

	protected function register_controls() {

		// ════════════════════════════════════════════════════════════════════
		// CONTENT TAB — Items
		// ════════════════════════════════════════════════════════════════════

		$this->start_controls_section(
			'enix_section_timeline_items',
			array(
				'label' => esc_html__( 'Timeline Steps', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'enix_step_label',
			array(
				'label'       => esc_html__( 'Step Label', 'enix-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Step 01', 'enix-addons' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'enix_step_title',
			array(
				'label'       => esc_html__( 'Title', 'enix-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Timeline Step Title', 'enix-addons' ),
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'enix_step_description',
			array(
				'label'       => esc_html__( 'Description', 'enix-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'Add a short description for this timeline step.', 'enix-addons' ),
				'placeholder' => esc_html__( 'Type your description here', 'enix-addons' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		// Icon Type (None, Icon, Image)
		$repeater->add_control(
			'enix_icon_type',
			array(
				'label'   => esc_html__( 'Icon Type', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'none' => array(
						'title' => esc_html__( 'None', 'enix-addons' ),
						'icon'  => 'eicon-ban',
					),
					'icon' => array(
						'title' => esc_html__( 'Icon', 'enix-addons' ),
						'icon'  => 'eicon-paint-brush',
					),
					'image' => array(
						'title' => esc_html__( 'Image', 'enix-addons' ),
						'icon'  => 'eicon-image-bold',
					),
				),
				'default' => 'icon',
				'toggle'  => false,
			)
		);

		// Add Icon Switcher (Yes/No)
		$repeater->add_control(
			'enix_show_header_icon',
			array(
				'label'        => esc_html__( 'Add icon?', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'enix-addons' ),
				'label_off'    => esc_html__( 'No', 'enix-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'enix_icon_type!' => 'none',
				),
			)
		);

		// Icon Control (Dekhabe jokhon Type = Icon hobe)
		$repeater->add_control(
			'enix_header_icon',
			array(
				'label'   => esc_html__( 'Header Icon', 'enix-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'enix_icon_type'      => 'icon',
					'enix_show_header_icon' => 'yes',
				),
			)
		);

		// Image Control (Dekhabe jokhon Type = Image hobe)
		$repeater->add_control(
			'enix_header_image',
			array(
				'label'   => esc_html__( 'Header Image', 'enix-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'enix_icon_type'      => 'image',
					'enix_show_header_icon' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'enix_step_position',
			array(
				'label'   => esc_html__( 'Card Position', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'left'  => esc_html__( 'Left', 'enix-addons' ),
					'right' => esc_html__( 'Right', 'enix-addons' ),
				),
				'default' => 'left',
			)
		);

		$repeater->add_control(
			'enix_step_accent_color',
			array(
				'label'   => esc_html__( 'Accent Color (override)', 'enix-addons' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
				'description' => esc_html__( 'Leave empty to use global accent color.', 'enix-addons' ),
			)
		);

		// Icon List Repeater
		$icon_list_repeater = new Repeater();

		$icon_list_repeater->add_control(
			'list_text',
			array(
				'label'       => esc_html__( 'Text', 'enix-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'List Item', 'enix-addons' ),
				'label_block' => true,
			)
		);

		$icon_list_repeater->add_control(
			'list_icon',
			array(
				'label'   => esc_html__( 'Icon', 'enix-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'enix_icon_list',
			array(
				'label'       => esc_html__( 'Icon List', 'enix-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $icon_list_repeater->get_controls(),
				'title_field' => '{{{ list_text }}}',
			)
		);

		$repeater->add_control(
			'enix_icon_position',
			array(
				'label'   => esc_html__( 'Icon Alignment', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'enix-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'enix-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'left',
				'toggle'  => false,
			)
		);

		$repeater->add_control(
			'enix_icon_gap',
			array(
				'label'      => esc_html__( 'Icon Gap', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-align-left .enix-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .icon-align-right .enix-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'enix_timeline_items',
			array(
				'label'       => esc_html__( 'Steps', 'enix-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'enix_step_label'       => esc_html__( 'Step 01', 'enix-addons' ),
						'enix_step_title'       => esc_html__( 'Discovery & Research', 'enix-addons' ),
						'enix_step_description' => esc_html__( 'We start by understanding your goals, audience, and challenges to craft the right strategy.', 'enix-addons' ),
						'enix_step_position'    => 'left',
					),
					array(
						'enix_step_label'       => esc_html__( 'Step 02', 'enix-addons' ),
						'enix_step_title'       => esc_html__( 'Design & Planning', 'enix-addons' ),
						'enix_step_description' => esc_html__( 'Our team creates wireframes and high-fidelity designs with your brand identity in mind.', 'enix-addons' ),
						'enix_step_position'    => 'right',
					),
					array(
						'enix_step_label'       => esc_html__( 'Step 03', 'enix-addons' ),
						'enix_step_title'       => esc_html__( 'Development', 'enix-addons' ),
						'enix_step_description' => esc_html__( 'We build fast, accessible, and scalable solutions using modern technologies.', 'enix-addons' ),
						'enix_step_position'    => 'left',
					),
					array(
						'enix_step_label'       => esc_html__( 'Step 04', 'enix-addons' ),
						'enix_step_title'       => esc_html__( 'Launch & Support', 'enix-addons' ),
						'enix_step_description' => esc_html__( 'After rigorous testing, we go live and provide ongoing support to ensure smooth operations.', 'enix-addons' ),
						'enix_step_position'    => 'right',
					),
				),
				'title_field' => '{{{ enix_step_label }}} — {{{ enix_step_title }}}',
			)
		);

		$this->end_controls_section();

		// ── Layout Section ───────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_section_timeline_layout',
			array(
				'label' => esc_html__( 'Layout', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'enix_title_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'h5'  => 'H5',
					'div' => 'div',
					'p'   => 'p',
				),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'enix_animation_delay',
			array(
				'label'   => esc_html__( 'Animation Stagger (ms)', 'enix-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 500,
				'step'    => 10,
				'default' => 120,
			)
		);

		$this->add_control(
			'enix_animation_threshold',
			array(
				'label'       => esc_html__( 'Scroll Trigger Threshold (%)', 'enix-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'range'       => array( '%' => array( 'min' => 0, 'max' => 50 ) ),
				'default'     => array( 'size' => 15, 'unit' => '%' ),
				'description' => esc_html__( 'How much of the card must be visible before animating in.', 'enix-addons' ),
			)
		);

		$this->add_responsive_control(
			'enix_container_width',
			array(
				'label'      => esc_html__( 'Container Max Width', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 600, 'max' => 1800 ),
					'%'  => array( 'min' => 50, 'max' => 100 ),
				),
				'default'    => array( 'size' => 1000, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_item_gap',
			array(
				'label'      => esc_html__( 'Gap Between Steps', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
				'default'    => array( 'size' => 40, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_section_padding',
			array(
				'label'      => esc_html__( 'Section Padding', 'enix-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '60',
					'right'  => '20',
					'bottom' => '60',
					'left'   => '20',
					'unit'   => 'px',
				),
			)
		);

		// Content Alignment (Right Side or General)
		$this->add_control(
			'content_alignment',
			array(
				'label'   => esc_html__( 'Content Alignment', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'enix-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'enix-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'enix-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-card' => 'text-align: {{VALUE}};',
				),
			)
		);

		// Content Alignment (Left Card specific)
		$this->add_control(
			'content_alignment_left',
			array(
				'label'   => esc_html__( 'Content Alignment (Left)', 'enix-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'enix-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'enix-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'enix-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-item.enix-left .enix-timeline-card' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ════════════════════════════════════════════════════════════════════
		// STYLE TAB — Timeline Line
		// ════════════════════════════════════════════════════════════════════

		$this->start_controls_section(
			'enix_style_timeline_line',
			array(
				'label' => esc_html__( 'Timeline Line & Dot', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_line_color',
			array(
				'label'     => esc_html__( 'Line Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E2E8F0',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-line' => '--enix-line-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_line_width',
			array(
				'label'      => esc_html__( 'Line Width', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 1, 'max' => 10 ) ),
				'default'    => array( 'size' => 2, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-line' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'enix_dot_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6366F1',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-dot' => 'background: radial-gradient(circle at top left, #A5B4FC, {{VALUE}});',
				),
			)
		);

		$this->add_responsive_control(
			'enix_dot_size',
			array(
				'label'      => esc_html__( 'Dot Size', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 8, 'max' => 40 ) ),
				'default'    => array( 'size' => 18, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ── Card Style ────────────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_card',
			array(
				'label' => esc_html__( 'Card', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_card_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-card' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'enix_card_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E2E8F0',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-card' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'enix_card_border_hover_color',
			array(
				'label'     => esc_html__( 'Border Hover Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6366F1',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-item:hover .enix-timeline-card' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'enix-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '24',
					'right'  => '24',
					'bottom' => '24',
					'left'   => '24',
					'unit'   => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'enix_card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'enix-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'enix_card_shadow',
				'selector' => '{{WRAPPER}} .enix-timeline-card',
			)
		);

		$this->add_responsive_control(
			'enix_card_max_width',
			array(
				'label'      => esc_html__( 'Card Max Width', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 700 ),
					'%'  => array( 'min' => 20, 'max' => 80 ),
				),
				'default'    => array( 'size' => 420, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-timeline-card' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ── Icon Box Style ────────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_icon',
			array(
				'label' => esc_html__( 'Icon Box', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_accent_color',
			array(
				'label'       => esc_html__( 'Global Accent Color', 'enix-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#6366F1',
				'description' => esc_html__( 'Used for icon stroke, step label, and dot. Per-item override available in each step.', 'enix-addons' ),
				'selectors'   => array(
					'{{WRAPPER}} .enix-timeline-section' => '--enix-accent: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'enix_icon_box_bg',
			array(
				'label'     => esc_html__( 'Icon Box Background', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(216,169,30,0.15)',
				'selectors' => array(
					'{{WRAPPER}} .enix-icon-box' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_icon_box_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 30, 'max' => 120 ) ),
				'default'    => array( 'size' => 58, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_icon_box_radius',
			array(
				'label'      => esc_html__( 'Icon Box Border Radius', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'size' => 16, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-icon-box' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'enix_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 10, 'max' => 80 ) ),
				'default'    => array( 'size' => 22, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-icon-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .enix-icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'enix_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d8a91e',
				'selectors' => array(
					// Font-based icons (FA font mode)
					'{{WRAPPER}} .enix-icon-box i'                                               => 'color: {{VALUE}};',
					// Parent color – FA SVG mode uses currentColor via fill
					'{{WRAPPER}} .enix-icon-box'                                                 => 'color: {{VALUE}};',
					// Outline/stroke SVG icons
					'{{WRAPPER}} .enix-icon-box svg'                                             => 'stroke: {{VALUE}};',
					// FA SVG mode: paths use currentColor fill – override directly
					'{{WRAPPER}} .enix-icon-box svg path'                                        => 'fill: {{VALUE}}; stroke: none;',
					'{{WRAPPER}} .enix-icon-box svg rect, {{WRAPPER}} .enix-icon-box svg circle' => 'fill: {{VALUE}}; stroke: none;',
				),
			)
		);

		$this->end_controls_section();

		// ── Typography: Step Label ────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_label',
			array(
				'label' => esc_html__( 'Step Label', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_label_color',
			array(
				'label'     => esc_html__( 'Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d8a91e',
				'selectors' => array(
					'{{WRAPPER}} .enix-step-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'enix_label_typography',
				'selector' => '{{WRAPPER}} .enix-step-label',
			)
		);

		$this->end_controls_section();

		// ── Typography: Title ─────────────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_title',
			array(
				'label' => esc_html__( 'Card Title', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_title_color',
			array(
				'label'     => esc_html__( 'Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1E293B',
				'selectors' => array(
					'{{WRAPPER}} .enix-card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'enix_title_typography',
				'selector' => '{{WRAPPER}} .enix-card-title',
			)
		);

		$this->add_responsive_control(
			'enix_title_margin',
			array(
				'label'      => esc_html__( 'Margin Bottom', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'size' => 15, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ── Typography: Description ───────────────────────────────────────────
		$this->start_controls_section(
			'enix_style_description',
			array(
				'label' => esc_html__( 'Description', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_desc_color',
			array(
				'label'     => esc_html__( 'Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => array(
					'{{WRAPPER}} .enix-card-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'enix_desc_typography',
				'selector' => '{{WRAPPER}} .enix-card-text',
			)
		);

		$this->end_controls_section();

		// ── Connector Line (between dot and card) ─────────────────────────────
		$this->start_controls_section(
			'enix_style_connector',
			array(
				'label' => esc_html__( 'Connector Line', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enix_connector_color',
			array(
				'label'     => esc_html__( 'Connector Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(216,169,30,0.5)',
				'selectors' => array(
					'{{WRAPPER}} .enix-timeline-item.enix-left::before'  => 'background: linear-gradient(270deg, {{VALUE}}, rgba(216,169,30,0));',
					'{{WRAPPER}} .enix-timeline-item.enix-right::before' => 'background: linear-gradient(90deg, {{VALUE}}, rgba(216,169,30,0));',
				),
			)
		);

		$this->add_control(
			'enix_show_connector',
			array(
				'label'        => esc_html__( 'Show Connector Line', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'enix-addons' ),
				'label_off'    => esc_html__( 'Hide', 'enix-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	// ── Render ───────────────────────────────────────────────────────────────

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$items          = $settings['enix_timeline_items'];
		$title_tag      = ! empty( $settings['enix_title_tag'] ) ? $settings['enix_title_tag'] : 'h3';
		$anim_delay     = isset( $settings['enix_animation_delay'] ) ? intval( $settings['enix_animation_delay'] ) : 120;
		$threshold      = isset( $settings['enix_animation_threshold']['size'] ) ? floatval( $settings['enix_animation_threshold']['size'] ) / 100 : 0.15;
		$show_connector = isset( $settings['enix_show_connector'] ) && 'yes' === $settings['enix_show_connector'];

		if ( empty( $items ) ) {
			return;
		}

		$connector_class = $show_connector ? '' : ' enix-no-connector';
		?>
		<div class="enix-timeline-section">
			<div class="enix-timeline-wrapper">

				<div class="enix-timeline-line" aria-hidden="true"></div>

				<?php foreach ( $items as $index => $item ) :
					$position    = ! empty( $item['enix_step_position'] ) ? $item['enix_step_position'] : 'left';
					$item_class  = 'enix-timeline-item enix-' . esc_attr( $position ) . $connector_class;
					$item_class .= ' elementor-repeater-item-' . esc_attr( $item['_id'] );

					// Per-item accent override.
					$accent_style = '';
					if ( ! empty( $item['enix_step_accent_color'] ) ) {
						$accent_style = ' style="--enix-accent:' . esc_attr( $item['enix_step_accent_color'] ) . ';"';
					}
				?>
					<div class="<?php echo esc_attr( $item_class ); ?>"<?php echo $accent_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

						<div class="enix-timeline-dot" aria-hidden="true"></div>

						<div class="enix-timeline-card" data-enix-delay="<?php echo esc_attr( $index * $anim_delay ); ?>">

							<div class="enix-timeline-card-header">

								<?php 
								// Display Icon/Image based on type selection
								if ( isset( $item['enix_show_header_icon'] ) && 'yes' === $item['enix_show_header_icon'] ) :
									$icon_type = ! empty( $item['enix_icon_type'] ) ? $item['enix_icon_type'] : 'icon';
									
									if ( 'icon' === $icon_type && ! empty( $item['enix_header_icon']['value'] ) ) :
										?>
										<div class="enix-icon-box" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['enix_header_icon'], array( 'aria-hidden' => 'true' ) ); ?>
										</div>
										<?php
									elseif ( 'image' === $icon_type && ! empty( $item['enix_header_image']['url'] ) ) :
										$image_url = $item['enix_header_image']['url'];
										$image_alt = ! empty( $item['enix_header_image']['alt'] ) ? $item['enix_header_image']['alt'] : '';
										?>
										<div class="enix-icon-box enix-image-box" aria-hidden="true">
											<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
										</div>
										<?php
									endif;
								endif;
								?>

								<div class="enix-card-content">
									<?php if ( ! empty( $item['enix_step_label'] ) ) : ?>
										<span class="enix-step-label"><?php echo esc_html( $item['enix_step_label'] ); ?></span>
									<?php endif; ?>

									<<?php echo esc_html( $title_tag ); ?> class="enix-card-title">
										<?php echo esc_html( $item['enix_step_title'] ); ?>
									</<?php echo esc_html( $title_tag ); ?>>
								</div>

							</div><!-- .enix-timeline-card-header -->

							<?php if ( ! empty( $item['enix_step_description'] ) ) : ?>
								<div class="enix-timeline-description">
									<?php echo $item['enix_step_description']; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $item['enix_icon_list'] ) ) : ?>
								<?php 
								$icon_position = ! empty( $item['enix_icon_position'] ) ? $item['enix_icon_position'] : 'left';
								$align_class = 'icon-align-' . $icon_position;
								?>
								<ul class="enix-icon-list">
									<?php foreach ( $item['enix_icon_list'] as $list_item ) : ?>
										<li class="<?php echo esc_attr( $align_class ); ?>">
											
											<?php if ( 'left' === $icon_position ) : ?>
												<span class="enix-icon"><?php Icons_Manager::render_icon( $list_item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
												<span class="enix-list-text"><?php echo esc_html( $list_item['list_text'] ); ?></span>
											<?php else : ?>
												<span class="enix-list-text"><?php echo esc_html( $list_item['list_text'] ); ?></span>
												<span class="enix-icon"><?php Icons_Manager::render_icon( $list_item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
											<?php endif; ?>

										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

						</div><!-- .enix-timeline-card -->

					</div><!-- .enix-timeline-item -->
				<?php endforeach; ?>

			</div><!-- .enix-timeline-wrapper -->
		</div><!-- .enix-timeline-section -->

		<script>
		(function() {
			var threshold = <?php echo esc_js( $threshold ); ?>;
			var cards     = document.querySelectorAll( '#elementor-element-<?php echo esc_js( $this->get_id() ); ?> .enix-timeline-card' );
			if ( ! cards.length ) return;
			var observer  = new IntersectionObserver( function( entries ) {
				entries.forEach( function( entry ) {
					if ( entry.isIntersecting ) {
						var delay = parseInt( entry.target.getAttribute( 'data-enix-delay' ) ) || 0;
						setTimeout( function() {
							entry.target.classList.add( 'enix-show' );
						}, delay );
						observer.unobserve( entry.target );
					}
				} );
			}, { threshold: threshold } );
			cards.forEach( function( card ) { observer.observe( card ); } );
		}());
		</script>
		<?php
	}
}
