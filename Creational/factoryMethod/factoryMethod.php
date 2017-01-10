<?php

/**
 * ФАБРИЧНЫЙ МЕТОД определяет интерфейс для создания объекта, но оставляет подклассам
 * возможность решать, какой класс инстанцировать.
 *
 * Для чего нужен?
 * - чтобы вынести из класса инстанцирование объектов, которые используются этим классом
 * - скрыть от клиентского кода конкретные реализации инстанцируемых объектов, и вместе
 *   с этим предоставить возможность выбора обьект какой реализации инстанцировать.
 */

abstract class Product
{
    protected $tagOpen = "<div style='border: 2px solid black;
                        background-color: grey;
                        display: inline-block;";

    protected $tagClose = "</div>";

    protected $style = '';

    protected $number;

    function __construct(int $i)
    {
        $this->number = $i;
    }

    public function display()
    {
        echo $this->tagOpen.$this->style."'>".$this->number.$this->tagClose;
    }
}

abstract class Creator
{
    abstract function factoryMethod(int $i): Product;

    public function createComposition()
    {
        echo '<div style="border: 1px solid red; padding: 10px; display: inline-block;">';
        for ($i = 1; $i < 6; ++$i) {
            echo $this->factoryMethod($i)->display();
        }
        echo '</div>';
    }
}

class RectangleConcreteCreator extends Creator
{
    public function factoryMethod(int $number): Product
    {
        return new RectangleConcreteProduct($number);
    }
}

class CircleConcreteCreator extends Creator
{
    public function factoryMethod(int $number): Product
    {
        return new CircleConcreteProduct($number);
    }
}

class RectangleConcreteProduct extends Product
{
    protected $style = 'padding: 20px 30px;';
}

class CircleConcreteProduct extends Product
{
    protected $style = 'padding: 20px 20px; border-radius: 50%;';
}



(new RectangleConcreteCreator)->createComposition();
echo '<br>';
(new CircleConcreteCreator)->factoryMethod(11)->display();