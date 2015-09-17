<?php

namespace IonXLab\JacksonPhp\databind;

/**
 * Represents a property of a class
 * @author Nicolas Gezequel
 */
class ObjectProperty {

    private $name = null;
    private $value = null;
    private $defaultValue = null;
    private $annotations = array();
    private $hasGetter = false;
    private $hasSetter = false;
    private $getter = "";
    private $setter = "";
    private $public = false;
    private $protected = false;
    private $private = false;

    private $isClassProperty = false;

    public function __construct($isClassProperty=false) {
        $this->isClassProperty = $isClassProperty;
    }

    /**
     * Returns the name value.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the name value.
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the value value.
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Set the value value.
     *
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * Returns the defaultValue value.
     *
     * @return mixed
     */
    public function getDefaultValue() {
        return $this->defaultValue;
    }

    /**
     * Set the defaultValue value.
     *
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Returns the annotations value.
     *
     * @return \IonXLab\JacksonPhp\annotation\JacksonAnnotation[]
     */
    public function getAnnotations() {
        return $this->annotations;
    }

    /**
     * Set the annotations value.
     *
     * @param \IonXLab\JacksonPhp\annotation\JacksonAnnotation[] $annotations
     */
    public function setAnnotations($annotations) {
        $this->annotations = $annotations;
    }

    /**
     * Returns the hasGetter value.
     *
     * @return boolean
     */
    public function hasGetter() {
        return $this->hasGetter;
    }

    /**
     * Set the hasGetter value.
     *
     * @param boolean $hasGetter
     */
    public function setHasGetter($hasGetter) {
        $this->hasGetter = $hasGetter;
    }

    /**
     * Returns the hasSetter value.
     *
     * @return boolean
     */
    public function hasSetter() {
        return $this->hasSetter;
    }

    /**
     * Set the hasSetter value.
     *
     * @param boolean $hasSetter
     */
    public function setHasSetter($hasSetter) {
        $this->hasSetter = $hasSetter;
    }

    /**
     * Returns the isPublic value.
     *
     * @return boolean
     */
    public function isPublic() {
        return $this->public;
    }

    /**
     * Set the isPublic value.
     *
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic) {
        $this->public = $isPublic;
    }

    /**
     * Returns the isProtected value.
     *
     * @return boolean
     */
    public function isProtected() {
        return $this->protected;
    }

    /**
     * Set the isProtected value.
     *
     * @param boolean $isProtected
     */
    public function setIsProtected($isProtected) {
        $this->protected = $isProtected;
    }

    /**
     * Returns the isPrivate value.
     *
     * @return boolean
     */
    public function isPrivate() {
        return $this->private;
    }

    /**
     * Set the isPrivate value.
     *
     * @param boolean $isPrivate
     */
    public function setIsPrivate($isPrivate) {
        $this->private = $isPrivate;
    }

    /**
     * Set the property setter.
     * @return string
     */
    public function getSetter() {
        return $this->setter;
    }

    /**
     * Returns the property setter
     * @param string $setter
     */
    public function setSetter($setter) {
        $this->setter = $setter;
    }

    /**
     * Returns the property getter.
     * @return string
     */
    public function getGetter() {
        return $this->getter;
    }

    /**
     * Set the property getter.
     * @param string $getter
     */
    public function setGetter($getter) {
        $this->getter = $getter;
    }

    /**
     * @return boolean
     */
    public function isClassProperty() {
        return $this->isClassProperty;
    }

    /**
     * @param boolean $isClassProperty
     */
    public function setIsClassProperty($isClassProperty) {
        $this->isClassProperty = $isClassProperty;
    }
}

?>