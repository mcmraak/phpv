#!/usr/bin/env php
<?php

class PHPV
{
    public $original_version, $selected_version;

    function __construct($argv)
    {
        $allowed_versions = ['7.4', '8.0', '8.1'];
        $new_version = @$argv[1];

        if(!in_array($new_version, $allowed_versions)) {
            echo "Версии php = $new_version нет в списке версий\n";
            die;
        }

        $this->selected_version = $new_version;
        if(!$this->selected_version) {
            echo "Не выбрана версия\n";
            die;
        }
        $this->getPhpOriginalVersion();
        $this->switchPhp();
    }

    function help()
    {
        echo "PHP version - Программа для переключения версии php (Alex Blaze)\n";
        echo "Пример: php_v 8.1\n";
        die;
    }

    function getPhpOriginalVersion()
    {
        exec('php -v', $output);
        preg_match('/PHP (\d\.\d)\.\d/', $output[0], $matches);
        $this->original_version = $matches[1];
    }

    function switchPhp()
    {
        $old = $this->original_version;
        $new = $this->selected_version;
        $command = "sudo a2dismod php$old && sudo a2enmod php$new && sudo systemctl restart apache2";
        exec($command);
        echo "Переключение версии php $old > $new\n";
    }
}

new PHPV($argv);