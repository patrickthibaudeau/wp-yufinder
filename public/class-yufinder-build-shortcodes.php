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

        $html = "";

        $INSTANCE = new yufinder_Instance($atts['instanceid']);
        $data= $INSTANCE->get_data_tree();


//        print_object($data['platforms']);
        //temp functions to load tests
//        $test_template=$this->load_options($data['filters']);
       // $test_template=$this->load_platforms($data);

    // return $test_template;

        $html .= "<table class=\"table table-striped table-bordered scrolling\" id=\"comparisonchart\"><thead><tr><td></td>";

        $platform_table_title_template=$this->load_platform_table_title($data['platform_table_title']);

        $html .= $platform_table_title_template;

        $html .= "</tr></thead><tbody><tr><th scope=\"row\">Description</th>";

        $platform_table_desc_template=$this->load_platform_table_desc($data['platform_table_desc']);

        $html .= $platform_table_desc_template;

        $html .= "</tr>";

        $platform_table_data_template=$this->load_platform_table_data($data['platform_table_data']);

        $html .= $platform_table_data_template;

        $html .= "</tbody></table>";

        return $html;

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
    private function load_platforms($platforms)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-platforms');
        print_object($platforms["platforms"][0]);


        //
//        $params=[
//            'platforms'=>$platforms
//        ];
        return $template->render($platforms);

    }

    private function load_platform_table_title($data)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-platform-table-title');
        //
        $params=[
            'platform_table_title'=>$data
        ];
        return $template->render($params);
        /* print_object($options["filters"]);
        return $template->render($options); */
    }

    private function load_platform_table_desc($data)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-platform-table-desc');
        //
        $params=[
            'platform_table_desc'=>$data
        ];
        return $template->render($params);
        /* print_object($options["filters"]);
        return $template->render($options); */
    }

    private function load_platform_table_data($options)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-platform-table-data');
        //
        $params=[
            'platform_table_data'=>$options
        ];
        return $template->render($params);
        /* print_object($options["filters"]);
        return $template->render($options); */
    }

}