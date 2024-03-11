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

       //  $html = "";

        $INSTANCE = new yufinder_Instance($atts['instanceid']);
        $data= $INSTANCE->get_data_tree();
        $data = $this->transform_data($data);
        $template= $OUTPUT->loadTemplate("yufinder-display");
        return $template->render($data);


    }
    /**
     * transform data to be used in the template
     * @param $data
     * @return array
     * @since    1.0.0
     */
    private function transform_data($data)
    {
        $filters = [];
        //reomve all filters types that have a 'type' of 'checkbox'
        foreach ($data['filters'] as $filter) {
            if ($filter['type'] != 'checkbox') {
               $filter['type']=null;

            }
            $filters[] = $filter;
        }
        $data['filters']=$filters;
        return $data;
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
//        $params=[
//            'filters'=>$options
//        ];
        return $template->render($options);

    }
    private function load_platforms($platforms)    {
        global $OUTPUT;

        //load template
        $template=$OUTPUT->loadTemplate('instance-platforms');

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