<?php

/**
 * Class Constructor
 *
 * @property Object prototype
 */
class Constructor
{
    /**
     * @var callable
     */
    private $constructor;

    /**
     * @var Object
     */
    private $prototype;

    /**
     * @param callable $func
     * @param Object   $prototype
     */
    function __construct(callable $func, Object $prototype = null)
    {
        $this->constructor = $func;
        $this->prototype   = $prototype ?: new Object();
    }

    /**
     * @return callable
     */
    public function getConstructor()
    {
        return $this->constructor;
    }

    /**
     * @return Object
     */
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * @param Object $prototype
     */
    public function setPrototype(Object $prototype)
    {
        $this->prototype = $prototype;
    }

    public function __invoke()
    {
        return call_user_func_array($this->constructor, func_get_args());
    }

    public function __get($name)
    {
        if ('prototype' === $name) {
            return $this->getPrototype();
        }
        if ('constructor' === $name) {
            return $this->getConstructor();
        }

        throw new Exception(sprintf('Property "%s" is undefined.', $name));
    }

    public function __set($name, $value)
    {
        if ('prototype' === $name) {
            $this->setPrototype($value);
        }
    }
}
