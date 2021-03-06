<?php

namespace IonXLab\JacksonPhp\annotation;
use IonXLab\JacksonPhp\util\ArrayCollection;

/**
 * Class AnnotationVar
 *
 * Allow to define attribute type ("boolean"|"integer"|"double"|"string"|"array"|"MyClassName")
 *
 * @package IonXLab\JacksonPhp\annotation
 */
class AnnotationVar extends JacksonAnnotation implements JacksonAnnotationInterface {

    /**
     * @param array $parameters the parameters defined in "instance" of the annotation
     * @param array $variables the variables defined in "instance" of the annotation
     */
    public function __construct($parameters, $variables) {
        $annotationVariables = new ArrayCollection("IonXLab\\JacksonPhp\\annotation\\JacksonAnnotationArgument");
        $annotationVariables->add(new JacksonAnnotationArgument(0, "string"));
        parent::__construct("var",
            null,
            $annotationVariables,
            $parameters,
            $variables);
    }

    /**
     * Process, filter and return the given data
     * @param mixed $jsonValue the value of the property in the JSON
     * @param mixed $objectValue the value of the property in the Object
     * @param bool $jsonToObject If the process works with the json or object value first
     * @return mixed
     */
    public function process($jsonValue, $objectValue, $jsonToObject = true) {

    }
}

?>