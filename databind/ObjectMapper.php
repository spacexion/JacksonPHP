<?php

namespace IonXLab\JacksonPhp\databind;
use IonXLab\JacksonPhp\JacksonPhp;

/**
 * Allow to map Json data format to/from an Object
 * @author Nicolas Gézéquel
 */
class ObjectMapper {

    private $useAnnotations;


    /**
     * @param bool $useAnnotations if mapper has to use entities annotations
     * @param bool $hashIds if mapper use
     * @param string $hashIdsSalt the salt to correctly hash the ids
     */
    public function __construct($useAnnotations=true, $hashIds=null, $hashIdsSalt=null) {
        $this->useAnnotations = $useAnnotations;

        if(!is_null($hashIds)) {
            JacksonPhp::$hashIds = $hashIds;
        }
        if(!is_null($hashIdsSalt)) {
            JacksonPhp::$hashIdsSalt = $hashIdsSalt;
        }
    }

    /**
     * Write Json string to Object
     * @param string $json the json string
     * @param Object $object the object (new Object())
     * @return null|Object
     */
    public function readValue($json, $object) {
        $object = $this->mapJsonToObject($json, $object);

        return $object;
    }

    /**
     * Write Object to Json
     * @param Object $object the object to map
     * @return string
     */
    public function writeValue($object) {
        $json = $this->mapObjectToJson($object);

        return $json;
    }

    /**
     * @param string $json the json string
     * @param Object $object the object to map json over
     * @return boolean|Object
     */
    private function mapJsonToObject($json, $object) {
        // Check provided vars
        if (!is_object($object)) {
            return false;
        }
        if (json_decode($json) == null) {
            return false;
        }

        $arrayJson = json_decode($json, true);
        if(!is_array($arrayJson)) {
            return false;
        }

        $objectParser = new ObjectParser();

        $properties = $objectParser->parseObject($object, $this->useAnnotations);

        foreach ($properties as $property) {
            if (array_key_exists($property->getName(), $arrayJson) && $property->hasSetter()) {
                $jsonProperty = $arrayJson[$property->getName()];

                foreach($property->getAnnotations() as $annotation) {
                    $jsonProperty = $annotation->process($jsonProperty, $property->getValue(), true);
                }
                $setterProperty = $property->getSetter();
                $object->$setterProperty($jsonProperty);
            }
        }
//        echo "<pre>";
//        print_r($object);
//        echo "</pre>";
        return $object;
    }

    /**
     * @param Object $object the object to map into Json
     * @return string
     */
    private function mapObjectToJson($object) {
        $json = array();
        if(!is_object($object)) {
            return false;
        }

        $objectParser = new ObjectParser();

        $properties = $objectParser->parseObject($object, $this->useAnnotations);
        foreach ($properties as $property) {
            if($property->hasGetter()) {
                $getter = $property->getGetter();
                $value = $object->$getter();

                foreach($property->getAnnotations() as $annotation) {
                    $value = $annotation->process(null, $property->getValue(), false);
                }
                $json[$property->getName()] = $value;
            }
        }

        return json_encode($json);
    }
}

?>