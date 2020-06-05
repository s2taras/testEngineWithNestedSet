<?php

namespace Task1\Model;

class FileModel implements FileModelInterface
{
    public const FILE = '/var/www/test/task1/users.txt';

    /**
     * @return array
     */
    public function getUsers(): array
    {
        $users = [];
        $handle = fopen(self::FILE, "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                list($username, $password) = explode(',', $line);
                $users[$username] = $password;
            }

            fclose($handle);
        }

        return $users;
    }
}