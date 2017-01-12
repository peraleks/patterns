<?php
/**
 * ОДИНОЧКА гарантирует,что у класса есть только один экземпляр, и предоставляет к нему
 * глобальную точку доступа.
 */
class Singleton
{
    private static $instance;

    private $state;

    private function __construct() {} // защита от инстанцирования

//    private function __clone() {} // защита от клонирования

//    function __wakeup() { throw new \Exception("can't unserialize singleton"); } // защита от десериализации

    public static function getInstance()
    {
        self::$instance
            ?: self::$instance = new self;
        return self::$instance;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
}

function compare($obj1, $obj2)
{
    if ($obj1 === $obj2) echo 'один<br>'; else echo 'разные<br>';
}
$singleton1 = Singleton::getInstance();
$singleton2 = Singleton::getInstance();
$singleton1->setState(1000);
compare($singleton1, $singleton2);

$singleton3 = clone $singleton1;
compare($singleton1, $singleton3);

$singleton4 = unserialize(serialize($singleton1));
compare($singleton1, $singleton4);

//$singleton5 = new Singleton;
