<?php
/**
 * ДЕКОРАТОР предназначен для динамического подключения дополнительного поведения к объекту.
 * Предоставляет гибкую альтернативу практике создания подклассов с целью расширения функциональности.
 *
 * Задача
 * Объект, который предполагается использовать, выполняет основные функции.
 * Однако может потребоваться добавить к нему некоторую дополнительную функциональность,
 * которая будет выполняться до, после или даже вместо основной функциональности объекта.
 *
 * Реализация
 * Создается абстрактный класс, представляющий как исходный класс, так и новые, добавляемые в класс функции.
 * В классах-декораторах новые функции вызываются в требуемой последовательности
 * — до или после вызова последующего объекта.
 * При желании остаётся возможность использовать исходный класс (без расширения функциональности),
 * если на его объект сохранилась ссылка.
 */

abstract class Component
{
    abstract function operation(): string;
}

class ConcreteComponent extends Component
{
    public function operation(): string
    {
        return 'word';
    }
}

abstract class Decorator extends Component
{
    protected $component;

    function __construct(Component $component)
    {
        $this->component = $component;
    }
}

class ConcreteDecoratorColor extends Decorator
{
    public function operation(): string
    {
        return '<span style="color:red">'.$this->component->operation().'</span>';
    }
}

class ConcreteDecoratorBorder extends Decorator
{
    protected $color = "blue";

    public function operation(): string
    {
        return "<div style=\"border: 4px solid $this->color; display: inline-block\">"
            .$this->component->operation().
            '</div>';
    }

    public function setColor(string $color)
    {
        $this->color = $color;
    }
}

$component = new ConcreteComponent();
echo $component->operation().'<br>';
$component= new ConcreteDecoratorColor($component);
echo $component->operation().'<br>';
$component = new ConcreteDecoratorBorder($component);
echo $component->operation().'<br>';
($component = new ConcreteDecoratorBorder($component))->setColor('red');
echo $component->operation().'<br>';
$component = new ConcreteDecoratorBorder($component);
$component->setColor('yellow');
echo $component->operation().'<br>';
