<?php

class __MyTemplates_580e46b7d9a01a97c857fdc92994933e extends Mustache_Template
{
    protected $strictCallables = true;
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="container">
';
        $buffer .= $indent . '    <div class="row">
';
        $buffer .= $indent . '        <div class="col s6">
';
        $buffer .= $indent . '            Hello
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="col s6">
';
        $buffer .= $indent . '            World
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }
}
