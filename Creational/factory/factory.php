<?php
//Шаблон ФАБРИЧНЫЙ МЕТОД

interface Pizza
{
    function prepare();

    function bake();

    function cut();

    function box();

}


abstract class PizzaStore
{
    abstract function createPizza(string $type);

    public function orderPizza(string $type): Pizza
    {
        $pizza = $this->createPizza($type);
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();
        return $pizza;
    }
}

class MoscowPizzaStore extends PizzaStore
{
    function createPizza(string $type): Pizza
    {
        switch ($type) {
            case 'cheese':
                return new MoscowCheesePizza();
                break;
            case 'pepperoni':
                return new MoscowPepperoniPizza();
                break;
        }
    }
}

class KievPizzaStore extends PizzaStore
{
    function createPizza(string $type): Pizza
    {
        switch ($type) {
            case 'cheese':
                return new KievCheesePizza();
                break;
            case 'pepperoni':
                return new KievPepperoniPizza();
                break;
        }
    }
}

class KievCheesePizza implements Pizza
{
    public function prepare()
    {
        echo __CLASS__.'<br>'.__FUNCTION__.'<br>';
    }

    public function bake()
    {
        echo __FUNCTION__.'<br>';
    }

    public function cut()
    {
        echo __FUNCTION__.'<br>';
    }

    public function box()
    {
        echo __FUNCTION__.'<br>';
    }
}

class KievPepperoniPizza implements Pizza
{
    public function prepare()
    {
        echo __CLASS__.'<br>'.__FUNCTION__.'<br>';
    }

    public function bake()
    {
        echo __FUNCTION__.'<br>';
    }

    public function cut()
    {
        echo __FUNCTION__.'<br>';
    }

    public function box()
    {
        echo __FUNCTION__.'<br>';
    }
}

class MoscowCheesePizza implements Pizza
{
    public function prepare()
    {
        echo __CLASS__.'<br>'.__FUNCTION__.'<br>';
    }

    public function bake()
    {
        echo __FUNCTION__.'<br>';
    }

    public function cut()
    {
        echo __FUNCTION__.'<br>';
    }

    public function box()
    {
        echo __FUNCTION__.'<br>';
    }
}

class MoscowPepperoniPizza implements Pizza
{
    public function prepare()
    {
        echo __CLASS__.'<br>'.__FUNCTION__.'<br>';
    }

    public function bake()
    {
        echo __FUNCTION__.'<br>';
    }

    public function cut()
    {
        echo __FUNCTION__.'<br>';
    }

    public function box()
    {
        echo __FUNCTION__.'<br>';
    }
}

$store = new MoscowPizzaStore();
$store->orderPizza('cheese');
$store->orderPizza('pepperoni');
$store = new KievPizzaStore();
$store->orderPizza('cheese');
$store->orderPizza('pepperoni');
