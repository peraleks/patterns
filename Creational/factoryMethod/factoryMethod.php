<?php

/**
 * ФАБРИЧНЫЙ МЕТОД определяет интерфейс для создания объекта, но оставляет подклассам
 * возможность решать, какой класс инстанцировать.
 *
 * Для чего нужен?
 * - чтобы вынести из класса инстанцирование объектов, которые используются этим классом
 * - скрыть от клиентского кода конкретные реализации инстанцируемых объектов, и вместе
 *   с этим предоставить возможность выбора обьект какщй реализации инстанцировать.
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

class ConcreteCreatorRectangle extends Creator
{
    public function factoryMethod(int $number): Product
    {
        return new ConcreteProductRectangle($number);
    }
}

class ConcreteCreatorCircle extends Creator
{
    public function factoryMethod(int $number): Product
    {
        return new ConcreteProductCircle($number);
    }
}

class ConcreteProductRectangle extends Product
{
    protected $style = 'padding: 20px 30px;';
}

class ConcreteProductCircle extends Product
{
    protected $style = 'padding: 20px 30px; border-radius: 50%;';
}

/**
 * Класс не имеет прямого отношения к паттерну, а лишь демонстрирует использование интерфейса Creator.
 */
class CompositionBuilder
{
    static function build(Creator $creator)
    {
        $creator->createComposition();
    }
}

CompositionBuilder::build(new ConcreteCreatorRectangle);
echo '<br>';
CompositionBuilder::build(new ConcreteCreatorCircle);