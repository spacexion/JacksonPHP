<?php

namespace IonXLab\JacksonPhp\annotation;


class VarType extends JacksonAnnotation {

    private $description;

    public function __construct() {
        parent::__construct("VarType");
    }

    /**
     * Returns the description value.
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set the description value.
     *
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

}

?>