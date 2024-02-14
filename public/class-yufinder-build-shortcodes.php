<?php



class yu_finder_build_shortcodes
{
    public function build_shortcode()
    {
        add_shortcode('yufinder', [$this, 'yufinder_shortcode']);
    }

    public function yufinder_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'instanceid' => 0,
            ),
            $atts,
            'yufinder'
        );

        $instanceid = $atts['instanceid'];


        return $output;
    }
}