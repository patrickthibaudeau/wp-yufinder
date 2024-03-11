<?php

class __MyTemplates_47456f888a8a340870d4b4bb745b11e8 extends Mustache_Template
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
        $buffer .= $indent . '        <h1>Finder settings</h1>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div class="row mt-10">
';
        $buffer .= $indent . '    <div class="col s12">
';
        $buffer .= $indent . '        <table class="striped">
';
        $buffer .= $indent . '            <thead>
';
        $buffer .= $indent . '            <tr>
';
        $buffer .= $indent . '                <th>Instance</th>
';
        $buffer .= $indent . '                <th>Actions</th>
';
        $buffer .= $indent . '            </tr>
';
        $buffer .= $indent . '            </thead>
';
        $buffer .= $indent . '            <tbody>
';
        $value = $context->find('instances');
        $buffer .= $this->section83f7f4c587f4005b95dcf441830ed2ad($context, $indent, $value);
        $buffer .= $indent . '            </tbody>
';
        $buffer .= $indent . '        </table>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section83f7f4c587f4005b95dcf441830ed2ad(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (is_object($value) && is_callable($value)) {
            $source = '
                <tr>
                    <td>{{name}}</td>
                    <td>
                        <a href="/edit_instance.php?id={{id}}" class="btn btn-primary">Edit</a>
                        <a href="/edit_settings.php?instanceid={{id}}" class="btn btn-primary">Settings</a>
                        <a href="/edit_content.php?instanceid={{id}}" class="btn btn-primary">Content</a>
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
                
                $buffer .= $indent . '                <tr>
';
                $buffer .= $indent . '                    <td>';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $buffer .= $indent . '                    <td>
';
                $buffer .= $indent . '                        <a href="/edit_instance.php?id=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="btn btn-primary">Edit</a>
';
                $buffer .= $indent . '                        <a href="/edit_settings.php?instanceid=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="btn btn-primary">Settings</a>
';
                $buffer .= $indent . '                        <a href="/edit_content.php?instanceid=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="btn btn-primary">Content</a>
';
                $buffer .= $indent . '                    </td>
';
                $buffer .= $indent . '                </tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
