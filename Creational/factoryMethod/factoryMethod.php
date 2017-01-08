<?php

/**
 * ФАБРИЧНЫЙ МЕТОД определяет интерфейс для создания объекта, но оставляет подклассам
 * возможность решать, какой класс инстанцировать. Фабричный метод позволяет классу
 * делегировать инстанцирование подклассам.
 *
 * Применимость.
 * Используйте паттерн когда
 * - классу заранее неизвестно, объекты каких классов ему нужно создавать;
 * - класс спроэктирован так, чтобы объекты, которые он создаёт, специфицировались подклассами;
 * - класс делегирует свои обязанности одному из нескольких вспомогательных подклассов,
 *   и вы планируете локализовать знание о том, какой класс принимает эти обязанности на себя.
 */

abstract class Product
{
    abstract function display();
}

abstract class Creator
{
    abstract function factoryMethod(string $type);
}

class ConcreteCreatorRectangle extends Creator
{
    function factoryMethod(string $type): Product
    {
        switch ($type) {
            case 'shaded':
                return new ConcreteProductShadedRectangle();
                break;
            case 'contour':
                return new ConcreteProductContourRectangle();
                break;
        }
    }
}

class ConcreteCreatorCircle extends Creator
{
    function factoryMethod(string $type): Product
    {
        switch ($type) {
            case 'shaded':
                return new ConcreteProductShadedCircle();
                break;
            case 'contour':
                return new ConcreteProductContourCircle();
                break;
        }
    }
}

class ConcreteProductShadedRectangle extends Product
{
    public function display()
    {
        echo "<div style='
                border: 2px solid black;
                padding: 20px 30px;
                background-color: #9b9b9b;
                display: inline-block;
                '></div>";
    }
}

class ConcreteProductContourRectangle extends Product
{
    public function display()
    {
        echo "<div style='
                border: 2px solid;
                padding: 20px 30px;
                display: inline-block;
                '></div>";
    }
}

class ConcreteProductShadedCircle extends Product
{
    public function display()
    {
        echo "<div style='
                border: 2px solid;
                padding: 20px 20px;
                border-radius: 50%;
                background-color: #9b9b9b;
                display: inline-block;
                '></div>";
    }
}

class ConcreteProductContourCircle extends Product
{
    public function display()
    {
        echo "<div style='
                border: 2px solid;
                padding: 20px 20px;
                border-radius: 50%;
                display: inline-block;
                '></div>";
    }
}

$figure = [];
$rectangle = new ConcreteCreatorRectangle();
$circle = new ConcreteCreatorCircle();

$figure[] = $rectangle->factoryMethod('shaded');
$figure[] = $circle->factoryMethod('contour');
$figure[] = $circle->factoryMethod('shaded');
$figure[] = $rectangle->factoryMethod('contour');
$figure[] = $circle->factoryMethod('shaded');
$figure[] = $circle->factoryMethod('contour');

foreach ($figure as $figureValue) {
    $figureValue->display();
}
