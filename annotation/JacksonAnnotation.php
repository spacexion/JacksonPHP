<?php

namespace IonXLab\JacksonPhp\annotation;

class JacksonAnnotation {

    /**
     * The name of the annotation
     * @var string
     */
    protected $name;

    /**
     * The parameters in parenthesis as an associative array
     * @var array
     */
    protected $parameters;

    /**
     * The variables after the annotation name as an indexed array
     * @var array
     */
    protected $vars;

    /**
     * The constructor
     * @param string $name (optional) default "jacksonannotation"
     */
    public function __construct($name = "jacksonannotation") {
        $this->name = $name;
    }

    /**
     * Returns the name value.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the name value.
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the parameters value.
     *
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Set the parameters value.
     *
     * @param array $parameters
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Returns the vars value.
     *
     * @return array $vars the indexed array of vars
     */
    public function getVars() {
        return $this->vars;
    }

    /**
     * Set the vars value.
     *
     * @param array $vars the indexed array of vars
     */
    public function setVars($vars) {
        $this->vars = $vars;
    }

}

?>