<?php

class __MyTemplates_ff5202de4a60b688535ff20d5448bd32 extends Mustache_Template
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
        $buffer .= $indent . '                <th>Student</th>
';
        $buffer .= $indent . '                <th>Assignment</th>
';
        $buffer .= $indent . '                <th>Grade</th>
';
        $buffer .= $indent . '                <th>Actions</th>
';
        $buffer .= $indent . '            </tr>
';
        $buffer .= $indent . '            </thead>
';
        $buffer .= $indent . '            <tbody>
';
        $value = $context->find('students');
        $buffer .= $this->section4790fee4af8b73a45ad60def6f0fefd3($context, $indent, $value);
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

    private function section4790fee4af8b73a45ad60def6f0fefd3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (is_object($value) && is_callable($value)) {
            $source = '
                <tr>
                    <td>{{name}}</td>
                    <td>{{assignment}}</td>
                    <td>{{grade}}</td>
                    <td>
                        <a href="/grading/{{id}}/evaluate" class="btn btn-primary">Evaluate</a>
                        <a href="/grading/{{id}}/second-opinion" class="btn btn-primary">Second Opinion</a>
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
                $buffer .= $indent . '                    <td>';
                $value = $this->resolveValue($context->find('assignment'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $buffer .= $indent . '                    <td>';
                $value = $this->resolveValue($context->find('grade'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $buffer .= $indent . '                    <td>
';
                $buffer .= $indent . '                        <a href="/grading/';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/evaluate" class="btn btn-primary">Evaluate</a>
';
                $buffer .= $indent . '                        <a href="/grading/';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/second-opinion" class="btn btn-primary">Second Opinion</a>
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
