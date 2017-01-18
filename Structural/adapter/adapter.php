<?php
/**
 * АДАПТЕР преобразует тнтерфейс класса к другому интерфейсу, на который расчитан клиент. Адаптер
 * обеспечивает работу классов, невозможную в обычных условиях из-за несовместимости интерфейсов.
 */
 // Интерфейс, который использует клиент
interface Target
{
    function sum($a, $b);
}


//Класс с несовместимым интерфейсом
class Adaptee
{
    public function add($a, $b)
    {
        return $a + $b;
    }
}

/**
 * Адаптер ОБЪЕКТА использует композицию
 */
class ObjectAdapter implements Target
{
    private $adaptee;

    public function __construct()
    {
        $this->adaptee = new Adaptee;
    }

    public function sum($a, $b)
    {
        return $this->adaptee->add($a, $b);
    }
}

/**
 * Адаптер КАССА использует наследование
 */
trait TargetTrait
{
    public function sum($a, $b)
    {
        return $this->add($a, $b);
    }
}

class ClassAdapter extends Adaptee implements Target
{
    use TargetTrait;
}

/*********************** Client code ******************************/
class Client
{
    private $a = 2;

    private $b = 3;

    public function display(Target $target)
    {
        echo 'Result = '.$target->sum($this->a, $this->b);
    }
}

(new Client)->display(new ObjectAdapter);
echo '<br>';
(new Client)->display(new ClassAdapter);
