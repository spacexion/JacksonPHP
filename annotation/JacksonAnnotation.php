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
        $this->parameters = array();
        $this->vars = array();
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
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Add a parameter.
     *
     * @param mixed $parameterName the parameter name (eg: id)
     * @param mixed $parameterValue the parameter value (eg: 247)
     */
    public function addParameter($parameterName, $parameterValue) {
        $this->parameters[$parameterName] = $parameterValue;
    }

    /**
     * Add an array of parameters.
     *
     * @param string[] $parameters the parameters to add (eg: array(name=>value))
     */
    public function addParameters($parameters) {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * Set the parameters.
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
     * Add a var.
     *
     * @param string $var the var to add
     */
    public function addVar($var) {
        $this->vars[] = $var;
    }

    /**
     * Add an array of vars.
     *
     * @param string[] $vars the vars to add
     */
    public function addVars($vars) {
        $this->vars = array_merge($this->vars, $vars);
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