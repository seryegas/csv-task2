Тестовое задание:
Задача:
Написать программу gentree используя PHP7.1, генерирующую JSON файл на основе входящего CSV файла.


Установка зависимостей для ubuntu, если установлен php 7.1 перейти к пункту 3:
1. выполнить команды:

    - sudo apt-get install software-properties-common;

    - sudo add-apt-repository ppa:ondrej/php;

    - sudo apt-get update;

2. установить php 
    - sudo apt-get install php7.1 php7.1-cli php7.1-json php7.1-fpm

3. выполнить команду в нужной директории
    - git clone https://github.com/seryegas/csv-task2.git
    - cd csv-task2
4. для запуска программы выполнить:
    - php index.php path/to/input.csv path/to/output.json

