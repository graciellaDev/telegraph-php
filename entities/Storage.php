<?php
namespace entities;
require_once dirname(__DIR__) . '/interfaces/LoggerInterface.php';
require_once dirname(__DIR__) . '/interfaces/EventListenerInterface.php';
require_once 'TelegraphText.php';

use interfaces\{ EventListenerInterface as EventListenerInterface, LoggerInterface as LoggerInterface };
use entities\TelegraphText as TelegraphText;
abstract class Storage implements LoggerInterface, EventListenerInterface
{
    public abstract function create(TelegraphText $obj): string;

    public abstract function read(string $slug): TelegraphText;

    public abstract function update(string $slug, TelegraphText $obj): void;

    public abstract function delete(string $slug): void;

    public abstract function list(): array;

    public function logMessage(string $error): void
    {
        // TODO: Implement logMessage() method.
    }

    public function lastMessage(int $countMessage): array
    {
        return [];
        // TODO: Implement lasMessage() method.
    }

    public function attachEvent(string $nameMethod, string $callback): void
    {
        // TODO: Implement attachEvent() method.
    }

    public function detouchEvent(string $nameMethod): void
    {
        // TODO: Implement detouchEvent() method.
    }
}
