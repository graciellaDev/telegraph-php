<?php
abstract class View
{
    public abstract function displayTextById(int $id): void;

    public abstract function displayTextByUrl(string $url): void;
}
