<?php
require_once dirname(__DIR__) . '/interfaces/LoggerInterface.php';
require_once dirname(__DIR__) . '/interfaces/EventListenerInterface.php';
abstract class User implements EventListenerInterface
{
    protected int $id = 0;
    protected string $name = '';
    protected string $role = '';

    public abstract function getTextsToEdit(): void;

    public function attachEvent(string $nameMethod, string $callback): void
    {
        // TODO: Implement attachEvent() method.
    }

    public function detouchEvent(string $nameMethod): void
    {
        // TODO: Implement detouchEvent() method.
    }
}
