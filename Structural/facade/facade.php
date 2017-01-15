<?php
/**
 * ФАСАД предоставляет унифицированный интерфейс вместо набора интерфейсов некоторой подсистемы.
 * Фасад определяет интерфейс более высокого уровня, который упрощает использование подсистемы.
 */
class Egg
{
    private $broken = false;

    public function break()
    {
        if (!$this->broken) {
            $this->broken = true;
            echo 'яйцо разбито<br>';
        } else {
            echo 'нельзя разбить яйцо два раза<br>';
        }
    }

    public function hasBroken()
    {
        return $this->broken;
    }
}

class Salt
{
    private $amount = 0;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}

class Pan
{
    private $fryMinutes = 0;

    private $salt = 0;

    private $eggs = [];

    private $degree = 20;

    public function heat($degree)
    {
        $this->degree +=$degree;

        echo "сковорода разогрета до ".$this->degree.' град. <br>';
    }

    public function putEgg(Egg $egg)
    {
        if ($this->degree < 150) {
            echo 'разогрейте сковороду до 150 градусов<br>';
            return;
        }
        if ($egg->hasBroken()) {
            $this->eggs[] = $egg;
            echo 'в сковороде '.count($this->eggs).' яиц<br>';
        } else {
            echo 'рaзбейте яйцо<br>';
        }
    }

    public function putSalt(Salt $salt)
    {
        if (count($this->eggs) == 0) {
            echo 'солить нечего - положите яйца<br>';
            return;
        }
        $this->salt += $salt->getAmount();
        echo "в сковороде $this->salt грамм соли<br>";
    }

    public function fry($min)
    {
        if (count($this->eggs) > 0) {
            $this->fryMinutes += $min;
            echo 'жарим уже '.$this->fryMinutes.' минут <br>';
        }
    }

    public function takeEggs()
    {
        if ($this->fryMinutes < 10) {
            echo 'ещё не готово<br>';
            return;
        }
        if ($this->salt <= 0) {
            $salt = ' несолёная';
        } elseif($this->salt > 5) {
            $salt = ' пересоленная';
        } else $salt = '';

        echo 'Приготовлена'.$salt.' яичница из '.count($this->eggs).' яиц<br>';
        $this->salt = 0;
        $this->eggs = [];
        $this->fryMinutes = 0;
        $this->degree = 20;
    }
}

class EggFacade
{
    static public function fryEggs(int $eggs)
    {
        $egg = new Egg;
        $pan = new Pan;
        $salt = new Salt(3);
        $pan->heat(130);
        $egg->break();
        for ($i = 0; $i < $eggs; ++$i) {
            $pan->putEgg($egg);
        }
        $pan->putSalt($salt);
        $pan->fry(10);
        $pan->takeEggs();
    }
}

// готовим яичницу вручную
$egg = new Egg;
$pan = new Pan;
$pan->putEgg($egg);
$pan->heat(100);
$pan->heat(50);
$pan->putEgg($egg);
$egg->break();
$pan->putEgg($egg);
$pan->putEgg($egg);
$pan->putEgg($egg);
$pan->fry(5);
$pan->takeEggs();
$pan->fry(5);
$pan->takeEggs();
$salt = new Salt(2);
$pan->putSalt($salt);
$pan->putEgg($egg);
$pan->heat(150);
$pan->putEgg($egg);
$pan->putEgg($egg);
$pan->putEgg($egg);
$pan->putEgg($egg);
$pan->putSalt($salt);
$pan->fry(10);
$pan->takeEggs();

echo '<br><br>';
// готовим яичницу при помощи фасада
EggFacade::fryEggs(5);