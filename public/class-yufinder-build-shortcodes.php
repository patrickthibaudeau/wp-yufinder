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


        print_object($data['platforms']);
        //temp functions to load tests
//        $test_template=$this->load_options($data['filters']);
        $test_template=$this->load_platforms($data['platforms']);

    return $test_template;


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
        //
        $services = array(
            array(
                "id" => "1",
                "checked" => "checked",
                "title" => "Service 1",
                "summary" => "This is a summary of service 1."
            ),
            array(
                "id" => "2",
                "checked" => "",
                "title" => "Service 2",
                "summary" => "This is a summary of service 2."
            ),
            array(
                "id" => "3",
                "checked" => "checked",
                "title" => "Service 3",
                "summary" => "This is a summary of service 3."
            )
        );
        return $template->render($services);

    }


}