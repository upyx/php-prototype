<?php

/**
 * Class Object
 *
 * @property Object prototype
 */
class Object
{
    /**
     * @var Object
     */
    public static $_currentObject_;

    private $_prototype_ = null;
    private $_properties_ = [];

    function __construct($constructor = null, array $arguments = [])
    {
        if ($constructor instanceof Constructor) {
            $this->_prototype_     = $constructor->prototype;
            self::$_currentObject_ = $this;
            call_user_func_array($constructor, $arguments);
        } elseif ($constructor instanceof self) {
            $this->_prototype_ = $constructor;
        } elseif (is_callable($constructor)) {
            self::$_currentObject_ = $this;
            call_user_func_array($constructor, $arguments);
        } elseif (null !== $constructor) {
            throw new Exception("Constructor argument's type is invalid.");
        }
    }

    /**
     * @return null|Object
     */
    public function getPrototype()
    {
        return $this->_prototype_;
    }

    /**
     * @param null|Object $prototype
     */
    public function setPrototype(Object $prototype = null)
    {
        $this->_prototype_ = $prototype;
    }

    public function __call($name, $arguments)
    {
        $function = $this->$name;
        if (!is_callable($function)) {
            throw new Exception(sprintf('Property "%s" is not a function.', $name));
        }

        self::$_currentObject_ = $this;
        return call_user_func_array($function, $arguments);
    }

    public function __get($name)
    {
        if ('prototype' === $name) {
            return $this->getPrototype();
        }

        if (isset($this->_properties_[$name])) {
            return $this->_properties_[$name];
        }

        if (null !== $this->_prototype_) {
            return $this->_prototype_->$name;
        }

        throw new Exception(sprintf('Property "%s" is undefined.', $name));
    }

    public function __set($name, $value)
    {
        if ('prototype' === $name) {
            $this->setPrototype($value);
        }

        $this->_properties_[$name] = $value;
    }
}
