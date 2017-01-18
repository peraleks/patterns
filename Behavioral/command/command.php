<?php

/**
 * КОМАНДА инкапсулирует запрос как объект, позволяя тем самым задавать параметры клиентов для обработки
 * соответствующих запросов, ставить запросы в очередь иди протоколировать их, а также
 * поддерживать отмену операций.
 */
abstract class Command
{
    protected $circle;

    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    abstract public function execute();
}


class Enlarge extends Command
{
    public function execute()
    {
        $this->circle->enlarge();
    }

    public function undo()
    {
        $this->circle->reduce();
    }
}

class Reduce extends Command
{
    public function execute()
    {
        $this->circle->reduce();
    }

    public function undo()
    {
        $this->circle->enlarge();
    }
}


class Circle
{
    private $size = 10;

    public function getSize()
    {
        return $this->size;
    }

    public function enlarge()
    {
        $this->size += 10;
    }

    public function reduce()
    {
        $this->size -= 10;
    }

}

class Invoker
{
    private $index = 0;

    private $commands = [];

    public function setCommand(Command $command)
    {
        $this->commands[$this->index] = $command;
        $command->execute();
        $this->index += 1;
        if (count($this->commands) > $this->index) {
            $this->commands = array_slice($this->commands, 0, $this->index);
        }
    }

    public function undo()
    {
        if ($this->index >= 1) {
            $this->commands[$this->index - 1]->undo();
            $this->index -= 1;
        }
    }

    public function redo()
    {
        if ($this->index < count($this->commands)) {
            $this->commands[($this->index += 1) -1]->execute();
        }
    }
}

/*********************** Client code ******************************/
class Serializer
{
    public static function save($obj)
    {
        file_put_contents(__DIR__.'/'.get_class($obj), serialize($obj));
    }

    public static function get($name)
    {
        $file = __DIR__.'/'.$name;
        if (file_exists($file)) {
            return unserialize(file_get_contents($file));
        } else {
            return new $name;
        }
    }
}

class Client
{
    private $circle;

    private $invoker;

    public function __construct()
    {
        $this->circle = new Circle;
        $this->invoker = new Invoker;
    }

    public function run()
    {
        if (isset($_POST['btn'])) $this->invoker->setCommand($this->choice());
        if (isset($_POST['undo'])) $this->invoker->undo();
        if (isset($_POST['redo'])) $this->invoker->redo();
    }

    private function choice()
    {
        switch ($_POST['btn']) {
            case '+': return new Enlarge($this->circle);
            case '-': return new Reduce($this->circle);
        }
    }

    public function getSize()
    {
        return $this->circle->getSize();
    }
}

$client = Serializer::get(Client::class);
$client->run();
Serializer::save($client);

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Command</title>
</head>
<body>
<form action="" method="post">
    <button type="submit" value="+" name="btn">+</button>
    <button type="submit" value="-" name="btn">-</button>
    <button type="submit" value="undo" name="undo"><</button>
    <button type="submit" value="redo" name="redo">></button>
</form>
<br><br>
<div style="display: inline-block;
        border: 1px solid black;
        border-radius: 50%;
        padding: <?= $client->getSize() ?>px"><?= $client->getSize() ?>
</div>
</body>
</html>
