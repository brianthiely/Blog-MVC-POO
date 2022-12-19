<?php
declare(strict_types=1);

namespace App\Core;

use App\Globals\GlobalsFactory;
use http\Params;

abstract class Form
{
    // Utilise le style "snake_case" pour les variables
    private string $form_code = '';

    /**
     * Génère le formulaire HTML
     * @return string
     */
    public function create(): string
    {
        return $this->form_code;
    }

    /**
     * Vérifie si le formulaire a été soumis
     * @return bool
     */
    public function isSubmitted(): bool
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return !empty($global->getPost());
    }

    /**
     * Ajoute les attributs envoyés à la balise
     * @param array $attributes Tableau associatif ['class' => 'form-control', 'required' => true]
     * @return string Chaîne de caractères générée
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
     * Ajoute la balise d'ouverture du formulaire
     * @param string $action
     * @param string $method
     * @param array $attributes
     * @return $this
     */
    public function startForm(string $action = '#', string $method = 'post', array $attributes = []): self
    {
        $this->form_code .= "<form action='$action' method='$method'";
        // Nous ajoutons les attributs à la balise form si nécessaire
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Ajoute la balise de fermeture du formulaire
     * @return $this
     */
    public function endForm(): self
    {
        $this->form_code .= '</form>';
        return $this;
    }

    /**
     * Ajoute une étiquette au formulaire
     * @param string $for
     * @param string $label
     * @param array $attributes
     * @return $this
     */
    public function addLabelFor(string $for, string $label, array $attributes = []): self
    {
        // Nous ouvrons la balise étiquette
        $this->form_code .= "<label for='$for'";
        // Nous ajoutons les attributs à la balise étiquette si nécessaire
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        // Nous ajoutons le texte de l'étiquette
        $this->form_code .= $label . '</label>';
        return $this;
    }

    /**
     * Ajoute un input au formulaire
     * @param string $type
     * @param string $name
     * @param array $attributes
     * @return $this
     */
    public function addInput(string $type, string $name, array $attributes = []): self
    {
        $this->form_code .= "<input type='$type' name='$name'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /**
     * Ajoute une zone de texte au formulaire
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @return $this
     */
    public function addTextarea(string $name, string $value = '', array $attributes = []): self
    {
        $this->form_code .= "<textarea name='$name'";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        $this->form_code .= $value . '</textarea>';
        return $this;
    }

    /**
     * Ajoute un bouton au formulaire
     * @param string $text
     * @param array $attributes
     * @return $this
     */
    public function addButton(string $text, array $attributes = []): self
    {
        $this->form_code .= '<button ';
        $this->form_code .= $attributes ? $this->addAttributes($attributes) : '';
        $this->form_code .= ">$text</button>";

        return $this;
    }

    /**
     * Ajoute une balise span au formulaire
     * @param string $content Contenu de la balise span
     * @param array $attributes Attributs de la balise span
     * @return $this
     */
    public function addSpan(string $content, array $attributes = []): self
    {
        $this->form_code .= "<span";
        $this->form_code .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        $this->form_code .= $content . '</span>';
        return $this;
    }

    /**
     * Récupère les données du formulaire
     * @return array Tableau associatif des données du formulaire
     */
    abstract public function getData(): array;

    /**
     * Vérifie si les données du formulaire sont valides
     * @return bool
     */
    abstract public function isValid(): bool;

}
