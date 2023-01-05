<?php
declare(strict_types=1);

namespace App\Core;

use App\Globals\GlobalsFactory;

abstract class Form
{
    private string $form_code = '';

    /**
     * Generates a form
     *
     * @return string The form code
     */
    public function create(): string
    {
        return $this->form_code;
    }

    /**
     * Verifies if the form is submitted
     *
     * @return bool True if the form is submitted, false otherwise
     */
    public function isSubmitted(): bool
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return !empty($global->getPost());
    }

    /**
     * Add attributes to the form tag
     *
     * @param array $attributes An array of attributes
     * @return string The form code
     */
    private function addAttributes(array $attributes): string
    {
        $str = '';
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'form-novalidate'];
        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $courts)) {
                if ($value === true) {
                    $str .= " $attribute";
                }
            }
            $str .= " $attribute=\"$value\"";
        }
        return $str;
    }

    /**
     * Add a form tag for opening the form
     *
     * @param string $action The action attribute
     * @param string $method The method attribute
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function startForm(string $action = '#', string $method = 'post', array $attributes = []): self
    {
        $this->form_code .= "<form action='$action' method='$method'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Add a form tag for closing the form
     *
     * @return $this The form object
     */
    public function endForm(): self
    {
        $this->form_code .= '</form>';
        return $this;
    }

    /**
     * Add a label tag
     *
     * @param string $for The for attribute
     * @param string $label The label text
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function addLabelFor(string $for, string $label, array $attributes = []): self
    {
        $this->form_code .= "<label for='$for'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        $this->form_code .= $label . '</label>';
        return $this;
    }

    /**
     * Add a input tag
     *
     * @param string $type The type attribute
     * @param string $name The name attribute
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function addInput(string $type, string $name, array $attributes = []): self
    {
        $this->form_code .= "<input type='$type' name='$name'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Add a textarea tag
     *
     * @param string $name The name attribute
     * @param string $value The value attribute
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function addTextarea(string $name, string $value = '', array $attributes = []): self
    {
        $this->form_code .= "<textarea name='$name'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        $this->form_code .= $value . '</textarea>';
        return $this;
    }

    /**
     * Add a button tag
     *
     * @param string $text The button text
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function addButton(string $text, array $attributes = []): self
    {
        $this->form_code .= '<button ';
        $this->form_code .= $attributes ? $this->addAttributes($attributes) : '';
        $this->form_code .= ">$text</button>";

        return $this;
    }

    /**
     * Add a span tag
     *
     * @param string $content The span content
     * @param array $attributes An array of attributes
     * @return $this The form object
     */
    public function addSpan(string $content, array $attributes = []): self
    {
        $this->form_code .= "<span";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        $this->form_code .= $content . '</span>';
        return $this;
    }
}
