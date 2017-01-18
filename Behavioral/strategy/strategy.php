<?php
/**
 * Стратегия (Strategy) — поведенческий шаблон проектирования,
 * предназначенный для определения семейства алгоритмов, инкапсуляции каждого из них
 * и обеспечения их взаимозаменяемости. Это позволяет выбирать алгоритм путём определения
 * соответствующего класса. Шаблон Strategy позволяет менять выбранный алгоритм
 * независимо от объектов-клиентов, которые его используют.
 */

/**
 * Абстрактный класс или интерфейс DivideStrategy
 * Определяет семейство алгоритмов разделения строки на части
 */
interface DivideStrategy
{
    function divide(string $string): array;
}
/**
 * Абстрактный класс или интерфейс SortStrategy
 * Определяет семейство алгоритмов сортировки
 */
interface SortStrategy
{
    function sort(array $arr): array;
}
/**
 * ConcreteStrategy WordStrategy
 * Реализует разделение строки на слова
 */
class WordStrategy implements DivideStrategy
{
    public function divide(string $string): array
    {
        return explode(' ', $string);
    }
}
/**
 * ConcreteStrategy SymbolStrategy
 * Реализует разделение строки на символы
 */
class SymbolStrategy implements DivideStrategy
{
    public function divide(string $string): array
    {
        $arr = [];
        for ($i = 0; $i < mb_strlen($string); ++$i) {
            $arr[] = mb_substr($string, $i, 1);
        }
        return $arr;
    }
}
/**
 * ConcreteStrategy AscStrategy
 * Реализует сортировку А-Я
 */
class AscStrategy implements SortStrategy
{
    public function sort(array $arr): array
    {
        sort($arr);
        return $arr;
    }
}
/**
 * ConcreteStrategy DscStrategy
 * Реализует сортировку Я-А
 */
class DscStrategy implements SortStrategy
{
    public function sort(array $arr): array
    {
        sort($arr);
        return array_reverse($arr);
    }
}

/**
 * Context TextHandlerContext
 *
 * Класс Context использует конкретные классы ConcreteStrategy посредством ссылки
 * на конкретный тип абстрактного класса Strategy. Классы Strategy и Context взаимодействуют
 * с целью реализации выбранного алгоритма (в некоторых случаях классу Strategy требуется
 * посылать запросы классу Context). Класс Context пересылает классу Strategy запрос,
 * поступивший от его класса-клиента.
 */
class TextHandlerContext
{
    protected $divideStrategy;

    protected $sortStrategy;

    function __construct(DivideStrategy $divideStrategy, SortStrategy $sortStrategy)
    {
        $this->divideStrategy = $divideStrategy;
        $this->sortStrategy = $sortStrategy;
    }

    function handle(string $string = ''): string
    {
        return implode("\n", $this->sortStrategy->sort($this->divideStrategy->divide($string)));
    }
}

/*********************** Client code ******************************/
if (isset($_POST['divide'])) {

//выбираем алгоритм разбиения
    switch ($_POST['divide']) {
        case 'word':
            $divideStrategy = new WordStrategy;
            break;
        case 'symbol':
            $divideStrategy = new SymbolStrategy;
            break;
    }

// выбираем алгоритм сортировки
    switch ($_POST['sort']) {
        case 'asc':
            $sortStrategy = new AscStrategy;
            break;
        case 'dsc':
            $sortStrategy = new DscStrategy;
            break;
    }

    $textHandler = new TextHandlerContext($divideStrategy, $sortStrategy);
    $result = $textHandler->handle($area = $_POST['area']);
} else {
    $result = '';
    $area = '';
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Strategy</title>
</head>
<body>
<h2>Стратегия (Strategy)</h2>
<form action="" method="post">
    <textarea cols="50" rows="5" name="area"><?= $area ?></textarea>
    <br>
    <select name="divide">
        <option value="word">По словам</option>
        <option value="symbol">По символам</option>
    </select>
    <select name="sort">
        <option value="asc">А->Я</option>
        <option value="dsc">Я->А</option>
    </select>
    <br>
    <input type="submit" value="Обработать">
    <br>
    <textarea cols="15" rows="30" name="result"><?= $result ?></textarea>
</form>
</body>
</html>