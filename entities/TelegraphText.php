<?php
namespace entities;

use PHPMailer\PHPMailer\Exception;

class TelegraphText
{
    private string $text = '';
    private string $title = '';
    private string $author = '';
    private string $published = '';
    public string $slug = '';
    public FileStorage $objText;

    public function  __set(string $name, string $value) : void
    {
        if ($name == 'author') {
            if (strlen($value) < 120) {
                $this->$name = $value;
            } else throw new Exception('Количество символов превышает допустимого ограничения.');
        }
        if ($name == 'slug') {
            if (isset($value)) {
                if (preg_match('/^[\w|-]+$/', $value)) {
                    $this->$name = $value;
                }
//                else throw new Exception('Строка не соответствует формату');
            } else throw new Exception('Переменная slug не установлена');
        }
        if ($name == 'published') {
            if(!isset($value) || $value == '') {
                $this->$name = strtotime(date('Y-m-d H:i:s'));
            } else {
                if (strtotime($value) >= strtotime(date('Y-m-d H:i:s'))) {
                    $this->$name = $value;
                } else throw new Exception('Дата публикации должна быть позже текущей!' . strtotime(date('Y-m-d H:i:s')));
            }
        }

        if ($name == 'text') {
            define('MIN_VALUE', 1);
            define('MAX_VALUE', 500);
            if ( strlen($value) >= MIN_VALUE && strlen($value) <= MAX_VALUE ) {
                $this->$name = $value;
                $this->storeText();
            } else throw new Exception('Ошибка ограничения ввода количества символов из диапазона [1, 500]');
        }
    }

    public function __get($name) : string {
        if( $name == 'author' || $name == 'slug' || $name == 'published' ) {
            if ( isset($this->$name) ) {
                return $this->$name;
            } else throw new Exception('Переменная author не определена!');
        }
        if ( $name == 'text') {
            $this->loadText();
            return $this->$name;
        }
        return $this->$name;
    }
    public function __constructor(FileStorage $fileObject)
    {
        $this->objText = $fileObject;
    }

    private function storeText(): void
    {
        $content = [
            'title' => $this->title,
            'text' => $this->text,
            'author' => $this->author,
            'published' => $this->published
        ];

        if ( file_exists('./text/' . $this->slug) ) {
            file_put_contents('./text/' . $this->slug, serialize($content));
        } else throw new Exception('Файла для записи не существует');
    }

    private function loadText(): string
    {
        if ( file_exists('./text/' . $this->slug) ) {
            $content = unserialize(file_get_contents('./text/' . $this->slug));
            $this->title = $content['title'];
            $this->text = $content['text'];
            $this->author = $content['author'];
            $this->published = $content['published'];
            return $this->text;
        } else throw new Exception('Файла для считывания не существует');
    }
}
