<?php
/**
 * Flex Slider specific markup, javascript, css and settings.
 */
class MetaFlexSlider extends MetaSlider {

    protected $js_function = 'flexslider';
    protected $js_path = 'sliders/flexslider/jquery.flexslider-min.js';
    protected $css_path = 'sliders/flexslider/flexslider.css';

    protected $carousel_item_margin = 5;

    public function __construct($id) {
        parent::__construct($id);
        add_filter('metaslider_flex_slider_parameters', array($this, 'enable_carousel_mode'), 10, 2);
        add_filter('metaslider_flex_slider_parameters', array($this, 'enable_easing'), 10, 2);
        add_filter('metaslider_css', array($this, 'get_carousel_css'), 10, 2);
    }


    /**
     * Adjust the slider parameters so they're comparible with the carousel mode
     */
    public function enable_carousel_mode($options, $slider_id) {
        if (isset($options["carouselMode"])) {
            if ($options["carouselMode"] == "true") {
                $options["itemWidth"] = $this->get_setting('width');
                $options["animation"] = "'slide'";
                $options["direction"] = "'horizontal'";
                $options["itemMargin"] = $this->carousel_item_margin;
            }

            unset($options["carouselMode"]);
        }
        
        // we don't want this filter hanging around if there's more than one slideshow on the page
        remove_filter('metaslider_flex_slider_parameters', array($this, 'enable_carousel_mode'));
        
        return $options;
    }

    /**
     * Adjust the slider parameters so they're comparible with the carousel mode
     */
    public function enable_easing($options, $slider_id) {
        if (isset($options["easing"])) {
            $options['useCSS'] = 'false';
        }
        
        // we don't want this filter hanging around if there's more than one slideshow on the page
        remove_filter('metaslider_flex_slider_parameters', array($this, 'enable_easing'));

        return $options;
    }

    /**
     * Return css to ensure our slides are rendered correctly in the carousel
     */
    public function get_carousel_css($settings, $slider_id) {
        if (isset($settings["carouselMode"]) && $settings['carouselMode'] == 'true') {
            return "#metaslider_{$slider_id}.flexslider li {margin-right: {$this->carousel_item_margin}px;}";
        }
    }

    /**
     * Enable the parameters that are accepted by the slider
     * 
     * @return array enabled parameters
     */
    protected function get_param($param) {
        $params = array(
            'effect' => 'animation',
            'direction' => 'direction',
            'prevText' => 'prevText',
            'nextText' => 'nextText',
            'delay' => 'slideshowSpeed',
            'animationSpeed' => 'animationSpeed',
            'hoverPause' => 'pauseOnHover',
            'reverse' => 'reverse',
            'navigation' => 'controlNav',
            'links' =>'directionNav',
            'carouselMode' => 'carouselMode',
            'easing' => 'easing',
            'autoPlay' => 'slideshow'
        );

        if (isset($params[$param])) {
            return $params[$param];
        }

        return false;
    }

    /**
     * Build the HTML for a slider.
     *
     * @return string slider markup.
     */
    protected function get_html() {
        $return_value = "<div id='" . $this->get_identifier() . "' class='flexslider'><ul class='slides'>";

        foreach ($this->slides as $slide) {
            $return_value .= "<li style='display: none;'>" . $slide . "</li>";
            $first = false;
        }
        
        $return_value .= "</ul></div>";

        return $return_value;
    }
}
?>