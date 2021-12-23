#!/usr/bin/env php
<?php

class PHPV
{
    public $allowed_versions = ['7.4', '8.0', '8.1'];
    public $selected_version;

    function __construct($argv)
    {
        $new_version = @$argv[1];

        if(!in_array($new_version, $this->allowed_versions)) {
            echo "Версии php = $new_version нет в списке версий\n";
            die;
        }

        $this->selected_version = $new_version;
        if(!$this->selected_version) {
            echo "Не выбрана версия\n";
            die;
        }

        $this->switchPhp();
    }

    function help()
    {
        echo "PHP version - Программа для переключения версии php (Alex Blaze)\n";
        echo "Пример: php_v 8.1\n";
        die;
    }

    function switchPhp()
    {
        # Disable all exist versions
        foreach ($this->allowed_versions as $php_version) {
            `sudo a2dismod php$php_version`;
        }

        `sudo a2enmod php{$this->selected_version}`;
        `sudo service apache2 restart`;
        echo "Установлена версия php{$this->selected_version}\n";
    }
}

new PHPV($argv);