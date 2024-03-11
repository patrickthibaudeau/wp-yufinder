<?php

class __MyTemplates_543221e01d5466b28e7a8668070674e0 extends Mustache_Template
{
    private $lambdaHelper;
    protected $strictCallables = true;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="row mt-10">
';
        $buffer .= $indent . '    <div class="col s12">
';
        $buffer .= $indent . '        <h3>Finder settings</h3>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div class="container">
';
        $buffer .= $indent . '    <div class="row mt-10">
';
        $buffer .= $indent . '        <div class="col s12">
';
        $buffer .= $indent . '            <table id="yufinder-instance-table" class="striped highlight">
';
        $buffer .= $indent . '                <thead>
';
        $buffer .= $indent . '                <tr>
';
        $buffer .= $indent . '                    <th>Instances</th>
';
        $buffer .= $indent . '                    <th>Actions</th>
';
        $buffer .= $indent . '                </tr>
';
        $buffer .= $indent . '                </thead>
';
        $buffer .= $indent . '                <tbody>
';
        $value = $context->find('instances');
        $buffer .= $this->section0d3214b2c5328479da8e72ffcccbba0d($context, $indent, $value);
        $buffer .= $indent . '                </tbody>
';
        $buffer .= $indent . '            </table>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section0d3214b2c5328479da8e72ffcccbba0d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (is_object($value) && is_callable($value)) {
            $source = '
                    <tr>
                        <td>{{name}}</td>
                        <td>
                            <a href="/edit_instance.php?id={{id}}" class="waves-effect waves-light btn-small">Edit</a>
                            <a href="/edit_settings.php?instanceid={{id}}" class="waves-effect waves-light
                            btn-small">Settings</a>
                            <a href="/edit_content.php?instanceid={{id}}" class="waves-effect waves-light
                            btn-small">Content</a>
                            <button type="button" data-instance="{{id}}" class="waves-effect waves-light btn-small red">
                                Delete
                            </button>
                        </td>
                    </tr>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda($result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <tr>
';
                $buffer .= $indent . '                        <td>';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $buffer .= $indent . '                        <td>
';
                $buffer .= $indent . '                            <a href="/edit_instance.php?id=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="waves-effect waves-light btn-small">Edit</a>
';
                $buffer .= $indent . '                            <a href="/edit_settings.php?instanceid=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="waves-effect waves-light
';
                $buffer .= $indent . '                            btn-small">Settings</a>
';
                $buffer .= $indent . '                            <a href="/edit_content.php?instanceid=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="waves-effect waves-light
';
                $buffer .= $indent . '                            btn-small">Content</a>
';
                $buffer .= $indent . '                            <button type="button" data-instance="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="waves-effect waves-light btn-small red">
';
                $buffer .= $indent . '                                Delete
';
                $buffer .= $indent . '                            </button>
';
                $buffer .= $indent . '                        </td>
';
                $buffer .= $indent . '                    </tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
