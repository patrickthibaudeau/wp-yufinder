<?php

class __MyTemplates_0f7bf17432ba61e8bceaba102d280b1b extends Mustache_Template
{
    protected $strictCallables = true;
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="container">
';
        $buffer .= $indent . '    <div class="row mt-10">
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
