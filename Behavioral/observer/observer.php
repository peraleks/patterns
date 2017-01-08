<?php

/**
 * НАБЛЮДАТЕЛЬ определяет отношение "один-ко-многим" между объектами таким образом,
 * что при изменении состояния одного объекта происходит автоматическое оповещение
 * и обновление всех зависимых объектов.
 */

interface Subject
{
    function addObserver(Observer $o);
    function removeObserver(Observer $o);
    function notifyObserver(int $state);
}

interface Observer
{
    function handleEvent(int $state);
}


class ConcreteSubject implements SubjectObserver
{
    private $observers = [];

    private $state;

    public function addObserver(Observer $o)
    {
        if (!in_array($o, $this->observers)) {
            $this->observers[] = $o;
        }
    }

    public function removeObserver(Observer $o)
    {
        array_walk($this->observers, function($item, $key) use ($o) {
            if ($item == $o) unset($this->observers[$key]);
        });
    }

    public function notifyObserver(int $state)
    {
        $this->state = $state;
        array_walk($this->observers, function($item) use ($state) {
            $item->handleEvent($state);
        });
    }
}

class ConcreteObserver implements Observer
{
    private $offset;

    private $name;

    function __construct(string $name, int $offset = 0)
    {
        $this->name = $name;
        $this->offset = $offset;
    }

    public function handleEvent(int $state)
    {
        $this->offset += $state;
        $this->display();
    }

    public function display()
    {
        echo $this->name.' '.$this->offset.'<br>';
    }
}

$subject = new ConcreteSubject();
$obs1 = new ConcreteObserver('obs1');
$obs2 = new ConcreteObserver('obs2');
$obs3 = new ConcreteObserver('obs3');
$subject->addObserver($obs1);
$subject->addObserver($obs2);
$subject->notifyObserver(5);
$subject->removeObserver($obs1);
$subject->removeObserver($obs2);
$subject->addObserver($obs3);
$subject->notifyObserver(5);
