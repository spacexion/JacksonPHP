<?php

namespace IonXLab\JacksonPhp\annotation;
use IonXLab\JacksonPhp\util\ArrayCollection;

/**
 * Class JacksonAnnotation
 * @package IonXLab\JacksonPhp\annotation
 *
 * A Jackson annotation is composed like this :
 * @{$name}({$parameters[0]},{$parameters[1]},....) {$variables[0]} {$variables[1]} .....
 */
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
    protected $parameters = array();

    /**
     * @var ArrayCollection the available parameters of the annotation
     */
    protected $annotationParameters;

    /**
     * The variables after the annotation name as an indexed array
     * @var array
     */
    protected $variables = array();

    /**
     * @var ArraCollection the available variables of the annotation
     */
    protected $annotationVariables;

    /**
     * The constructor
     * @param string $name the name of the annotation
     * @param ArrayCollection $annotationParameters the available parameters of the annotation
     * @param ArrayCollection $annotationVariables the available variables of the annotation
     * @param array $parameters the parameters given in the entity
     * @param array $variables the variable given in the entity
     */
    public function __construct($name, $annotationParameters=null, $annotationVariables=null,
                                $parameters=array(), $variables=array()) {
        $this->name = $name;
        if(is_object($annotationParameters)
            && get_class($annotationParameters)=="IonXLab\\JacksonPhp\\util\\ArrayCollection"
            && $annotationParameters->getType()=="IonXLab\\JacksonPhp\\annotation\\JacksonAnnotationArgument") {
            $this->annotationParameters = $annotationParameters;
        }
        if(is_object($annotationVariables)
            && get_class($annotationParameters)=="IonXLab\\JacksonPhp\\util\\ArrayCollection"
            && $annotationParameters->getType()=="IonXLab\\JacksonPhp\\annotation\\JacksonAnnotationArgument") {
            $this->annotationVariables = $annotationVariables;
        }
        if(is_array($parameters)) {
            $this->parameters = $parameters;
        }
        if(is_array($variables)) {
            $this->variables = $variables;
        }
    }

    /**
     * Return an instance of the right JacksonPhp Annotation
     *
     * @param string $name the annotation name
     * @param array $parameters
     * @param array $variables
     * @return JacksonAnnotation|null
     */
    public static function getAnnotation($name, $parameters, $variables) {
        switch($name) {
            case "access":
                return new AnnotationAccess($parameters,$variables);
            case "Id":
                return new AnnotationId($parameters,$variables);
            case "var":
                return new AnnotationVar($parameters,$variables);
            default:
                return null;
        }
    }

    /**
     * Returns the name value.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the parameters.
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Add a parameter.
     * @param string $parameterName the parameter name (eg: id)
     * @param mixed $parameterValue the parameter value (eg: 247)
     */
    public function addParameter($parameterName, $parameterValue) {
        $this->parameters[$parameterName] = $parameterValue;
    }

    /**
     * Add an array of parameters.
     * @param string[] $parameters the parameters to add (eg: array(name=>value))
     */
    public function addParameters($parameters) {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * Set the parameters.
     * @param array $parameters
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Returns the variables value.
     * @return array $variables the indexed array of variables
     */
    public function getVariables() {
        return $this->variables;
    }

    /**
     * Add a var.
     * @param string $variable the var to add
     */
    public function addVariable($variable) {
        $this->variables[] = $variable;
    }

    /**
     * Add an array of variables.
     * @param string[] $variables the variables to add
     */
    public function addVariables($variables) {
        $this->variables = array_merge($this->variables, $variables);
    }

    /**
     * Set the variables value.
     * @param array $variables the indexed array of variables
     */
    public function setVariables($variables) {
        $this->variables = $variables;
    }
}

?>