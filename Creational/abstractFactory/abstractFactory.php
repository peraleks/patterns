<?php

/**
 * АБСТРАКТНАЯ ФАБРИКА предоставляет интерфейс для создания взаимосвязанных или
 *                      взаимозависимых объектов, не специфицируя их конкретных классов.
 * Используется когда
 *   - система не должна зависеть от того, как создаются, компонуются и предсавляются
 *     входящие в неё объекты;
 *   - входящие в семейство взаимосвязанные обхекты должны использоваться
 *     вместе и вам необходимо обеспечить выполнение этого ограничения;
 *   - система должна конфигурироваться одним из семейств составляющих её объектов;
 *   - вы хотите предоставить библиотеку объектов, раскрывая только их интерфейсы,
 *     но не реализацию.
 */

interface AbstractFactory
{
    function createBox(Text $text);

    function createText(string $string);
}

class ErrorConcreteFactory implements AbstractFactory
{
    function createBox(Text $text)
    {
        return new ErrorBox($text);
    }

    function createText(string $string)
    {
        return new ErrorText($string);
    }
}

class NoticeConcreteFactory implements AbstractFactory
{
    function createBox(Text $text)
    {
        return new NoticeBox($text);
    }

    function createText(string $string)
    {
        return new NoticeText($string);
    }
}

interface Box
{
    function __construct(Text $text);

    function getBox(): string ;
}

/**
 * Определяем интерфейс через абстрактный класс для сокращения повторяющегося кода.
 */
abstract class Text
{
    private $string;

    function __construct(string $string)
    {
        $this->string = $this->convert($string);
    }

    protected function convert(string $string)
    {
        return mb_strtoupper($string);
    }

    public function getText(): string
    {
        return $this->string;
    }
}

class ErrorBox implements Box
{
    private $box;

    function __construct(Text $text)
    {
        $this->box = sprintf(
            '<div style="
                background-color: red;
                border-radius: 5px;
                display: inline-block;
                padding: 5px;
                text-align: center;
                color: white;
                ">Error:<br>%s</div>', $text->getText()
        );
    }

    public function getBox(): string
    {
        return $this->box;
    }
}

class ErrorText extends Text
{
}

class NoticeBox implements Box
{
    private $box;

    function __construct(Text $text)
    {
        $this->box = sprintf(
            '<div style="
                border: 1px solid grey;
                background-color: yellow;
                display: inline-block;
                border-radius: 5px;
                padding: 5px;
                text-align: center;
                ">Notice:<br>%s</div>', $text->getText()
        );
    }

    public function getBox(): string
    {
        return $this->box;
    }
}

class NoticeText extends Text
{
    protected function convert(string $string)
    {
        return mb_strtolower($string);
    }
}

/*********************** Client code ******************************/
class Alert
{
    static function display(AbstractFactory $factory, string $string)
    {
        echo ($factory->createBox($factory->createText($string)))->getBox();
    }
}

Alert::display(new NoticeConcreteFactory, 'Текст сообщения');
echo '<br><br>';
Alert::display(new ErrorConcreteFactory, 'Текст сообщения');