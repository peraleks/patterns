<?php
// Шаблон ДЕКОРАТОР
declare(strict_types=1);

abstract class Beverage
{
    /**
     * @var string описание напитка
     */
    protected $description;

    protected $size;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize(int $size)
    {
        $this->size = $size;
    }

    public abstract function cost(): float;
}

abstract class CondimentDecorator extends Beverage
{

}

class Coffee extends Beverage
{
    function __construct()
    {
        $this->description = 'Лучший кофе ';
    }

    public function cost(): float
    {
       return 0.33 * $this->size;
    }
}

class Tea extends Beverage
{
    function __construct()
    {
        $this->description = 'Чёрный чай ';
    }

    public function cost(): float
    {
        return 0.22 * $this->size;
    }
}

class Milk extends CondimentDecorator
{
    public $beverage;

    function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    public function getDescription(): string
    {
        return $this->beverage->getDescription().' + Молоко';
    }

    public function cost(): float
    {
        return 0.5 * $this->getSize() + $this->beverage->cost();
    }

    public function setSize(int $size)
    {
        $this->beverage->setSize($size);
    }

    public function getSize()
    {
        return $this->beverage->getSize();
    }

}

class Sugar extends CondimentDecorator
{
    public $beverage;

    function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    public function getDescription(): string
    {
        return $this->beverage->getDescription().' + Сахар';
    }

    public function cost(): float
    {
        return 0.3 * $this->getSize() + $this->beverage->cost();
    }

    public function setSize(int $size)
    {
        $this->beverage->setSize($size);
    }

    public function getSize()
    {
        return $this->beverage->getSize();
    }
}

$coffee = new Coffee();
$coffee->setSize(1);
echo $coffee->getDescription().' '.$coffee->cost().'<br>';

$tea = new Tea();
$tea->setSize(1);
$tea = new Milk($tea);
$tea = new Milk($tea);
$tea = new Sugar($tea);
echo $tea->getDescription().' '.$tea->cost().'<br>';
