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
class Xews_Lite_Module4 extends Widget_Base {

    /**
     * Retrieve  widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'module4';
    }

    /**
     * Retrieve  widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Module 4', 'cww-companion');
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

        $repeater = new \Elementor\Repeater();

         /**
         * Section Title
         */
        $this->start_controls_section(
            'section_title_control', [
                'label' => esc_html__('Section Title', 'cww-companion'),
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'             => esc_html__( 'Section Title', 'cww-companion' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__( 'Popular News', 'cww-companion' ),
            ]
        );

        $this->add_control(
            'section_title_position',
            [
                'label'             => esc_html__( 'Position', 'cww-companion' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'pos-2',
                'options'           => [
                    'pos-1' => esc_html__('Left','cww-companion'),
                    'pos-2' => esc_html__('Center','cww-companion'),
                    'pos-3' => esc_html__('Right','cww-companion'),
                ]
               
            ]
        );

        $this->end_controls_section();


        /**
         * Section content
         */
        $this->start_controls_section(
            'header', [
                'label' => esc_html__('Module Options', 'cww-companion'),
            ]
        );

        $this->add_control(
            'posts_layout',
            [
                'label'             => esc_html__( 'Image Style', 'cww-companion' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'layout-1',
                'options'           => [
                    'layout-1' => esc_html__('Round','cww-companion'),
                    'layout-2' => esc_html__('Square','cww-companion'),
                ]
               
            ]
        );

        $this->add_control(
            'post_counter',
            [
                'label'             => esc_html__( 'Display Count', 'cww-companion' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => true,
                'label_on'          => esc_html__( 'Yes', 'cww-companion' ),
                'label_off'         => esc_html__( 'No', 'cww-companion' ),
                'return_value'      => 'yes',
            ]
        );

        $this->end_controls_section();


        /**
         * Section content
         */
        $this->start_controls_section(
                'content_section',
                [
                    'label' => __('Content', 'cww-companion'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $repeater->add_control(
                'add_category',
                [
                    'label' => __('Select Category', 'cww-companion'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => false,
                    'options' => $this->get_categories_options(),
                ]
            );

             // Image Upload Field
            $repeater->add_control(
                'category_image',
                [
                    'label' => __( 'Choose Image', 'cww-companion' ),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
    
            $this->add_control(
                'catagories_list',
                [
                    'label'     => __( 'Categories List', 'cww-companion' ),
                    'type'      => Controls_Manager::REPEATER,
                    'fields'    => $repeater->get_controls(),
                    'default'   => [
                        [
                            'add_category' => __( 'Category 1', 'cww-companion' ),
                            
                        ],
                        [
                            'add_category' => __( 'Category 2', 'cww-companion' ),
                        ],
                    ],
                    'title_field' => '{{{ add_category }}}',
                ]
            );
  
        $this->end_controls_section();


        /**
         * Style Tab: Section Title
         */
        $this->start_controls_section(
            'section_title_style', [
                'label' => esc_html__('Section Title', 'cww-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'cww-companion'),
                'selector' => '{{WRAPPER}} .title-wraps h3',
            ]
        );


        $this->add_control(
            'title_text_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-wraps h3' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    

        /**
         * Style Tab: Category
         */
        $this->start_controls_section(
            'category_title_style', [
                'label' => esc_html__('Category Title', 'cww-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'cat_title_typography',
                'label' => esc_html__('Typography', 'cww-companion'),
                'selector' => '{{WRAPPER}} .code-wrapp.module4 ul.category-widget li .content-wrapp a',
            ]
        );


        $this->add_control(
            'cat_title_text_color', [
                'label'     => __('Text Color', 'cww-companion'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .code-wrapp.module4 ul.category-widget li .content-wrapp a' => 'color: {{VALUE}}',
                ],
            ]
        );
   
        $this->end_controls_section();
    }


    private function get_categories_options() {
        $categories = get_categories();
        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }


    // Add a helper method to get the category name dynamically
public function getCategoryName( $category_id ) {
    $categories = $this->get_categories_options();
    return isset( $categories[ $category_id ] ) ? $categories[ $category_id ] : __( 'Unknown Category', 'cww-companion' );
}

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * 
     */
    public function render() {

        $settings                   = $this->get_settings();
        $posts_layout               = $settings['posts_layout'];
        $section_title              = $settings['section_title'];
        $section_title_position     = $settings['section_title_position'];
        $catagories_list            = $settings['catagories_list'];
        $post_counter               = $settings['post_counter'];

        $this->add_render_attribute('code-wrapp', 'class', 'code-wrapp module4 cww-flex '); 
        
        ?>

        <div class="newzz-elements-wrapp cwm2">
            <?php 
            if( $section_title ){ ?>
                <div class="title-wraps <?php echo esc_attr($section_title_position);?>">
                    <h3> <span><?php echo esc_html($section_title); ?></span> </h3>
                </div>
            <?php } ?>
            
            <div <?php echo $this->get_render_attribute_string('code-wrapp'); ?> data-id="module-four">
                <ul class="category-widget">
                <?php
                
                foreach(  $catagories_list as $key => $catagory_list ):
                    $category_image_url = ! empty( $catagory_list['category_image']['url'] ) ? $catagory_list['category_image']['url'] : '';
                    $category_id = $catagory_list['add_category'];
                    $category = get_term($category_id, 'category');

                    ?>
                    <li>
                    <?php
                    if ($category_image_url) { ?>
                        <a href="<?php echo esc_url(get_category_link($category->term_id)) ?>" class="post-thumbnail">
                        <img src="<?php echo esc_url($category_image_url)?>" class="<?php echo esc_attr($posts_layout);?>" alt="<?php echo esc_attr($category->name) ?>"/>
                        </a>
                    <?php } ?>
                    <div class="content-wrapp">
                        <?php
                    if( $post_counter == true ){ ?>
                        <span class="counter"><?php echo esc_html($category->count);?></span>
                        <?php } ?>    
                        <a href="<?php echo esc_url(get_category_link($category->term_id)) ?>"> <?php echo esc_html($category->name) ?></a>
                    </div>
                    </li>
                    <?php 
                    endforeach;
                    ?>
                </ul>   
            </div>
        </div>
        <?php

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
    Plugin::instance()->widgets_manager->register_widget_type( new Xews_Lite_Module4() );