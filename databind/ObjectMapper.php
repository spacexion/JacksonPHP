<?php

namespace IonXLab\JacksonPhp\databind;

/**
 * Allow to map Json data format to/from an Object
 * @author Nicolas Gézéquel
 */
class ObjectMapper {

    public function __construct() {
        
    }

    private function __constructMapper($mapper) {
        
    }

    /**
     * Write Json string to Object
     * @param string $json the json string
     * @param Object $object the object (new Object())
     * @return null|Object
     */
    public function readValue($json, $object) {
        // Check provided vars
        if (!is_object($object)) {
            return null;
        }
        if (json_decode($json) == null) {
            return null;
        }

        $array = json_decode($json, true);
        if(!is_array($array)) {
            return null;
        }

        $object = $this->mapJsonToObject($json, $object);

        return $object;
    }

    /**
     * Write Object to Json
     */
    public function writeValue($out, $object) {
        $json = null;

        return $json;
    }

    /**
     * @param string $json the json string
     * @param Object $object the object to map json over
     * @return null|Object
     */
    private function mapJsonToObject($json, $object) {
        // Check provided vars
        if (!is_object($object)) {
            return null;
        }
        if (json_decode($json) == null) {
            return null;
        }

        $array = json_decode($json, true);
        if(!is_array($array)) {
            return null;
        }

        $objectParser = new ObjectParser();

        $properties = $objectParser->parseObject($object, true);

        foreach ($properties as $property) {
            //$property = new ObjectProperty();
            if (array_key_exists($property->getName(), $array) && $property->getSetter() != "") {

                $setProperty = $property->getSetter();
                $object->$setProperty($array[$property->getName()]);
            }
        }
        echo "<pre>";
        print_r($object);
        echo "</pre>";
    }
}

?>