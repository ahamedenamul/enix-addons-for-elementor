<?php
/**
 * Enix Inline Link Preview Widget
 *
 * Renders a sentence/paragraph where selected words become hover-triggered
 * floating image previews (Aceternity-UI style).
 *
 * @package Enix_Addons
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'Enix_Inline_Link_Preview' ) ) { return; }

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

class Enix_Inline_Link_Preview extends Widget_Base {

	public function get_name()       { return 'enix_inline_link_preview'; }
	public function get_title()      { return esc_html__( 'Enix Inline Link Preview', 'enix-addons' ); }
	public function get_icon()       { return 'eicon-image-rollover'; }
	public function get_categories() { return array( 'enix-elements' ); }
	public function get_keywords()   { return array( 'enix', 'link', 'preview', 'hover', 'image', 'inline', 'aceternity' ); }

	public function get_style_depends()  { return array( 'enix-inline-link-preview' ); }
	public function get_script_depends() { return array( 'enix-inline-link-preview' ); }

	protected function register_controls() {

		// ─── CONTENT ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Item Type', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => array(
					'text' => esc_html__( 'Normal Text', 'enix-addons' ),
					'link' => esc_html__( 'Preview Link', 'enix-addons' ),
				),
			)
		);

		$repeater->add_control(
			'normal_text',
			array(
				'label'       => esc_html__( 'Text', 'enix-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'Type your text here', 'enix-addons' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array( 'type' => 'text' ),
			)
		);

		$repeater->add_control(
			'link_text',
			array(
				'label'     => esc_html__( 'Link Text', 'enix-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'this guy', 'enix-addons' ),
				'dynamic'   => array( 'active' => true ),
				'condition' => array( 'type' => 'link' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'URL', 'enix-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => array( 'url' => '#', 'is_external' => true, 'nofollow' => false ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array( 'type' => 'link' ),
			)
		);

		$repeater->add_control(
			'preview_image',
			array(
				'label'     => esc_html__( 'Preview Image', 'enix-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array( 'url' => Utils::get_placeholder_image_src() ),
				'dynamic'   => array( 'active' => true ),
				'condition' => array( 'type' => 'link' ),
			)
		);

		$repeater->add_control(
			'add_space_after',
			array(
				'label'        => esc_html__( 'Space After', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'content_repeater',
			array(
				'label'       => esc_html__( 'Inline Items', 'enix-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ type === "link" ? "🔗 " + link_text : "📝 " + normal_text }}}',
				'default'     => array(
					array( 'type' => 'text', 'normal_text' => 'Visit', 'add_space_after' => 'yes' ),
					array( 'type' => 'link', 'link_text' => 'Acetnernity UI', 'add_space_after' => 'yes' ),
					array( 'type' => 'text', 'normal_text' => 'and for amazing Tailwind and Framer Motion components. I listen to', 'add_space_after' => 'yes' ),
					array( 'type' => 'link', 'link_text' => 'this guy', 'add_space_after' => 'yes' ),
					array( 'type' => 'text', 'normal_text' => 'and I watch', 'add_space_after' => 'yes' ),
					array( 'type' => 'link', 'link_text' => 'this movie', 'add_space_after' => 'yes' ),
					array( 'type' => 'text', 'normal_text' => 'twice a day.', 'add_space_after' => 'no' ),
				),
			)
		);

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'enix-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array( 'title' => esc_html__( 'Left', 'enix-addons' ), 'icon' => 'eicon-text-align-left' ),
					'center'  => array( 'title' => esc_html__( 'Center', 'enix-addons' ), 'icon' => 'eicon-text-align-center' ),
					'right'   => array( 'title' => esc_html__( 'Right', 'enix-addons' ), 'icon' => 'eicon-text-align-right' ),
					'justify' => array( 'title' => esc_html__( 'Justify', 'enix-addons' ), 'icon' => 'eicon-text-align-justify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .enix-inline-preview-wrap' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ─── STYLE: Typography ───────────────────────────────────
		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => esc_html__( 'Text', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .enix-inline-preview-wrap',
			)
		);

		$this->add_control(
			'normal_text_color',
			array(
				'label'     => esc_html__( 'Normal Text Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .enix-inline-preview-wrap' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ─── STYLE: Link ─────────────────────────────────────────
		$this->start_controls_section(
			'section_style_link',
			array(
				'label' => esc_html__( 'Preview Link', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'label'    => esc_html__( 'Typography', 'enix-addons' ),
				'selector' => '{{WRAPPER}} .enix-preview-link',
			)
		);

		$this->add_control(
			'link_font_weight',
			array(
				'label'   => esc_html__( 'Font Weight (Quick)', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''    => esc_html__( 'Default', 'enix-addons' ),
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'default' => '',
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-link' => 'font-weight: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'link_underline',
			array(
				'label'   => esc_html__( 'Underline', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'underline' => esc_html__( 'Underline', 'enix-addons' ),
					'none'      => esc_html__( 'None', 'enix-addons' ),
					'dotted'    => esc_html__( 'Dotted', 'enix-addons' ),
					'dashed'    => esc_html__( 'Dashed', 'enix-addons' ),
					'wavy'      => esc_html__( 'Wavy', 'enix-addons' ),
				),
				'default'   => 'underline',
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-link' => 'text-decoration-line: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_link_colors' );

		$this->start_controls_tab( 'tab_link_normal', array( 'label' => esc_html__( 'Normal', 'enix-addons' ) ) );
		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-link' => 'color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_link_hover', array( 'label' => esc_html__( 'Hover', 'enix-addons' ) ) );
		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-link:hover' => 'color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// ─── STYLE: Floating Preview Card ────────────────────────
		$this->start_controls_section(
			'section_style_popup',
			array(
				'label' => esc_html__( 'Floating Preview', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'popup_width',
			array(
				'label'      => esc_html__( 'Width (px)', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 80, 'max' => 600 ) ),
				'default'    => array( 'size' => 220, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-preview-popup' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'popup_height',
			array(
				'label'      => esc_html__( 'Height (px)', 'enix-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 60, 'max' => 600 ) ),
				'default'    => array( 'size' => 140, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-preview-popup' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'popup_object_fit',
			array(
				'label'   => esc_html__( 'Image Fit', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'cover'   => 'Cover',
					'contain' => 'Contain',
					'fill'    => 'Fill',
				),
				'default' => 'cover',
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-popup img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'popup_bg',
			array(
				'label'     => esc_html__( 'Background', 'enix-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-popup' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'popup_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'enix-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array( 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'unit' => 'px', 'isLinked' => true ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-preview-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'popup_border',
				'selector' => '{{WRAPPER}} .enix-preview-popup',
			)
		);

		$this->add_responsive_control(
			'popup_padding',
			array(
				'label'      => esc_html__( 'Padding', 'enix-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array( 'top' => 4, 'right' => 4, 'bottom' => 4, 'left' => 4, 'unit' => 'px', 'isLinked' => true ),
				'selectors'  => array(
					'{{WRAPPER}} .enix-preview-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'popup_shadow',
				'selector' => '{{WRAPPER}} .enix-preview-popup',
			)
		);

		$this->end_controls_section();

		// ─── STYLE: Animation ────────────────────────────────────
		$this->start_controls_section(
			'section_style_anim',
			array(
				'label' => esc_html__( 'Animation', 'enix-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'animation_type',
			array(
				'label'   => esc_html__( 'Entrance Animation', 'enix-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale',
				'options' => array(
					'scale'      => esc_html__( 'Scale', 'enix-addons' ),
					'fade'       => esc_html__( 'Fade', 'enix-addons' ),
					'slide-up'   => esc_html__( 'Slide Up', 'enix-addons' ),
					'slide-down' => esc_html__( 'Slide Down', 'enix-addons' ),
				),
			)
		);

		$this->add_control(
			'animation_duration',
			array(
				'label'   => esc_html__( 'Duration (s)', 'enix-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array( 'px' => array( 'min' => 0.05, 'max' => 2, 'step' => 0.05 ) ),
				'default' => array( 'size' => 0.25 ),
				'selectors' => array(
					'{{WRAPPER}} .enix-preview-popup' => 'transition-duration: {{SIZE}}s;',
				),
			)
		);

		$this->add_control(
			'follow_cursor',
			array(
				'label'        => esc_html__( 'Follow Cursor', 'enix-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Preview slightly tracks the cursor horizontally.', 'enix-addons' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = isset( $settings['content_repeater'] ) ? $settings['content_repeater'] : array();
		$anim     = ! empty( $settings['animation_type'] ) ? $settings['animation_type'] : 'scale';
		$follow   = ( 'yes' === ( $settings['follow_cursor'] ?? 'yes' ) ) ? '1' : '0';

		echo '<div class="enix-inline-preview-wrap" data-anim="' . esc_attr( $anim ) . '" data-follow="' . esc_attr( $follow ) . '">';

		foreach ( $items as $item ) {
			$type  = $item['type'] ?? 'text';
			$space = ( 'yes' === ( $item['add_space_after'] ?? 'yes' ) ) ? ' ' : '';

			if ( 'text' === $type ) {
				echo '<span class="enix-normal-text">' . wp_kses_post( $item['normal_text'] ?? '' ) . '</span>' . esc_html( $space );
			} else {
				$url         = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
				$target      = ! empty( $item['link']['is_external'] ) ? ' target="_blank"' : '';
				$nofollow    = ! empty( $item['link']['nofollow'] ) ? ' rel="nofollow"' : '';
				$img_url     = ! empty( $item['preview_image']['url'] ) ? $item['preview_image']['url'] : Utils::get_placeholder_image_src();
				$link_text   = $item['link_text'] ?? '';

				echo '<span class="enix-link-container">';
				echo '<a class="enix-preview-link" href="' . esc_url( $url ) . '"' . $target . $nofollow . '>' . esc_html( $link_text ) . '</a>';
				echo '<span class="enix-preview-popup" aria-hidden="true"><img src="' . esc_url( $img_url ) . '" alt="" loading="lazy" /></span>';
				echo '</span>' . esc_html( $space );
			}
		}

		echo '</div>';
	}
}
