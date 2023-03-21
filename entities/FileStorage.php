<?php
namespace entities;
require_once 'Storage.php';
require_once 'TelegraphText.php';

use entities\Storage as Storage;
use entities\TelegraphText as TelegraphText;
use PHPMailer\PHPMailer\Exception;

class FileStorage extends Storage
{
    /**
     * @throws Exception
     */

    public function create(TelegraphText $obj): string
    {
            $stringDate = str_replace(':', '-', str_replace(' ', '_', date('Y-m-d H:i:s')));
            $slug = substr($obj->slug, 0, -4) . '_' . $stringDate;
            $number = 1;
            while (file_exists('./text/' . $slug . '.txt')) {
                $slug .= '_' . $number++;
            }
            $slug .= '.txt';
            $obj->slug = $slug;
            file_put_contents('./text/' . $obj->slug, serialize($obj));
            return $slug;
    }

    /**
     * @throws Exception
     */
    public function read($slug): TelegraphText
    {
        if (file_exists($slug)) {
            return unserialize(file_get_contents($slug));
        } else {
            throw new Exception('Объекта не существует.');
        }
    }

    public function update($slug, TelegraphText $obj): void
    {
        if (file_exists('./text/' . $slug)) {
            file_put_contents('./text/' . $slug, serialize($obj));
        } else throw new Exception('Объекта для обновления не существует.');
    }

    /**
     * @throws Exception
     */
    public function delete($slug): void
    {
        if (file_exists($slug)) {
            unlink($slug);
        } else throw new Exception('Объекта для удаления не существует.');
    }

    public function list(): array
    {
        $dirs = scandir('./text');
        $arrayDirs = [];
        array_shift($dirs);
        array_shift($dirs);
        foreach ($dirs as $dir) {
            array_push($arrayDirs, unserialize(file_get_contents('./text/' . $dir)));
        }
        return $arrayDirs;
    }
}
