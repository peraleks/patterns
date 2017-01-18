<?php

/**
 * НАБЛЮДАТЕЛЬ определяет отношение "один-ко-многим" между объектами таким образом,
 * что при изменении состояния одного объекта происходит автоматическое оповещение
 * и обновление всех зависимых объектов.
 */

abstract class Subject
{
    private $observers = [];

    public function addObserver(Observer $o)
    {
        if (!in_array($o, $this->observers)) {
            $this->observers[] = $o;
            $o->setSubject($this);
        }
    }

    public function removeObserver(Observer $o)
    {
        foreach ($this->observers as $key => $observer) {
            if ($observer == $o) {
                unset($this->observers[$key]);
                break;
            }
        }
    }

    public function notifyObservers()
    {
        array_walk($this->observers, function($item) {
            $item->update();
        });
    }
}

abstract class Observer
{
    protected $subject;

    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function endObservation()
    {
        if ($this->subject instanceof Subject) {
            $this->subject->removeObserver($this);
        }
    }

    public function startObservation(Subject $subject)
    {
        $this->subject = $subject;
        $this->subject->addObserver($this);
    }

    abstract function update();
}


class ConcreteSubject extends Subject
{
    private $state1;

    private $state2;

    private $state3;

    public function setState($state1, $state2, $state3)
    {
        $this->state1 = $state1;
        $this->state2 = $state2;
        $this->state3 = $state3;
        $this->notifyObservers();
    }

    public function getState1()
    {
        return $this->state1;
    }

    public function getState2()
    {
        return $this->state2;
    }

    public function getState3()
    {
        return $this->state3;
    }

}

class ConcreteObserver1 extends Observer
{
    protected $state;

    public function update()
    {
        if ($this->subject instanceof ConcreteSubject) {
            $this->doUpdate();
        }
    }

    protected function doUpdate()
    {
        $this->state = $this->subject->getState1();
        echo __CLASS__.' - '.$this->state.'<br>';
    }
}

class ConcreteObserver2 extends ConcreteObserver1
{
    public function doUpdate()
    {
        $this->state = $this->subject->getState2();
        echo __CLASS__.' - '.$this->state.'<br>';
    }
}

class ConcreteObserver3 extends ConcreteObserver1
{
    public function doUpdate()
    {
        $this->state = $this->subject->getState3();
        echo __CLASS__.' - '.$this->state.'<br>';
    }
}

/*********************** Client code ******************************/

$subject = new ConcreteSubject;
$obs1 = new ConcreteObserver1;
$obs2 = new ConcreteObserver2;
$obs3 = new ConcreteObserver3;
$subject->addObserver($obs1);
$subject->addObserver($obs2);
$subject->addObserver($obs3);
$subject->setState(0,0,0);
$subject->setState(0,2,8);
$subject->removeObserver($obs1);
$subject->setState(5,2,8);
$obs2->endObservation();
$subject->setState(1,1,1);
$obs1->startObservation($subject);
$obs2->startObservation($subject);
$obs3->endObservation();
$subject->setState(7,7,7);
