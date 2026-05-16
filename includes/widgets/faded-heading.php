<?php
/**
 * Enix Faded Heading Widget
 *
 * A flexible heading widget with a static "Side Fade" (edge-fade) mask effect.
 * Mirrors Elementor's native Heading controls and adds an Edge Fading section.
 *
 * @package Enix_Addons
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'Enix_Faded_Heading' ) ) { return; }

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;

/**
 * Class Enix_Faded_Heading
 */
class Enix_Faded_Heading extends Widget_Base {

	public function get_name()       { return 'enix_faded_heading'; }
	public function get_title()      { return esc_html__( 'Enix Faded Heading', 'enix-addons' ); }
	public function get_icon()       { return 'eicon-t-letter'; }
	public function get_categories() { return array( 'enix-elements' ); }
	public function get_keywords()   { return array( 'enix', 'heading', 'title', 'faded', 'fade', 'mask', 'gradient' ); }

	protected function register_controls() {

		// ═══════════════════════════════════════════════════════════
		// CONTENT TAB
		// ═══════════════════════════════════════════════════════════
		$this->start_controls_section(
			'enix_section_heading',
			array(
				'label' => esc_html__( 'Heading', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'enix-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'dynamic'     => array( 'active' => true ),
				'default'     => esc_html__( 'Cosmetic Safety Institute', 'enix-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'enix-addons' ),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'enix-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => esc_html__( 'https://your-link.com', 'enix-addons' ),
				'default'     => array(
					'url'         => '',
					'is_external' => '',
					'nofollow'    => '',
				),
			)
		);

		$this->add_control(
			'header_size',
			array(
				'label'   => esc_html__( 'HTML Tag', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'        => esc_html__( 'Alignment', 'enix-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'enix-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'enix-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'enix-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'enix-addons' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors'    => array(
					'{{WRAPPER}} .enix-faded-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════════════
		// STYLE TAB — Title
		// ═══════════════════════════════════════════════════════════
		$this->start_controls_section(
			'enix_section_title_style',
			array(
				'label' => esc_html__( 'Title', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'enix_tabs_title_style' );

		// Normal
		$this->start_controls_tab(
			'enix_tab_title_normal',
			array( 'label' => esc_html__( 'Normal', 'enix-addons' ) )
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Text Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .enix-faded-heading-title, {{WRAPPER}} .enix-faded-heading-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'enix_tab_title_hover',
			array( 'label' => esc_html__( 'Hover', 'enix-addons' ) )
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .enix-faded-heading-title:hover, {{WRAPPER}} .enix-faded-heading-title a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_transition',
			array(
				'label'      => esc_html__( 'Transition Duration (s)', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 3, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 0.3 ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-faded-heading-title, {{WRAPPER}} .enix-faded-heading-title a' => 'transition: color {{SIZE}}s ease;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .enix-faded-heading-title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			array(
				'name'     => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .enix-faded-heading-title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .enix-faded-heading-title',
			)
		);

		$this->add_control(
			'title_blend_mode',
			array(
				'label'     => esc_html__( 'Blend Mode', 'enix-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''            => esc_html__( 'Normal', 'enix-addons' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn'  => 'Color Burn',
					'hard-light'  => 'Hard Light',
					'soft-light'  => 'Soft Light',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'luminosity'  => 'Luminosity',
				),
				'selectors' => array(
					'{{WRAPPER}} .enix-faded-heading-title' => 'mix-blend-mode: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════════════
		// STYLE TAB — Edge Fading Effects
		// ═══════════════════════════════════════════════════════════
		$this->start_controls_section(
			'enix_section_edge_fade',
			array(
				'label' => esc_html__( 'Edge Fading Effects', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'enable_fade',
			array(
				'label'        => esc_html__( 'Enable Fade', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'enix-addons' ),
				'label_off'    => esc_html__( 'Off', 'enix-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'fade_width',
			array(
				'label'      => esc_html__( 'Fade Width (%)', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array( 'min' => 0, 'max' => 50, 'step' => 1 ),
				),
				'default'    => array( 'size' => 15, 'unit' => '%' ),
				'condition'  => array( 'enable_fade' => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-faded-heading.has-edge-fade' =>
						'--enix-fade-start: {{SIZE}}%; --enix-fade-end: calc(100% - {{SIZE}}%);' .
						'-webkit-mask-image: linear-gradient(to right, transparent 0%, black calc({{SIZE}}% * var(--enix-fade-smooth, 1)), black calc(100% - ({{SIZE}}% * var(--enix-fade-smooth, 1))), transparent 100%);' .
						'mask-image: linear-gradient(to right, transparent 0%, black calc({{SIZE}}% * var(--enix-fade-smooth, 1)), black calc(100% - ({{SIZE}}% * var(--enix-fade-smooth, 1))), transparent 100%);',
				),
			)
		);

		$this->add_control(
			'fade_smoothness',
			array(
				'label'       => esc_html__( 'Fade Smoothness', 'enix-addons' ),
				'description' => esc_html__( 'Adjusts the transition curve of the mask. 1 = linear, higher = smoother/wider, lower = sharper.', 'enix-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array( 'min' => 0.2, 'max' => 2, 'step' => 0.1 ),
				),
				'default'     => array( 'size' => 1 ),
				'condition'   => array( 'enable_fade' => 'yes' ),
				'selectors'   => array(
					'{{WRAPPER}} .enix-faded-heading.has-edge-fade' => '--enix-fade-smooth: {{SIZE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( '' === $settings['title'] ) {
			return;
		}

		$tag = ! empty( $settings['header_size'] ) ? $settings['header_size'] : 'h2';
		$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' );
		if ( ! in_array( $tag, $allowed_tags, true ) ) {
			$tag = 'h2';
		}

		$title = $settings['title'];

		// Optional link wrapping.
		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['link'] );
			$title = sprintf(
				'<a %1$s>%2$s</a>',
				$this->get_render_attribute_string( 'url' ),
				esc_html( $title )
			);
		} else {
			$title = esc_html( $title );
		}

		$wrapper_classes = array( 'enix-faded-heading' );
		if ( 'yes' === $settings['enable_fade'] ) {
			$wrapper_classes[] = 'has-edge-fade';
		}

		$this->add_render_attribute(
			'wrapper',
			'class',
			$wrapper_classes
		);

		$this->add_render_attribute( 'title', 'class', 'enix-faded-heading-title' );

		printf(
			'<div %1$s><%2$s %3$s>%4$s</%2$s></div>',
			$this->get_render_attribute_string( 'wrapper' ),
			esc_attr( $tag ),
			$this->get_render_attribute_string( 'title' ),
			$title // already escaped above
		);
	}

	protected function content_template() {
		?>
		<#
		var tag = settings.header_size ? settings.header_size : 'h2';
		var allowed = ['h1','h2','h3','h4','h5','h6','div','span','p'];
		if ( allowed.indexOf( tag ) === -1 ) { tag = 'h2'; }

		var titleHtml = settings.title;
		if ( settings.link && settings.link.url ) {
			titleHtml = '<a href="' + _.escape( settings.link.url ) + '">' + titleHtml + '</a>';
		}

		var wrapperClass = 'enix-faded-heading';
		if ( settings.enable_fade === 'yes' ) {
			wrapperClass += ' has-edge-fade';
		}
		#>
		<div class="{{ wrapperClass }}">
			<{{ tag }} class="enix-faded-heading-title">{{{ titleHtml }}}</{{ tag }}>
		</div>
		<?php
	}
}
