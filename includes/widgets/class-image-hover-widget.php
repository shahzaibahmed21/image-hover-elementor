<?php
namespace IHE\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Hover_Widget extends Widget_Base {

	public function get_name() {
		return 'image-hover';
	}

	public function get_title() {
		return esc_html__( 'Image Hover', 'image-hover-elementor' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_categories() {
		return [ 'image-hover-elementor', 'basic' ];
	}

	public function get_keywords() {
		return [ 'image', 'hover', 'overlay', 'swap', 'picture' ];
	}

	public function get_style_depends() {
		return [ 'image-hover-elementor' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_overlay_content_controls();
		$this->register_style_controls();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'image-hover-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'image-hover-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'default' => 'large',
			]
		);

		$this->add_control(
			'image_hover',
			[
				'label'   => esc_html__( 'Hover Image', 'image-hover-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_hover',
				'default'   => 'large',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => esc_html__( 'Caption', 'image-hover-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => '',
				'placeholder' => esc_html__( 'Enter your image caption', 'image-hover-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => esc_html__( 'Link', 'image-hover-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => esc_html__( 'None', 'image-hover-elementor' ),
					'file'   => esc_html__( 'Media File', 'image-hover-elementor' ),
					'custom' => esc_html__( 'Custom URL', 'image-hover-elementor' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'image-hover-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'image-hover-elementor' ),
				'condition'   => [
					'link_to' => 'custom',
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label'     => esc_html__( 'Lightbox', 'image-hover-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default' => esc_html__( 'Default', 'image-hover-elementor' ),
					'yes'     => esc_html__( 'Yes', 'image-hover-elementor' ),
					'no'      => esc_html__( 'No', 'image-hover-elementor' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => esc_html__( 'View', 'image-hover-elementor' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();
	}

	protected function register_overlay_content_controls() {
		$this->start_controls_section(
			'section_overlay',
			[
				'label' => esc_html__( 'Hover Overlay', 'image-hover-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_overlay',
			[
				'label'        => esc_html__( 'Show Overlay on Hover', 'image-hover-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'image-hover-elementor' ),
				'label_off'    => esc_html__( 'No', 'image-hover-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Heading', 'image-hover-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Your Heading', 'image-hover-elementor' ),
				'placeholder' => esc_html__( 'Enter heading', 'image-hover-elementor' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'image-hover-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'     => esc_html__( 'Rich Text', 'image-hover-elementor' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => esc_html__( 'Add your description here. You can use bold, links and more.', 'image-hover-elementor' ),
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'image-hover-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'image-hover-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .ihe-inner' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'      => esc_html__( 'Width', 'image-hover-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 2000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ihe-images' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label'      => esc_html__( 'Max Width', 'image-hover-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 2000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ihe-images' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'      => esc_html__( 'Height', 'image-hover-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ihe-images' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ihe-img--normal' => 'height: 100%; object-fit: cover;',
				],
			]
		);

		$this->add_control(
			'object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'image-hover-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'fill'    => esc_html__( 'Fill', 'image-hover-elementor' ),
					'cover'   => esc_html__( 'Cover', 'image-hover-elementor' ),
					'contain' => esc_html__( 'Contain', 'image-hover-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .ihe-img--hover' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'   => esc_html__( 'Hover Effect', 'image-hover-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => esc_html__( 'Fade', 'image-hover-elementor' ),
					'zoom' => esc_html__( 'Zoom', 'image-hover-elementor' ),
				],
			]
		);

		$this->add_control(
			'hover_transition',
			[
				'label'      => esc_html__( 'Transition Duration (ms)', 'image-hover-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 400,
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 3000,
						'step' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ihe-img, {{WRAPPER}} .ihe-overlay' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .ihe-images',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'image-hover-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ihe-images, {{WRAPPER}} .ihe-img, {{WRAPPER}} .ihe-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .ihe-images',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ihe-img--normal',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'label'    => esc_html__( 'CSS Filters (Hover)', 'image-hover-elementor' ),
				'selector' => '{{WRAPPER}}:hover .ihe-img--hover, {{WRAPPER}}.ihe-is-hover .ihe-img--hover',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'image-hover-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Background Color', 'image-hover-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.55)',
				'selectors' => [
					'{{WRAPPER}} .ihe-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_padding',
			[
				'label'      => esc_html__( 'Padding', 'image-hover-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ihe-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_content_align',
			[
				'label'     => esc_html__( 'Content Alignment', 'image-hover-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'image-hover-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .ihe-overlay-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_vertical_align',
			[
				'label'     => esc_html__( 'Vertical Position', 'image-hover-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'image-hover-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Middle', 'image-hover-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'image-hover-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .ihe-overlay' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			[
				'label'     => esc_html__( 'Heading', 'image-hover-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'image-hover-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ihe-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ihe-heading',
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'image-hover-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ihe-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Rich Text', 'image-hover-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'image-hover-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ihe-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ihe-text a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .ihe-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => esc_html__( 'Caption', 'image-hover-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption!' => '',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Color', 'image-hover-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ihe-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .ihe-caption',
			]
		);

		$this->end_controls_section();
	}

	protected function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}

		if ( empty( $settings['image']['url'] ) ) {
			return false;
		}

		return [
			'url' => $settings['image']['url'],
		];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$wrapper_class = 'ihe-widget';
		if ( 'zoom' === $settings['hover_effect'] ) {
			$wrapper_class .= ' ihe-widget--effect-zoom';
		}
		if ( ! empty( $settings['image_hover']['url'] ) ) {
			$wrapper_class .= ' ihe-has-hover-image';
		}

		$this->add_render_attribute( 'wrapper', 'class', $wrapper_class );

		$normal_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'image' );
		$normal_html = str_replace( 'class="', 'class="ihe-img ihe-img--normal ', $normal_html );

		$hover_html = '';
		if ( ! empty( $settings['image_hover']['url'] ) ) {
			$hover_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_hover', 'image_hover' );
			$hover_html = str_replace( 'class="', 'class="ihe-img ihe-img--hover ', $hover_html );
		}

		$link = $this->get_link_url( $settings );
		$has_link = ! empty( $link );

		if ( $has_link ) {
			$this->add_link_attributes( 'link', $link );

			if ( 'file' === $settings['link_to'] && 'no' !== $settings['open_lightbox'] ) {
				$this->add_lightbox_data_attributes( 'link', $settings['image']['id'], 'yes' === $settings['open_lightbox'] );
			}

			$this->add_render_attribute( 'link', 'class', 'ihe-link' );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="ihe-inner">
				<?php if ( $has_link ) : ?>
					<a <?php $this->print_render_attribute_string( 'link' ); ?>>
				<?php endif; ?>

				<div class="ihe-images">
					<?php echo $normal_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo $hover_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

					<?php if ( 'yes' === $settings['show_overlay'] ) : ?>
						<div class="ihe-overlay">
							<div class="ihe-overlay-content">
								<?php if ( ! empty( $settings['heading'] ) ) : ?>
									<?php
									$tag = Utils::validate_html_tag( $settings['heading_tag'] );
									printf(
										'<%1$s class="ihe-heading">%2$s</%1$s>',
										esc_html( $tag ),
										wp_kses_post( $settings['heading'] )
									);
									?>
								<?php endif; ?>

								<?php if ( ! empty( $settings['description'] ) ) : ?>
									<div class="ihe-text">
										<?php echo wp_kses_post( $settings['description'] ); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $has_link ) : ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $settings['caption'] ) ) : ?>
				<figcaption class="ihe-caption"><?php echo esc_html( $settings['caption'] ); ?></figcaption>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
		if ( ! settings.image.url ) {
			return;
		}
		var effectClass = 'zoom' === settings.hover_effect ? ' ihe-widget--effect-zoom' : '';
		var imageUrl = elementor.imagesManager.getImageUrl( settings.image, settings.image_size, settings.image_custom_dimension );
		var hoverUrl = settings.image_hover && settings.image_hover.url
			? elementor.imagesManager.getImageUrl( settings.image_hover, settings.image_hover_size, settings.image_hover_custom_dimension )
			: '';
		var linkUrl = '';
		if ( 'custom' === settings.link_to && settings.link && settings.link.url ) {
			linkUrl = settings.link.url;
		} else if ( 'file' === settings.link_to ) {
			linkUrl = settings.image.url;
		}
		#>
		<div class="ihe-widget{{{ effectClass }}}">
			<div class="ihe-inner">
				<# if ( linkUrl ) { #>
					<a href="{{ linkUrl }}" class="ihe-link">
				<# } #>
				<div class="ihe-images">
					<img src="{{ imageUrl }}" class="ihe-img ihe-img--normal" alt="" />
					<# if ( hoverUrl ) { #>
						<img src="{{ hoverUrl }}" class="ihe-img ihe-img--hover" alt="" />
					<# } #>
					<# if ( 'yes' === settings.show_overlay ) { #>
						<div class="ihe-overlay">
							<div class="ihe-overlay-content">
								<# if ( settings.heading ) { #>
									<{{ settings.heading_tag }} class="ihe-heading">{{{ settings.heading }}}</{{ settings.heading_tag }}>
								<# } #>
								<# if ( settings.description ) { #>
									<div class="ihe-text">{{{ settings.description }}}</div>
								<# } #>
							</div>
						</div>
					<# } #>
				</div>
				<# if ( linkUrl ) { #></a><# } #>
			</div>
			<# if ( settings.caption ) { #>
				<figcaption class="ihe-caption">{{ settings.caption }}</figcaption>
			<# } #>
		</div>
		<?php
	}
}
