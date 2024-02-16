<?php



class yu_finder_build_shortcodes
{
    public function __construct()
    {

    }


    /**
     * build shortcode front end
     *TODO: build templates, get platform data, css, error handling iff instance id is incorrect/no instance id
     * @since    1.0.0
     */
    public function build_yufinder_public($atts = []) {
        global $OUTPUT;
        //Create an instance from given ID


        $INSTANCE = new yufinder_Instance($atts['instanceid']);
        $data= $INSTANCE->get_data_tree();



        //render options area
        $options_template=$this->load_options($data['filters']);

    return $options_template;


    }

    /**
     * @param $options array of options and their value
     * @return rendered mustache template
     * @since    1.0.0
     */
    private function load_options($options)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-filters');
        //
        $params=[
            'filters'=>$options
        ];
        return $template->render($params);

    }


}