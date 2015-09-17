<?php

namespace IonXLab\JacksonPhp\annotation;
use Hashids\Hashids;
use IonXLab\JacksonPhp\JacksonPhp;
use IonXLab\JacksonPhp\util\ArrayCollection;

/**
 * Class AnnotationId
 *
 * Allow to define that this property is the id of the entity
 *
 * @package IonXLab\JacksonPhp\annotation
 */
class AnnotationId extends JacksonAnnotation implements JacksonAnnotationInterface {

    /**
     * @param array $parameters the parameters defined in "instance" of the annotation
     * @param array $variables the variables defined in "instance" of the annotation
     */
    public function __construct($parameters, $variables) {
        parent::__construct("Id",
            null,
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
        $hashids = new Hashids(JacksonPhp::$hashIdsSalt, 8);
        if($jsonToObject) {
            $decodedId = $hashids->decode($jsonValue);
            return (count($decodedId)>0 ? $decodedId[0] : "");
        } else {
            return $hashids->encode($objectValue);
        }
    }
}

?>