<?php
/**
 * Enix Weather Widget
 *
 * @package EnixAddons
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Enix_Weather_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'enix_weather';
    }

    public function get_title()
    {
        return esc_html__('Enix Weather', 'enix-addons');
    }

    public function get_icon()
    {
        return 'eicon-cloud-check';
    }

    public function get_categories()
    {
        return ['enix-elements'];
    }

    public function get_keywords()
    {
        return ['weather', 'temperature', 'forecast', 'enix', 'openweather'];
    }

    protected function register_controls()
    {
        // ── Content ──────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Weather Settings', 'enix-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'api_key',
            [
                'label'       => esc_html__('OpenWeatherMap API Key', 'enix-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'e3eb7a02369a6e733cd81a4e14c540cf',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'city_name',
            [
                'label'       => esc_html__('City Name', 'enix-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Cancun',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'units',
            [
                'label'   => esc_html__('Units', 'enix-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'metric',
                'options' => [
                    'metric'   => esc_html__('Celsius (°C)', 'enix-addons'),
                    'imperial' => esc_html__('Fahrenheit (°F)', 'enix-addons'),
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'   => esc_html__('Alignment', 'enix-addons'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'enix-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'enix-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'enix-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .enix-weather' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ── Style ────────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'enix-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'enix-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7A7A7A',
                'selectors' => [
                    '{{WRAPPER}} .enix-weather' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__('Separator Color', 'enix-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#CCCCCC',
                'selectors' => [
                    '{{WRAPPER}} .enix-weather-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label'      => esc_html__('Icon Size', 'enix-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 8, 'max' => 80]],
                'default'    => ['unit' => 'px', 'size' => 16],
                'selectors'  => [
                    '{{WRAPPER}} .enix-weather-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'gap',
            [
                'label'      => esc_html__('Gap', 'enix-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 8],
                'selectors'  => [
                    '{{WRAPPER}} .enix-weather' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .enix-weather',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $widget_id = 'enix-weather-' . $this->get_id();
        $unit_symbol = $settings['units'] === 'imperial' ? '°F' : '°C';

        $api_key = esc_js($settings['api_key']);
        $city    = esc_js($settings['city_name']);
        $units   = esc_js($settings['units']);
        ?>
        <div class="enix-weather" id="<?php echo esc_attr($widget_id); ?>" style="display:flex;align-items:center;gap:8px;">
            <span class="enix-weather-icon" id="<?php echo esc_attr($widget_id); ?>-icon">
                <i class="fas fa-cloud"></i>
            </span>
            <span class="enix-weather-temp" id="<?php echo esc_attr($widget_id); ?>-temp">--<?php echo esc_html($unit_symbol); ?></span>
            <span class="enix-weather-separator">|</span>
            <span class="enix-weather-city"><?php echo esc_html($settings['city_name']); ?></span>
        </div>
        <script>
        (function(){
            var apiKey = "<?php echo $api_key; ?>";
            var city   = "<?php echo $city; ?>";
            var units  = "<?php echo $units; ?>";
            var unitSymbol = units === "imperial" ? "°F" : "°C";
            var wid = "<?php echo esc_js($widget_id); ?>";

            function setIcon(main){
                var html = '<i class="fas fa-cloud"></i>';
                switch(main){
                    case 'Clear':        html = '<i class="fas fa-sun"></i>'; break;
                    case 'Clouds':       html = '<i class="fas fa-cloud-sun"></i>'; break;
                    case 'Rain':         html = '<i class="fas fa-cloud-showers-heavy"></i>'; break;
                    case 'Drizzle':      html = '<i class="fas fa-cloud-rain"></i>'; break;
                    case 'Thunderstorm': html = '<i class="fas fa-bolt"></i>'; break;
                    case 'Snow':         html = '<i class="fas fa-snowflake"></i>'; break;
                    case 'Mist':
                    case 'Smoke':
                    case 'Haze':
                    case 'Fog':
                    case 'Dust':
                    case 'Sand':
                    case 'Ash':          html = '<i class="fas fa-smog"></i>'; break;
                }
                var el = document.getElementById(wid + '-icon');
                if (el) el.innerHTML = html;
            }

            function loadWeather(){
                try {
                    var url = 'https://api.openweathermap.org/data/2.5/weather?q=' + encodeURIComponent(city) + '&units=' + units + '&appid=' + apiKey;
                    fetch(url).then(function(r){ return r.json(); }).then(function(data){
                        if (data && data.main && data.weather && data.weather[0]) {
                            var temp = Math.round(data.main.temp);
                            var t = document.getElementById(wid + '-temp');
                            if (t) t.textContent = temp + unitSymbol;
                            setIcon(data.weather[0].main);
                        } else {
                            var ic = document.getElementById(wid + '-icon');
                            if (ic) ic.innerHTML = '<i class="fas fa-triangle-exclamation"></i>';
                        }
                    }).catch(function(){
                        var ic = document.getElementById(wid + '-icon');
                        if (ic) ic.innerHTML = '<i class="fas fa-triangle-exclamation"></i>';
                    });
                } catch(e){}
            }
            loadWeather();
        })();
        </script>
        <?php
    }
}
