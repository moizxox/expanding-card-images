<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Expanding_Cards_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'expanding_cards';
    }

    public function get_title() {
        return __( 'Expanding Cards', 'expanding-cards-plugin' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'expanding-cards-plugin' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => __( 'Image Gallery', 'expanding-cards-plugin' ),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'label_block' => true,
                'default' => [
                    [
                        'id' => 0,
                        'url' => 'https://cdn.pixabay.com/photo/2024/05/26/10/15/bird-8788491_1280.jpg',
                    ],
                ],
                'placeholder' => __( 'Select images', 'expanding-cards-plugin' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'expanding-cards-plugin' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'panel_background_color',
            [
                'label' => __( 'Panel Background Color', 'expanding-cards-plugin' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exp-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $gallery = $settings['gallery'];

        ?>
        <style>
            .expand-cont {
                display: flex;
                width: 100%;
            }

            .exp-panel {
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 500px;
                border-radius: 20px;
                cursor: pointer;
                flex: 0.5;
                margin: 10px;
                position: relative;
                transition: flex .3s ease-in;
                background-color: <?php echo esc_attr( $settings['panel_background_color'] ); ?>;
            }

            .exp-panel.active {
                flex: 5;
            }

            @media (max-width: 786px) {
                .exp-panel:nth-of-type(4), .exp-panel:nth-of-type(5), ..exp-panel:nth-of-type(6) {
                    display: none;
                }
                .exp-panel{
                    height: 300px;
                    border-radius: 8px;
                }
            }
        </style>
        <div class="expand-cont">
            <?php
            $is_first = true; // Flag to check if it is the first panel
            foreach ( $gallery as $index => $image ) {
                $image_url = $image['url'];
                $active_class = $is_first ? 'active' : '';
                ?>
                <div class="exp-panel <?php echo esc_attr( $active_class ); ?>" style="background-image: url('<?php echo esc_url( $image_url ); ?>')">
                </div>
                <?php
                $is_first = false; // Set flag to false after first panel
            }
            ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const panels = document.querySelectorAll('.exp-panel');

                panels.forEach(panel => {
                    panel.addEventListener('click', () => {
                        removeActiveClasses();
                        panel.classList.add('active');
                    });
                });

                function removeActiveClasses() {
                    panels.forEach(panel => {
                        panel.classList.remove('active');
                    });
                }
            });
        </script>
        <?php
    }
}
