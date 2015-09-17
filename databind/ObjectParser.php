<?php

namespace IonXLab\JacksonPhp\databind;

use ReflectionClass;
use IonXLab\JacksonPhp\annotation\JacksonAnnotation;

/**
 * ObjectParser<br/>
 * Parse PHP objects in an array of ObjectProperty
 * @author Nicolas Gézéquel
 */
class ObjectParser {

    // the object to parse
    private $object;
    // if the parser must parse the properties annotations
    private $parseAnnotations = true;

    /**
     * The constructor
     * @param Object $object (optional) the object to parse
     */
    public function __construct($object = null) {
        if ($object != null) {
            $this->object = $object;
        }
    }

    /**
     * Returns the parseAnnotations value.
     *
     * @return boolean
     */
    public function getParseAnnotations() {
        return $this->parseAnnotations;
    }

    /**
     * Set the parseAnnotations value.
     *
     * @param boolean $parseAnnotations
     */
    public function setParseAnnotations($parseAnnotations) {
        $this->parseAnnotations = $parseAnnotations;
    }

    /**
     * Parse object given in constructor or in the method in array of ObjectProperty
     * @param Object $object the object to parse
     * @param boolean $parseAnnotations if must parse annotations
     * @return boolean|ObjectProperty[]
     */
    public function parseObject($object = null, $parseAnnotations = null) {
        if ($object != null) {
            $this->object = $object;
        } elseif ($this->object == null) {
            return false;
        }

        if ($parseAnnotations != null) {
            $this->parseAnnotations = $parseAnnotations;
        }

        $props = array();

        $reflectionClass = new ReflectionClass($this->object);
        if ($this->parseAnnotations) {
            $annotationsClass = $this->parseAnnotations($reflectionClass->getDocComment());
            $classProperty = new ObjectProperty(true);
            $classProperty->setName("class_".$reflectionClass->getName());
            $classProperty->setAnnotations($annotationsClass);
            $props[$classProperty->getName()] = $classProperty;
        }

        // Analyze the class properties
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {

            // Analyze the class property
            $prop = new ObjectProperty();
            $prop->setName($property->getName());
            $prop->setIsPrivate($property->isPrivate());
            $prop->setIsProtected($property->isProtected());
            $prop->setIsPublic($property->isPublic());
            $prop->setHasGetter((
                $reflectionClass->hasMethod("get" . ucfirst($prop->getName()))
                && $reflectionClass->getMethod("get" . ucfirst($prop->getName()))->isPublic() ?
                    "get".ucfirst($prop->getName()) : false));
            if($prop->hasGetter()) {
                $prop->setGetter("get".ucfirst($prop->getName()));
            }
            $prop->setHasSetter((
                $reflectionClass->hasMethod("set" . ucfirst($prop->getName()))
                && $reflectionClass->getMethod("set" . ucfirst($prop->getName()))->isPublic() ?
                    "set" . ucfirst($prop->getName()) : true));
            if($prop->hasSetter()) {
                $prop->setSetter("set".ucfirst($prop->getName()));
            }
            if ($prop->isPublic()) {
                $propValue = $property->getValue();
                if (!empty($propValue)) {
                    $prop->setValue($property->getValue());
                } elseif ($prop->hasGetter() != "") {
                    $getter = $prop->hasGetter();
                    $prop->setValue($this->object->$getter());
                }
            } elseif ($prop->hasGetter() != "") {
                $getter = $prop->hasGetter();
                $prop->setValue($this->object->$getter());
            } else {
                $prop->setValue(null);
            }

            // Analyze the class property annotation
            if ($this->parseAnnotations) {
                $docblock = $property->getDocComment();
                $prop->setAnnotations($this->parseAnnotations($docblock));
            }

            $props[$prop->getName()] = $prop;
        }

//        echo "<pre>";
//        print_r($props);
//        echo "</pre>";
        return $props;
    }

    /**
     * Parse Annotations in DocBlock
     *
     * @param string $docblock Full method docblock
     * @return JacksonAnnotation[]
     */
     protected function parseAnnotations($docblock) {
        $annotations = array();

        $docblock = substr($docblock, 3, -2);

        $regexAnnotationName = '/@([A-Za-z0-9_-]+)(.*)/';
        if (preg_match_all($regexAnnotationName, $docblock, $annotationNameMatches)) {

//            echo "<pre>";
//            print_r($annotationNameMatches);
//            echo "</pre>";

            // Loop for each annotation
            foreach($annotationNameMatches[2] as $key=>$annotationParameters) {
                $annotationName = $annotationNameMatches[1][$key];
                $annotationParams = array();
                $annotationVars = array();

//                echo $annotationNameMatches[0][$key]."<br>";

                // Parse in-parenthesis parameters and between space parameters
                $regexAnnotationParenthesisParameters = '/\((.*)\)(.*)/';
                if(preg_match($regexAnnotationParenthesisParameters, $annotationParameters, $annotationParenthesisParameters)) {
//                    echo "0<pre>";
//                    print_r($annotationParenthesisParameters);
//                    echo "</pre>";

                    // Split in-parenthesis parameters by ','
                    $annotationEqualParameters = preg_split('/\s*,+\s*/', $annotationParenthesisParameters[1], -1, PREG_SPLIT_NO_EMPTY);
//                    echo "1<pre>";
//                    print_r($annotationEqualParameters);
//                    echo "</pre>";

                    $regexEqualParameter = '/(.*?)\s*\=\s*[\"\']{1}(.*?)[\"\']{1}/';
                    foreach($annotationEqualParameters as $annotationEqualParameter) {
                        if(preg_match($regexEqualParameter, $annotationEqualParameter, $equalParameterMatch)) {
//                            echo "2<pre>";
//                            print_r($equalParameterMatch);
//                            echo "</pre>";
                            $annotationParams[$equalParameterMatch[1]] = $equalParameterMatch[2];
                        }
                    }

                    // Split remaining between-spaces vars
                    $annotationSpaceVars = preg_split('/\s+/', $annotationParenthesisParameters[2], -1, PREG_SPLIT_NO_EMPTY);
                    $annotationVars[] = $annotationSpaceVars;
//                    echo "3a<pre>";
//                    print_r($annotationSpaceVars);
//                    echo "</pre>";
                // There is no in-parenthesis parameters so only parse between space parameters
                } else {
                    $annotationSpaceVars = preg_split('/\s+/', $annotationParameters, -1, PREG_SPLIT_NO_EMPTY);
                    $annotationVars[] = $annotationSpaceVars;
//                    echo "3b<pre>";
//                    print_r($annotationSpaceVars);
//                    echo "</pre>";
                }

                // instanciate the right jacksonphp annotation, if it does not exists we don't keep it !
                $annotation = JacksonAnnotation::getAnnotation($annotationName, $annotationParams, $annotationVars);
                if($annotation!=null) {
                    $annotations[$annotation->getName()] = $annotation;
                }
            }
        }
//        echo "4<pre>";
//        print_r($annotations);
//        echo "</pre>";

        return $annotations;
    }
}

?>