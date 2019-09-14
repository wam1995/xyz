<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: background
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'CSF_Field_background' ) ) {
  class CSF_Field_background extends CSF_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args                             = wp_parse_args( $this->field, array(
        'background_color'              => true,
        'background_image'              => true,
        'background_position'           => true,
        'background_repeat'             => true,
        'background_attachment'         => true,
        'background_size'               => true,
        'background_origin'             => false,
        'background_clip'               => false,
        'background_blend-mode'         => false,
        'background_gradient'           => false,
        'background_gradient_color'     => true,
        'background_gradient_direction' => true,
        'background_image_preview'      => true,
        'background_image_library'      => 'image',
        'background_image_placeholder'  => esc_html__( 'No background selected', 'csf' ),
      ) );

      $default_value                    = array(
        'background-color'              => '',
        'background-image'              => '',
        'background-position'           => '',
        'background-repeat'             => '',
        'background-attachment'         => '',
        'background-size'               => '',
        'background-origin'             => '',
        'background-clip'               => '',
        'background-blend-mode'         => '',
        'background-gradient-color'     => '',
        'background-gradient-direction' => '',
      );

      $default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

      $this->value = wp_parse_args( $this->value, $default_value );

      echo $this->field_before();

      //
      // Background Color
      if( ! empty( $args['background_color'] ) ) {

        echo '<div class="csf--block csf--color">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="csf--title">'. esc_html__( 'From', 'csf' ) .'</div>' : '';

        CSF::field( array(
          'id'      => 'background-color',
          'type'    => 'color',
          'default' => $default_value['background-color'],
        ), $this->value['background-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Color
      if( ! empty( $args['background_gradient_color'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="csf--block csf--color">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="csf--title">'. esc_html__( 'To', 'csf' ) .'</div>' : '';

        CSF::field( array(
          'id'      => 'background-gradient-color',
          'type'    => 'color',
          'default' => $default_value['background-gradient-color'],
        ), $this->value['background-gradient-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Direction
      if( ! empty( $args['background_gradient_direction'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="csf--block csf--gradient">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="csf--title">'. esc_html__( '渐变方向', 'csf' ) .'</div>' : '';

        CSF::field( array(
          'id'          => 'background-gradient-direction',
          'type'        => 'select',
          'options'     => array(
            ''          => esc_html__( '渐变方向', 'csf' ),
            'to bottom' => esc_html__( '&#8659;', 'csf' ),
            'to right'  => esc_html__( '&#8658;', 'csf' ),
            '135deg'    => esc_html__( '&#8664;', 'csf' ),
            '-135deg'   => esc_html__( '&#8665;', 'csf' ),
          ),
        ), $this->value['background-gradient-direction'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      echo '<div class="clear"></div>';

      //
      // Background Image
      if( ! empty( $args['background_image'] ) ) {

        echo '<div class="csf--block csf--media"><div class="csf--title">背景图片</div>';

        CSF::field( array(
          'id'          => 'background-image',
          'type'        => 'media',
          'library'     => $args['background_image_library'],
          'preview'     => $args['background_image_preview'],
          'placeholder' => $args['background_image_placeholder']
        ), $this->value['background-image'], $this->field_name(), 'field/background' );

        echo '</div>';

        echo '<div class="clear"></div>';

      }

      //
      // Background Position
      if( ! empty( $args['background_position'] ) ) {
        echo '<div class="csf--block csf--select"><div class="csf--title">背景对齐位置</div>';

        CSF::field( array(
          'id'              => 'background-position',
          'type'            => 'select',
          'options'         => array(
            ''              => esc_html__( '背景对齐位置', 'csf' ),
            'left top'      => esc_html__( '左上', 'csf' ),
            'left center'   => esc_html__( '左中', 'csf' ),
            'left bottom'   => esc_html__( '左下', 'csf' ),
            'center top'    => esc_html__( '中上', 'csf' ),
            'center center' => esc_html__( '中心', 'csf' ),
            'center bottom' => esc_html__( '中下', 'csf' ),
            'right top'     => esc_html__( '右上', 'csf' ),
            'right center'  => esc_html__( '右中', 'csf' ),
            'right bottom'  => esc_html__( '右下', 'csf' ),
          ),
        ), $this->value['background-position'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Repeat
      if( ! empty( $args['background_repeat'] ) ) {
        echo '<div class="csf--block csf--select"><div class="csf--title">背景是否重复</div>';

        CSF::field( array(
          'id'          => 'background-repeat',
          'type'        => 'select',
          'options'     => array(
            'repeat'    => esc_html__( '重复', 'csf' ),
            'no-repeat' => esc_html__( '不重复', 'csf' ),
            'repeat-x'  => esc_html__( '横向重复', 'csf' ),
            'repeat-y'  => esc_html__( '纵向重复', 'csf' ),
          ),
        ), $this->value['background-repeat'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Attachment
      if( ! empty( $args['background_attachment'] ) ) {
        echo '<div class="csf--block csf--select"><div class="csf--title">背景是否固定</div>';

        CSF::field( array(
          'id'       => 'background-attachment',
          'type'     => 'select',
          'options'  => array(
            'scroll' => esc_html__( '滚动', 'csf' ),
            'fixed'  => esc_html__( '固定', 'csf' ),
          ),
        ), $this->value['background-attachment'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Size
      if( ! empty( $args['background_size'] ) ) {
        echo '<div class="csf--block csf--select"><div class="csf--title">背景尺寸</div>';

        CSF::field( array(
          'id'        => 'background-size',
          'type'      => 'select',
          'options'   => array(
            'cover'   => esc_html__( '缩放', 'csf' ),
            'contain' => esc_html__( '拉伸', 'csf' ),
          ),
        ), $this->value['background-size'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

//      //
//      // Background Origin
//      if( ! empty( $args['background_origin'] ) ) {
//        echo '<div class="csf--block csf--select">';
//
//        CSF::field( array(
//          'id'            => 'background-origin',
//          'type'          => 'select',
//          'options'       => array(
//            ''            => esc_html__( '背景定位参照对象', 'csf' ),
//            'padding-box' => esc_html__( '内边距框', 'csf' ),
//            'border-box'  => esc_html__( '边框盒', 'csf' ),
//            'content-box' => esc_html__( '内容框', 'csf' ),
//          ),
//        ), $this->value['background-origin'], $this->field_name(), 'field/background' );
//
//        echo '</div>';
//
//      }
//
//      // Background Clip
//      if( ! empty( $args['background_clip'] ) ) {
//        echo '<div class="csf--block csf--select">';
//
//        CSF::field( array(
//          'id'            => '背景裁切截至',
//          'type'          => 'select',
//          'options'       => array(
//            ''            => esc_html__( 'Background Clip', 'csf' ),
//            'border-box'  => esc_html__( 'Border Box', 'csf' ),
//            'padding-box' => esc_html__( 'Padding Box', 'csf' ),
//            'content-box' => esc_html__( 'Content Box', 'csf' ),
//          ),
//        ), $this->value['background-clip'], $this->field_name(), 'field/background' );
//
//        echo '</div>';
//
//      }

      //
      // Background Blend Mode
      if( ! empty( $args['background_blend_mode'] ) ) {
        echo '<div class="csf--block csf--select">';

        CSF::field( array(
          'id'            => 'background-blend-mode',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( '背景混合模式', 'csf' ),
            'normal'      => esc_html__( '正常', 'csf' ),
            'multiply'    => esc_html__( '正片叠底', 'csf' ),
            'screen'      => esc_html__( '滤色', 'csf' ),
            'overlay'     => esc_html__( '叠加', 'csf' ),
            'darken'      => esc_html__( '变暗', 'csf' ),
            'lighten'     => esc_html__( '变亮', 'csf' ),
            'color-dodge' => esc_html__( '颜色减淡', 'csf' ),
            'saturation'  => esc_html__( '饱和度', 'csf' ),
            'color'       => esc_html__( '颜色', 'csf' ),
            'luminosity'  => esc_html__( '亮度', 'csf' ),
          ),
        ), $this->value['background-blend-mode'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      echo '<div class="clear"></div>';

      echo $this->field_after();

    }

    public function output() {

      $output    = '';
      $bg_image  = array();
      $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
      $element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

      // Background image and gradient
      $background_color        = ( ! empty( $this->value['background-color']              ) ) ? $this->value['background-color']              : '';
      $background_gd_color     = ( ! empty( $this->value['background-gradient-color']     ) ) ? $this->value['background-gradient-color']     : '';
      $background_gd_direction = ( ! empty( $this->value['background-gradient-direction'] ) ) ? $this->value['background-gradient-direction'] : '';
      $background_image        = ( ! empty( $this->value['background-image']['url']       ) ) ? $this->value['background-image']['url']       : '';


      if( $background_color && $background_gd_color ) {
        $gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
        $bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
      }

      if( $background_image ) {
        $bg_image[] = 'url('. $background_image .')';
      }

      if( ! empty( $bg_image ) ) {
        $output .= 'background-image:'. implode( ',', $bg_image ) . $important .';';
      }

      // Common background properties
      $properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

      foreach( $properties as $property ) {
        $property = 'background-'. $property;
        if( ! empty( $this->value[$property] ) ) {
          $output .= $property .':'. $this->value[$property] . $important .';';
        }
      }

      if( $output ) {
        $output = $element .'{'. $output .'}';
      }

      $this->parent->output_css .= $output;

      return $output;

    }

  }
}
