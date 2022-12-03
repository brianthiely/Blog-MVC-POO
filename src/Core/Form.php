<?php
declare(strict_types=1);

namespace App\Core;

use App\Globals\_POST;
use App\Globals\_SESSION;

abstract class Form
{
    private string $formCode = '';
    protected _POST $post;
    protected _SESSION $session;

    public function __construct()
    {
        $this->post = new _POST();
        $this->session = new _SESSION();
    }

    /**
     * Generate the HTML form
     * @return string
     */
    public function create(): string
    {
        return $this->formCode;
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return $this->post->isPost('submit');
    }

    /**
     * Validate if all the fields proposed are filled
     * @param array $form Form table (_$POST, $_GET)
     * @param array $fields Array listing the mandatory fields
     * @return bool
     */
    public static function validate(array $form, array $fields): bool
    {
        foreach ($fields as $field) {
            if (empty($form[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Add the attributes sent to the tag
     * @param array $attributes Associative array ['class' => 'form-control', 'required' => true]
     * @return string Generated character string
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
            } else {
                $str .= " $attribute=\"$value\"";
            }
        }
        return $str;
    }

    /**
     * Add the opening tag of the form
     * @param string $action
     * @param string $method
     * @param array $attributes
     * @return $this
     */
    public function startForm(string $action = '#', string $method = 'post', array $attributes = []): self
    {
        $this->formCode .= "<form action='$action' method='$method'";
        // We add the attributes to the form tag if there are
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Add the closing tag of the form
     * @return $this
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Add a label to the form
     * @param string $for
     * @param string $label
     * @param array $attributes
     * @return $this
     */
    public function addLabelFor(string $for, string $label, array $attributes = []): self
    {
        // We open the label tag
        $this->formCode .= "<label for='$for'";
        // We add the attributes to the label tag if there are
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        // We add the label text
        $this->formCode .= $label . '</label>';
        return $this;
    }

    /**
     * Add an input to the form
     * @param string $type
     * @param string $name
     * @param array $attributes
     * @return $this
     */
    public function addInput(string $type, string $name, array $attributes = []): self
    {
        $this->formCode .= "<input type='$type' name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Add a textarea to the form
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @return $this
     */
    public function addTextarea(string $name, string $value = '', array $attributes = []): self
    {
        $this->formCode .= "<textarea name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        $this->formCode .= ">$value</textarea>";
        return $this;
    }

    /**
     * Add a select to the form
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return $this
     */
    public function addSelect(string $name, array $options, array $attributes = []): self
    {
        $this->formCode .= "<select name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        foreach ($options as $value => $label) {
            $this->formCode .= "<option value='\"$value\"'>$label</option>";
        }
        $this->formCode .= '</select>';
        return $this;
    }

    /**
     * Add a button to the form
     * @param string $text
     * @param array $attributes
     * @return $this
     */
    public function addButton(string $text, array $attributes = []): self
    {
        $this->formCode .= '<button ';
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        $this->formCode .= ">$text</button>";
        return $this;
    }
}
