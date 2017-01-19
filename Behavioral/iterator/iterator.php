<?php
/**
 * ИТЕРАТОР предоставляет способ последовательного доступа ко всем элементам
 * составного объекта, не раскрывая его внутреннего представления.
 */
interface IIterator
{
    function hasNext();

    function next();

    function remove();

    function reset();
}

class MyIterator implements IIterator
{
    protected $items;

    private $position = 0;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function hasNext()
    {
        if ($this->position >= count($this->items) || count($this->items) == 0) return false;
        return true;
    }

    //небезопасный метод
    public function next()
    {
        $item = $this->items[$this->position];
        ++$this->position;
        return $item;
    }

    public function remove()
    {
        if ($this->position == 0) throw new \Exception('The cursor is not set');
        for ($i = $this->position - 1; $i < (count($this->items) - 1); ++$i) {
            $this->items[$i] = $this->items[$i + 1];
        }
        unset($this->items[count($this->items) - 1]);
    }

    public function reset()
    {
        $this->position = 0;
    }
}

interface IAggregate
{
    function createIterator();
}



class Aggregate implements IAggregate
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function createIterator()
    {
        return new MyIterator($this->items);
    }
}


/*********************** Client code ******************************/
class Printer
{
    public static function display(IIterator $iterator)
    {
        while ($iterator->hasNext()) {
            echo $iterator->next();
        }
    }
}

$agg = new Aggregate([1,2,3,4,5]);
$iterator = $agg->createIterator();
Printer::display($iterator);
echo '<br>';

$iterator->reset();
echo $iterator->next();
echo '<br>';

$iterator->remove();
var_dump($iterator);
echo '<br>';
echo '<br>';


//SPL итератор PHP
$agg = new ArrayObject([1,2,3,4,5]);
var_dump($agg);
$iterator = $agg->getIterator();
echo $iterator->current();
echo '<br>';
$iterator->next();
echo $iterator->current();
echo '<br>';
$iterator->next();
$iterator->next();
$iterator->next();
$iterator->next();
$iterator->next();
var_dump($iterator->valid());
echo '<br>';
echo $agg->serialize();

