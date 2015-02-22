<?php
/**
 * Nivo Slider specific markup, javascript, css and settings.
 */
class MetaNivoSlider extends MetaSlider {

    protected $js_function = 'nivoSlider';
    protected $js_path = 'sliders/nivoslider/jquery.nivo.slider.pack.js';
    protected $css_path = 'sliders/nivoslider/nivo-slider.css';

    /**
     * Constructor
     */
    public function __construct($id) {
        parent::__construct($id);

        add_filter('metaslider_nivo_slider_parameters', array($this, 'set_autoplay_parameter'), 10, 2);
    }

    /**
     * Other slides use "AutoPlay = true" (true autoplays the slideshow)
     * Nivo slider uses "ManualAvance = false" (ie, false autoplays the slideshow)
     * Take care of the manualAdvance parameter here.
     */
    public function set_autoplay_parameter($options, $slider_id) {
        if (isset($options["autoPlay"])) {
            if ($options["autoPlay"] == 'true') {
                $options["manualAdvance"] = 'false';
            } else {
                $options["manualAdvance"] = 'true';
            }
        }
        
        // we don't want this filter hanging around if there's more than one slideshow on the page
        remove_filter('metaslider_nivo_slider_parameters', array($this, 'set_autoplay_parameter'));

        return $options;
    }

    /**
     * Detect whether thie slide supports the requested setting,
     * and if so, the name to use for the setting in the Javascript parameters
     * 
     * @return false (parameter not supported) or parameter name (parameter supported)
     */
    protected function get_param($param) {
        $params = array(
            'effect' => 'effect',
            'slices' => 'slices',
            'prevText' => 'prevText',
            'nextText' => 'nextText',
            'delay' => 'pauseTime',
            'animationSpeed' => 'animSpeed',
            'hoverPause' => 'pauseOnHover',
            'spw' => 'boxCols',
            'sph' => 'boxRows',
            'navigation' => 'controlNav',
            'links' =>'directionNav',
            'autoPlay' => 'autoPlay'
        );

        if (isset($params[$param])) {
            return $params[$param];
        }

        return false;
    }

    /**
     * Include slider assets
     */
    public function enqueue_scripts() {
        parent::enqueue_scripts();

        // include the theme
        if ($this->get_setting('printCss') == 'true') {
            $theme = $this->get_setting('theme');
            wp_enqueue_style('ml-slider_nivo_slider_theme_' . $theme, METASLIDER_ASSETS_URL  . "sliders/nivoslider/themes/{$theme}/{$theme}.css");
        }
    }

    /**
     * Build the HTML for a slider.
     *
     * @return string slider markup.
     */
    protected function get_html() {
        $retVal  = "<div class='slider-wrapper theme-{$this->get_setting('theme')}'>";
        $retVal .= "<div class='ribbon'></div>";
        $retVal .= "<div id='" . $this->get_identifier() . "' class='nivoSlider'>";
        
        foreach ($this->slides as $slide) {
            $retVal .= $slide;
        }
        
        $retVal .= "</div></div>";
        
        return $retVal;
    }
}
?>