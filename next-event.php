<?php
/*
Plugin Name: Next Event
Plugin URI: https://github.com/pprocner/next-event-wp-plugin
Description: Displays information about next meetup event
Author: Piotr Procner
Author URI: https://github.com/pprocner
Version: 1.0
License: GPLv2
 */

define("EVENT_NAME", "eventName");
define("MEETUP_URL", "meetupUrl");
define("DATE_TIME", "dateTime");
define("LOCATION", "location");
define("SPONSOR_LOGO", "sponsorLogo");
define("SPONSOR_URL", "sponsorUrl");

function next_event_load_widget()
{
    wp_register_style('main-style', plugins_url('style.css', __FILE__));
    wp_enqueue_style('main-style');
    register_widget('Next_Event');
}
add_action('widgets_init', 'next_event_load_widget');

class Next_Event extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'next_event_widget',
            __('Next Event', 'wpb_widget_domain'),
            array('description' => __('Displays information about next meetup event', 'wpb_widget_domain'))
        );
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', 'następne spotkanie');
        $dateTimeIcon = plugins_url('res/ic_date_range_white_36dp_1x.png', __FILE__);
        $locationIcon = plugins_url('res/ic_location_on_white_36dp_1x.png', __FILE__);

        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];
        ?>
		<div class="next-event">
			<a class="event-name" href="<?php echo $instance[MEETUP_URL] ?>">
                <h1><?php echo $instance[EVENT_NAME] ?></h1>
            </a>
			<div>
				<img src="<?php echo $dateTimeIcon ?>" alt="date-time-icon">
                <p><?php echo $instance[DATE_TIME] ?></p>
            </div>
            <div>
                <img src="<?php echo $locationIcon ?>" alt="location-icon">
                <p><?php echo $instance[LOCATION] ?></p>
            </div>
            <?php
            if(!empty($instance[SPONSOR_LOGO])) 
            {
                ?>
                <a target="_blank" href="<?php echo $instance[SPONSOR_URL] ?>">
                    <img class="sponsor-logo" src="<?php echo $instance[SPONSOR_LOGO] ?>" />
                </a>
                <?php
            }
            ?>
        </div>
		<?php
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $defaultLocation = "MiMUW, ul. Banacha 2, Warszawa, sala 3180";
        $eventName = isset($instance[EVENT_NAME]) ? $instance[EVENT_NAME] : '';
        $meetupUrl = isset($instance[MEETUP_URL]) ? $instance[MEETUP_URL] : '';
        $dateTime = isset($instance[DATE_TIME]) ? $instance[DATE_TIME] : '';
        $location = isset($instance[LOCATION]) ? $instance[LOCATION] : $defaultLocation;
        $sponsorLogo = isset($instance[SPONSOR_LOGO]) ? $instance[SPONSOR_LOGO] : null;
        $sponsorUrl = isset($instance[SPONSOR_URL]) ? $instance[SPONSOR_URL] : null;

        ?>
		<div class="next-event-admin">
            <label for="<?php echo $this->get_field_id(EVENT_NAME); ?>">
                <?php _e('Event name:');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(EVENT_NAME); ?>" 
                name="<?php echo $this->get_field_name(EVENT_NAME); ?>" 
                type="text" 
                value="<?php echo esc_attr($eventName); ?>"
                placeholder="e.g. From Functional to Reactive Programming - Dr. Venkat Subramaniam"
            />
            <label for="<?php echo $this->get_field_id(MEETUP_URL); ?>">
                <?php _e('Meetup URL:');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(MEETUP_URL); ?>" 
                name="<?php echo $this->get_field_name(MEETUP_URL); ?>" 
                type="text" 
                value="<?php echo esc_attr($meetupUrl); ?>" 
                placeholder="e.g. https://www.meetup.com/Warszawa-JUG/events/245279278/" 
            />
            <label for="<?php echo $this->get_field_id(DATE_TIME); ?>">
                <?php _e('Date and time:');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(DATE_TIME); ?>" 
                name="<?php echo $this->get_field_name(DATE_TIME); ?>" 
                type="text" 
                value="<?php echo esc_attr($dateTime); ?>"
                placeholder="e.g. 14.09.2017 , 18:15"
            />
            <label for="<?php echo $this->get_field_id(LOCATION); ?>">
                <?php _e('Location:');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(LOCATION); ?>" 
                name="<?php echo $this->get_field_name(LOCATION); ?>" 
                type="text" 
                value="<?php echo esc_attr($location); ?>"
            />
            <label for="<?php echo $this->get_field_id(SPONSOR_LOGO); ?>">
                <?php _e('Sponsor logo URL (optional):');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(SPONSOR_LOGO); ?>" 
                name="<?php echo $this->get_field_name(SPONSOR_LOGO); ?>" 
                type="text" 
                value="<?php echo esc_attr($sponsorLogo); ?>"
            />
            <label for="<?php echo $this->get_field_id(SPONSOR_URL); ?>">
                <?php _e('Sponsor URL (optional):');?>
            </label>
            <input 
                id="<?php echo $this->get_field_id(SPONSOR_URL); ?>" 
                name="<?php echo $this->get_field_name(SPONSOR_URL); ?>" 
                type="text" 
                value="<?php echo esc_attr($sponsorUrl); ?>"
            />
        </div><?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance[EVENT_NAME] = (!empty($new_instance[EVENT_NAME])) 
            ? strip_tags($new_instance[EVENT_NAME]) 
            : '';
        $instance[MEETUP_URL] = (!empty($new_instance[MEETUP_URL])) 
            ? strip_tags($new_instance[MEETUP_URL]) 
            : '';
        $instance[DATE_TIME] = (!empty($new_instance[DATE_TIME])) 
            ? strip_tags($new_instance[DATE_TIME]) 
            : '';
        $instance[LOCATION] = (!empty($new_instance[LOCATION])) 
            ? strip_tags($new_instance[LOCATION]) 
            : '';
        $instance[SPONSOR_LOGO] = (!empty($new_instance[SPONSOR_LOGO])) 
            ? strip_tags($new_instance[SPONSOR_LOGO]) 
            : '';   
        $instance[SPONSOR_URL] = (!empty($new_instance[SPONSOR_URL])) 
            ? strip_tags($new_instance[SPONSOR_URL]) 
            : '';  
        return $instance;
    }
}
?>
