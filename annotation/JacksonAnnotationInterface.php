<?php

namespace IonXLab\JacksonPhp\annotation;

/**
 * Interface JacksonAnnotationInterface
 * @package IonXLab\JacksonPhp\annotation
 */
interface JacksonAnnotationInterface {

    /**
     * @param array $parameters the parameters defined in "instance" of the annotation
     * @param array $variables the variables defined in "instance" of the annotation
     */
    public function __construct($parameters, $variables);

    /**
     * Returns the name value.
     * @return string
     */
    public function getName();

    /**
     * Returns the parameters.
     * @return array
     */
    public function getParameters();

    /**
     * Add a parameter.
     * @param string $parameterName the parameter name (eg: id)
     * @param mixed $parameterValue the parameter value (eg: 247)
     */
    public function addParameter($parameterName, $parameterValue);

    /**
     * Add an array of parameters.
     * @param string[] $parameters the parameters to add (eg: array(name=>value))
     */
    public function addParameters($parameters);
    /**
     * Set the parameters.
     * @param array $parameters
     */
    public function setParameters($parameters);

    /**
     * Returns the variables value.
     * @return array $variables the indexed array of variables
     */
    public function getVariables();

    /**
     * Add a var.
     * @param string $var the var to add
     */
    public function addVariable($var);

    /**
     * Add an array of variables.
     * @param string[] $variables the variables to add
     */
    public function addVariables($variables);

    /**
     * Set the variables value.
     * @param array $variables the indexed array of variables
     */
    public function setVariables($variables);

    /**
     * Process, filter and return the given data
     * @param mixed $jsonValue the value of the property in the JSON
     * @param mixed $objectValue the value of the property in the Object
     * @param bool $jsonToObject If the process works with the json or object value first
     * @return mixed
     */
    public function process($jsonValue, $objectValue, $jsonToObject=true);
}

?>