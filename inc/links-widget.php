<?php
namespace BandConcerts\Theme;

class LinksWidget extends \WP_Widget {
    function __construct() {
        parent::__construct(
            'bc_links_widget',
            __('BC Links'),
            [ 'description' => __('Links to related resources') ]
        );
    }
    /**
     * Prints the widget.
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];
	    if (!empty($instance['title'])) {
		    echo $args['before_title'].apply_filters('widget_title', $instance['title']).$args['after_title'];
	    }
        ?><a href="<?php echo esc_attr(preg_replace('/^https?:/', 'webcal:', get_feed_link("bc-ical"))) ?>" title="Terminkalender abonnieren" rel="calendar">
            <svg class="fa-footer">
        	   <use xlink:href="<?php echo esc_attr(get_template_directory_uri()) ?>/images/fa-solid.svg#calendar-plus"></use>
        	</svg>
        </a><?php
        if(!empty($instance['facebook'])) { ?>
            <a href="<?php echo esc_attr($instance['facebook']) ?>" title="Facebook Seite" rel="external noopener me">
                <svg class="fa-footer">
            	   <use xlink:href="<?php echo esc_attr(get_template_directory_uri()) ?>/images/fa-brands.svg#facebook"></use>
            	</svg>
            </a><?php
        }
        echo $args['after_widget'];
    }
    /**
     * Prints the widget settings in the customizer.
     */
    public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : '';
		$titleFieldId = esc_attr($this->get_field_id('title'));
        $fbFieldId = esc_attr($this->get_field_id('facebook'));
?><p>
    <label for="<?php echo $titleFieldId; ?>"><?php _e(esc_attr('Title:')); ?></label>
    <input class="widefat" id="<?php echo $titleFieldId; ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    <label for="<?php echo $fbFieldId; ?>"><?php _e('Facebook:'); ?></label>
    <input class="widefat" id="<?php echo $fbFieldId; ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="url" value="<?php echo esc_attr($instance['facebook']); ?>" placeholder="https://www.facebook.com/MyPage/">
</p><?php
	}
    /**
     * Saves the new settings from the customizer.
     */
	public function update($new_instance, $old_instance) {
		$instance = [];
		$instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['facebook'] = !empty($new_instance['facebook']) ? strip_tags($new_instance['facebook']) : '';
		return $instance;
	}
}
