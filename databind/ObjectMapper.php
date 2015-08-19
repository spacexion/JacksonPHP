<?php

if (!class_exists("VarType")) {
    require_once(str_replace('\\', '/', __DIR__ . "/") . "../annotation/VarType.php");
}
if (!class_exists("ObjectParser")) {
    require_once(str_replace('\\', '/', __DIR__ . "/") . "ObjectParser.php");
}

/**
 * Allow to map Json data format to/from an Object
 * @author Nicolas G�z�quel
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

    private function mapJsonToObject($json, $object) {
        // Check provided vars
        if (!is_object($object)) {
            return null;
        }
        if (json_decode($json) == null) {
            return null;
        }

        $array = json_decode($json, true);
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

    private function mapObjectToUser() {
        
    }

}

?>