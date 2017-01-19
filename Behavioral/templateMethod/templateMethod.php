<?php
/**
 * ШАБЛОННЫЙ МЕТОД задаёт "скелет" алгоритма в методе, оставляя определение реализации
 * некоторых шагов субклассам. Субклассы моогут переопределять некоторые части алгоритма
 * без изменения структуры.
 */
abstract class ATemplate
{
    //задаёт алгоритм
    public final function algorithm()
    {
        $this->step1();
        $this->step2();
        $this->step3();
        //изменение алгоритма при помощи перехватчика
        if ($this->step4()) {
            $this->step5();
        }
        $this->end();
    }

    //невозможно переопределить
    protected final function step1()
    {
        echo __CLASS__.'-'.__FUNCTION__.'<br>';
    }

    //невозможно переопределить
    protected final function step2()
    {
        echo __CLASS__.'-'.__FUNCTION__.'<br>';
    }

    //требуется определение в субклассе
    protected abstract function step3();

    //требуется определение в субклассе
    protected abstract function step4();

    //невозможно переопределить
    protected final function step5()
    {
        echo __CLASS__.'-'.__FUNCTION__.'<br>';
    }

    //можно переопределить если надо
    protected function end()
    {
        echo __CLASS__.'-'.'end<br>';
    }
}

class Template extends ATemplate
{
    protected function step3()
    {
        echo __CLASS__.'-'.__FUNCTION__.'<br>';
    }

    //перехватчик
    protected function step4()
    {
        echo __CLASS__.'-'.__FUNCTION__.'- перехватчик<br>';
        return false; //не выполнять step5()
    }
}

/*********************** Client code ******************************/
$template = new Template();
$template->algorithm();