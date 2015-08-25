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
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {

            $prop = new ObjectProperty();
            $prop->setName($property->getName());
            $prop->setIsPrivate($property->isPrivate());
            $prop->setIsProtected($property->isProtected());
            $prop->setIsPublic($property->isPublic());
            $prop->setHasGetter(($reflectionClass->hasMethod("get" . ucfirst($prop->getName())) && $reflectionClass->getMethod("get" . ucfirst($prop->getName()))->isPublic() ?
                            "get" . ucfirst($prop->getName()) : ""));
            $prop->setHasSetter(($reflectionClass->hasMethod("set" . ucfirst($prop->getName())) && $reflectionClass->getMethod("set" . ucfirst($prop->getName()))->isPublic() ?
                            "set" . ucfirst($prop->getName()) : ""));

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

            if ($this->parseAnnotations) {
                $docblock = $property->getDocComment();
                $annotations = $this->parseAnnotations($docblock);
                $prop->setAnnotations($annotations);
            }

            $props[] = $prop;
        }

        return $props;
    }

    /**
     * Parse Annotations in DocBlock
     *
     * @param string $docblock Full method docblock
     *
     * @return array
     */
    protected function parseAnnotations($docblock) {
        $annotations = array();
        // Strip away the docblock header and footer
        // to ease parsing of one line annotations
        $docblock = substr($docblock, 3, -2);

        // match '@annotation(.*?)$'
        $annotationNameRegex = '/@([A-Za-z0-9_-]+)(.*)/';
        if (preg_match_all($annotationNameRegex, $docblock, $annotationNameMatches)) {

            echo "AnnotationsName<br/>";
            echo "<pre>";
            print_r($annotationNameMatches);
            echo "</pre>";

            $annotationsName = $annotationNameMatches[1];

            foreach ($annotationsName as $key => $annotationName) {
                $annotation = new JacksonAnnotation();
                $annotation->setName($annotationName);

                // match '(param=value,param2=value)(.*?)'
                $annotationParamsRegex = '/\(([A-Za-z0-9\_\-\=\",\w\t\r\n]*?)\)(.*)/';
                if (preg_match($annotationParamsRegex, $annotationNameMatches[2][$key], $annotationParamsMatches)) {

                    echo "Params(" . $annotationName . ")<br/>";
                    echo "<pre>";
                    print_r($annotationParamsMatches);
                    echo "</pre>";

                    $annotationParams = $annotationParamsMatches[1];
                    $annotationParams = preg_replace('/[\w\t]/', '', $annotationParams);

                    // match 'param="value"' or 'param=true'
                    $annotationParamRegex = '/([A-Za-z0-9]+)\=[\"\']{0,1}([A-Za-z0-9]*)[\"\']{0,1}/';
                    if (preg_match_all($annotationParamRegex, $docblock, $annotationParamMatches)) {

                        echo "Param<br/>";
                        echo "<pre>";
                        print_r($annotationParamMatches);
                        echo "</pre>";
                    }
                }


                $annotations[] = $annotation;
            }
        }

        return $annotations;
    }

    /**
     * Parse Annotations in DocBlock
     *
     * @param string $docblock Full method docblock
     *
     * @return array
     */
    protected function parseAnnotations2($docblock) {
        $annotations = array();
        // Strip away the docblock header and footer
        // to ease parsing of one line annotations
        $docblock = substr($docblock, 3, -2);

        //parse '@Annot value' format
        //$re = '/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m';
        //@annot(test=test) var1 var2 var3(.*?)$
        $re2 = '/@([A-Za-z_-]+)(\(([A-Za-z_-\=\", \t\r\n]*?)\))*[ \t]*([^ \t]+)*$/m';
        if (preg_match_all($re2, $docblock, $matches)) {
            $numMatches = count($matches[0]);

            //echo "<pre>";
            //print_r($matches);
            //echo "</pre>";

            for ($i = 0; $i < $numMatches; $i++) {
                $annotation = new JacksonAnnotation();

                $name = $matches[1][$i];
                $parameters = array();
                if ($matches[3][$i] != "") {
                    $paramStr = preg_replace("/ /", '', $matches[3][$i]);
                    foreach (explode(',', $paramStr) as $param) {
                        $paramArray = explode('=', $param);
                        $parameters[$paramArray[0]] = preg_replace('/\"/', '', $paramArray[1]);
                    }
                }
                //$var1 = $matches[4][$i];

                $annotation->setName($name);
                $annotation->setParameters($parameters);
                //$annotation->setVar1($var1);

                $annotations[] = $annotation;
            }
        }

        return $annotations;
    }

}

?>