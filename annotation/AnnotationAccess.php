<?php

namespace IonXLab\JacksonPhp\annotation;
use IonXLab\JacksonPhp\util\ArrayCollection;

/**
 * Class AnnotationAccess
 *
 * Allow to define access rights of read or write with level authentication
 * (integer where 0=SuperAdmin, 1=Admin, 2=moderator .... to the infinite :) )
 *
 * @package IonXLab\JacksonPhp\annotation
 */
class AnnotationAccess extends JacksonAnnotation implements JacksonAnnotationInterface {

    /**
     * @param array $parameters the parameters defined in "instance" of the annotation
     * @param array $variables the variables defined in "instance" of the annotation
     */
    public function __construct($parameters, $variables) {
        $annotationParameters = new ArrayCollection("IonXLab\\JacksonPhp\\annotation\\JacksonAnnotationArgument");
        $annotationParameters->addAt("read", new JacksonAnnotationArgument("read", "integer"));
        $annotationParameters->addAt("write", new JacksonAnnotationArgument("write", "integer"));
        parent::__construct("access",
            $annotationParameters,
            null,
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