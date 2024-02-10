<?php

class __MyTemplates_0fd9d20f5417869887658e61b12c03e4 extends Mustache_Template
{
    protected $strictCallables = true;
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="container">
';
        $buffer .= $indent . '    <div class="row mt-5">
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
