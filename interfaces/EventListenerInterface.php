<?php
namespace interfaces;
interface EventListenerInterface
{
    public function attachEvent(string $nameMethod, string $callBack): void;

    public function detouchEvent(string $nameMethod): void;
}
