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

abstract class AProduct
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

abstract class ACreator
{
    abstract function factoryMethod(int $i): AProduct;

    public function createComposition()
    {
        echo '<div style="border: 1px solid red; padding: 10px; display: inline-block;">';
        for ($i = 1; $i < 6; ++$i) {
            echo $this->factoryMethod($i)->display();
        }
        echo '</div>';
    }
}

class RectangleCreator extends ACreator
{
    public function factoryMethod(int $i): AProduct
    {
        return new RectangleProduct($i);
    }
}

class CircleCreator extends ACreator
{
    public function factoryMethod(int $i): AProduct
    {
        return new CircleProduct($i);
    }
}

class RectangleProduct extends AProduct
{
    protected $style = 'padding: 20px 30px;';
}

class CircleProduct extends AProduct
{
    protected $style = 'padding: 20px 20px; border-radius: 50%;';
}


/*********************** Client code ******************************/
(new RectangleCreator)->createComposition();
echo '<br>';
(new CircleCreator)->factoryMethod(11)->display();