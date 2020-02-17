<?php

namespace App\Helpers;

class Form
{
    private $form_id;
    private $cross_identifier;
    private $model;

    public function __construct(string $form_id, $model, $cross_identifier = 'form_id') {
        $this->form_id = $form_id;
        $this->model = $model;
        $this->cross_identifier = $cross_identifier;
    }

    public function value($name, $default = null)
    {
        $default = $default ?? $this->model[$name];
        return ( old($this->cross_identifier) == $this->form_id ? old($name, $default) : $default );
    }
}
