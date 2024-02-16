<?php



class yu_finder_build_shortcodes
{
    public function __construct()
    {

    }

//    public function build_shortcode()
//    {
//        add_shortcode('yufinder', [$this, 'yufinder_shortcode']);
//    }
//
//    public function yufinder_shortcode($atts)
//    {
//        $atts = shortcode_atts(
//            array(
//                'instanceid' => 0,
//            ),
//            $atts,
//            'yufinder'
//        );
//
//        $instanceid = $atts['instanceid'];
//
//
//        return $output;
//    }



    function yufinder_template($atts = []) {
        //return the keys and values in $atts
        $INSTANCE = new yufinder_Instance($atts['instanceid']);
        $INSTANCE->get_data_tree();
        $html = '';
        print_object($atts);
        return $html;
    }

    /**
     * build html for shortcodes
     *
     * @since    1.0.0
     */
    public function build_yufinder_public($atts = []) {
        global $OUTPUT;
        //return the keys and values in $atts
//        $INSTANCE = new yufinder_Instance($atts['instanceid']);
//        $template=$OUTPUT->loadTemplate('instance-filters');
//        $params =[
//            'filters' =>[
//                'id'=> "2",
//                'filter'=>"question1",
//                'choices'=>[
//                    [
//                        'id'=>"1",
//                        'text'=>'choice1',
//
//                    ],
//                    [
//                        'id'=>"2",
//                        'text'=>'choice2',
//
//                    ],
//                    [
//                        'id'=>"3",
//                        'text'=>'choice3',
//
//                    ],
//                ],
//            ]
//        ];
//        return $template->render($params);

        //return the keys and values in $atts
        $INSTANCE = new yufinder_Instance($atts['instanceid']);
        $INSTANCE->get_data_tree();
        $html = '';
        print_object($atts);
        print_r($INSTANCE);
        return $html;


//        $output = $INSTANCE->get_instance();
//        return  $atts['instanceid'];
    }
}