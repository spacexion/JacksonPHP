<?php

namespace IonXLab\JacksonPhp\annotation;


/**
 * Class JacksonAnnotationArgument
 * @package IonXLab\JacksonPhp\annotation
 *
 * Defines an JacksonAnnotation argument (parameter or variable)
 */
class JacksonAnnotationArgument {

    /**
     * The argument index name or id
     * @var string|int
     */
    private $argumentKey;
    /**
     * The argument type ("boolean"|"integer"|"double"|"string"|"array"|"MyClassName")
     * @var string
     */
    private $argumentType;

    /**
     * @var array
     */
    private $argumentPossibleValues;

    /**
     * @param string|int $argumentKey the name or id of the argument (name only available for annotation parameters)
     * @param string $argumentType ("boolean"|"integer"|"double"|"string"|"array"|"MyClassName") the argument type
     * @param array $argumentPossibleValues optional: restrain accepted values for the argument
     * @throws \Exception If given type is not defined basic type misspelled or unknown class/namespace
     */
    public function __construct($argumentKey, $argumentType, $argumentPossibleValues=array()) {
        $this->argumentKey = $argumentKey;
        if($argumentType==("boolean"
                || "integer"
                || "double"
                || "string"
                || "array")) {
            $this->argumentType = $argumentType;
        } elseif(class_exists($argumentType)) {
            $this->argumentType = $argumentType;
        } else {
            throw new \Exception("Given Type is not defined. Misspelled or forgotten include ?");
        }
        $this->argumentPossibleValues = $argumentPossibleValues;
    }

    /**
     * @return int|string
     */
    public function getArgumentKey() {
        return $this->argumentKey;
    }

    /**
     * @return string
     */
    public function getArgumentType() {
        return $this->argumentType;
    }

    /**
     * @return array
     */
    public function getArgumentPossibleValues() {
        return $this->argumentPossibleValues;
    }
}