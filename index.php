<?php
require 'Error/ErrorHandler.php';
$errorHandler = \MicroMir\Error\ErrorHandler::instance();
define('MICRO_DEVELOPMENT', true);
define('MICRO_ERROR_LOG', false);
define('MICRO_ERROR_TRACE_COLLAPSE', true);
define('MICRO_DIR', __DIR__);
define('WEB_DIR', __DIR__);

// **************** ПОРОЖДАЮЩИЕ ***********************************************

// Простая фабрика .............. Simple Factory
// Фабричный метод / Factory Method
//                include(__DIR__.'/Creational/factoryMethod/factoryMethod.php');
//.............................................................................
// Абстрактная фабрика / Abstract Factory (Kit / Инструментарий)
//                include(__DIR__.'/Creational/abstractFactory/abstractFactory.php');
//.............................................................................
// Статическая фабрика / Static Factory
//.............................................................................
// Одиночка / Singleton
//                include(__DIR__.'/Creational/singleton/singleton.php');
// Прототип ..................... Prototype
// Строитель .................... Builder
// Пул одиночек ................. Multiton
// Объектный пул ................ Pool
//
//
//****************** ПОВЕДЕНИЯ ***********************************************

// Стратегия / Strategy (Policy / Политика)
//              include(__DIR__.'/Behavioral/strategy/strategy.php');
//.............................................................................
// Наблюдатель / Observer (Dependents / подчинённые,Publish-Subscribe / издатель-подписчик)
//              include(__DIR__.'/Behavioral/strategy/observer.php');
//.............................................................................
// Интерпретатор / Interpreter
// Итератор ..................... Iterator
// Команда / Command (Action / Действие, Transaction / Транзакция)
//                include(__DIR__.'/Behavioral/command/command.php');
// Посетитель ................... Visitor
// Посредник .................... Mediator
// Состояние .................... State
// Хранитель .................... Memento
// Цепочка обязанностей ......... Chaine Of Responsibilities
// Шаблонный метод	.............. Template Method
// Объект Null .................. Null Object
// Спецификация ................. Specification
//
// ***************** СТРУКТУРНЫЕ **********************************************

// Адаптер / Adapter ( Wrapper / Обёртка)
//              include(__DIR__.'/Structural/adapter/adapter.php');
//.............................................................................
// Декоратор / Decorator ( Wrapper / Обёртка)
//              include(__DIR__.'/Structural/decorator/decorator.php');
//.............................................................................
// Заместитель .................. Proxy
// Компоновщик .................. Composite
// Мост ......................... Bridge
// Приспособленец ............... Flyewight
// Фасад / Facade
            include(__DIR__.'/Structural/facade/facade.php');
// Преобразователь данных ....... Data Mapper
// Внедрение зависимости ........ Dependency Injection
// Текучий интерфейс ............ Fluent Interface
// Реестр ....................... Registry




