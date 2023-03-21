<?php
namespace interfaces;
interface LoggerInterface
{
    public function logMessage(string $error): void;

    public function lastMessage(int $countMessage): array;
}
