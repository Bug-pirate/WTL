<?php

namespace Elementor;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use NewzzElements\Group_Control_Query;
use Elementor\Controls_Stack;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 *  Widget
 */
class Xews_Lite_Module3 extends Widget_Base {

    /**
     * Retrieve  widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'module3';
    }

    /**
     * Retrieve  widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Module 3', 'cww-companion');
    }

    public function get_style_depends() {
        return [
            'biz-elements-blogs'
        ];
    }

    /**
     * Retrieve the list of categories the  widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['xews-lite-elements'];
    }



    /**
     * Retrieve  widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-columns';
    }

    /**
     * Register  widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @access protected
     */
    protected function register_controls() {
        

        $this->start_controls_section(
            'header', [
                'label' => esc_html__('Module Options', 'cww-companion'),
            ]
        );

       
         $this->add_control(
            'post_meta',
            [
                'label'             => esc_html__( 'Post Meta', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
            ]
        );

      
        
        $this->add_control(
            'post_author',
            [
                'label'             => esc_html__( 'Post Author', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'post_category',
            [
                'label'             => esc_html__( 'Post Category', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'post_date',
            [
                'label'             => esc_html__( 'Post Date', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
       
         $this->add_control(
            'post_excerpt',
            [
                'label'             => esc_html__( 'Post Excerpt', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'no',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
                
            ]
        );

        
        
        $this->add_control(
            'excerpt_length',
            [
                'label'             => esc_html__( 'Excerpt Length', 'cww-companion' ),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 125,
                'min'               => 0,
                'max'               => 950,
                'step'              => 1,
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'read_more',
            [
                'label'             => esc_html__( 'Read More Button', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'no',
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
                
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'image_size',
                'label'             => esc_html__( 'Image Size', 'cww-companion' ),
                'default'           => 'xews-rectangle-thumb',
            ]
        );

        $this->end_controls_section();

        

          /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_post_query',
            [
                'label'             => esc_html__( 'Query', 'cww-companion' ),
            ]
        );

        $this->add_group_control(
                Group_Control_Query::get_type(), [
            'name' => 'posts',
            'label' => esc_html__( 'Posts', 'cww-companion' ),
                ]
        );

        $this->end_controls_section();

         /**
         * Style Tab: Post Meta
         */
        $this->start_controls_section(
                'meta_style', [
                    'label' => esc_html__('Post Meta', 'cww-companion'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'meta_typography',
                'label' => esc_html__('Typography', 'cww-companion'),
                'selector' => 
                    '{{WRAPPER}} .entry-meta span a, 
                    {{WRAPPER}} .entry-meta span',
            ]
        );


        $this->add_control(
            'meta_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-meta span a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .entry-meta span' => 'color: {{VALUE}}',
                ],
            ]
        );
       

        $this->end_controls_section();


        /**
         * Style Tab: Post Title
         */
        $this->start_controls_section(
                'section_header_style', [
                    'label'     => esc_html__('Post Title', 'cww-companion'),
                    'tab'       => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'header1_typography',
                'label'     => esc_html__('Center Post Typography', 'cww-companion'),
                'selector'  => '{{WRAPPER}} .blog-outer-wrapp.section-2 .post-content h2.entry-title a',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'header2_typography',
                'label'     => esc_html__('Leftside Post Typography', 'cww-companion'),
                'selector'  => '{{WRAPPER}} .blog-outer-wrapp.section-1 .post-content h2.entry-title a',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'header3_typography',
                'label'     => esc_html__('rightside Post Typography', 'cww-companion'),
                'selector'  => '{{WRAPPER}} .blog-outer-wrapp.section-3 .post-content h2.entry-title a',
            ]
        );


        $this->add_control(
            'header_text_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 h2.entry-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'header_text_color_hover', [
                'label'     => __('Text Color:Hover', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 h2.entry-title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();



         /**
         * Style Tab: Post Contents
         */
        $this->start_controls_section(
                'content_style', [
                    'label' => esc_html__('Post Contents', 'cww-companion'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'cww-companion'),
                'selector' => '{{WRAPPER}} .code-wrapp.module3 .post-content p',
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label'             => esc_html__( 'Text Align', 'cww-companion' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'left',
                'options'           => [
                    'left'      => esc_html__('Left','cww-companion'),
                    'center'    => esc_html__('Center','cww-companion'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 .post-content' => 'text-align: {{VALUE}}',
                ],
               
            ]
        );


        $this->add_control(
            'content_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 .post-content p' => 'color: {{VALUE}}',
                ],
            ]
        );
       

        $this->end_controls_section();


         /**
         * Style Tab: Read More Button
         */
        $this->start_controls_section(
                'button_style', [
                    'label' => esc_html__('Read More Button', 'cww-companion'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'btn_typography',
                'label' => esc_html__('Typography', 'cww-companion'),
                'selector' => '{{WRAPPER}} .code-wrapp.module3 .read-more-link a',
            ]
        );


        $this->add_control(
            'btn_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 .read-more-link a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_color_hovr', [
                'label'     => __('Text Color:Hover', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module3 .read-more-link a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
       

        $this->end_controls_section();

        
      

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * 
     */
    public function render() {

        $settings               = $this->get_settings();
       
        $this->add_render_attribute('code-wrapp', 'class', 'code-wrapp module3 cww-flex ');

        
        
        ?>

        <div class="newzz-elements-wrapp cwm1">
            <div <?php echo $this->get_render_attribute_string('code-wrapp'); ?> data-id="module-one">
                <div class="newzz-inner-content catall cww-flex">
                    <?php $this->get_current_loop_contents();  ?>
                </div>

                <div class="newzz-element-overlay">
                    <div class="loading">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>    

            </div>
        </div>
        <?php

    }



    protected function get_current_loop_contents(){
        $settings           = $this->get_settings();
        $posts_per_page     = 3;
        $posts_offset       = empty($settings['posts_offset']) ? 0 : $settings['posts_offset'];
        
        $counter = 1;
        $args = code_elements_query($settings, $first_id = '',$posts_per_page, $posts_offset);
        $featured_posts = new \WP_Query( $args );
        

         if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();

            if ( has_post_thumbnail() ) {
                $image_id = get_post_thumbnail_id( get_the_ID() );
                
                $thumb_url = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
                
            } else {
               $thumb_url = '#';
            }
        
        if( $counter == 1 ||  $counter == 2 || $counter == 3 ){
        ?>
        <div class="blog-outer-wrapp section-<?php echo esc_attr($counter)?>"  >
            <div class="blog-inner-wrapp">
                <?php if ( has_post_thumbnail() ) { ?>
                <div class="img-wrapp">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <img src="<?php echo esc_url($thumb_url)?>" alt="<?php the_title_attribute(); ?>">
                    </a>
                </div>
                <?php } ?>
                <div class="post-content">
                    
                <?php 
                    if($settings['post_category']){ 
                     do_action('xews_lite_post_cat_or_tag_lists'); 
                    } 
                   ?>
                    <h2 class="entry-title font-medium">
                        <a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a>
                    </h2>
                    <div class="entry-meta">
                        <?php echo code_elements_post_meta($settings); ?>
                    </div>
                    <?php if( $counter == 1 || $counter == 3 ): ?>
                        <p>
                            <?php echo code_elements_custom_excerpt($settings['excerpt_length']); ?>    
                        </p>
                        <?php if( $settings['read_more'] == 'yes' ): ?>
                            <div class="read-more-link">
                                <a href="<?php the_permalink();?>" class="btn read-more"><?php esc_html_e('Read More','xnewzz-elements');?>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        <?php endif;?>
                    <?php endif; 
                    ?>
                </div>
            </div>
        </div>
        <?php
        }
         $counter++;
        endwhile; endif; wp_reset_postdata(); 

     }

        
        
       
       

        /**
         * Render posts widget output in the editor.
         *
         * Written as a Backbone JavaScript template and used to generate the live preview.
         *
         * @access protected
         */
        protected function content_template() {
            
        }

    }
    Plugin::instance()->widgets_manager->register_widget_type( new Xews_Lite_Module3() );