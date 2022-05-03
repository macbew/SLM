 /**
 * Автор: Михаил Михальчук
 *
 * Дата реализации: 03.05.2022
 *
 * Дата изменения: 03.05.2022
 *
 * Утилита для работы с базой данны

 /**
 * TODO:
 * [+] Создать Конструктор класса либо создает человека в БД с заданной
 информацией, либо берет информацию из БД по id (предусмотреть
 валидацию данных);
 * [+] Создать метод Сохранение полей экземпляра класса в БД;
 * [+] Создать метод Удаление человека из БД в соответствии с id объекта
 * [+] Создать метод static преобразование даты рождения в возраст (полных лет)
 * [+] Создать метод static преобразование пола из двоичной системы в текстовую
 * [+] Создать метод для форматирования человека с преобразованием возраста и (или) пола
        в зависимотси от параметров (возвращает новый экземпляр StdClass со всеми полями изначального класса).

 <?php

    class CRUD
    {
        /*
    Класс должен иметь поля:
    id, имя, фамилия, дата рождения, пол(0,1), город рождения
     Работа с БД
     Добавление, удаление записей в бд. 
    */

        private $id, $name, $secondName, $birthDate, $sex, $cityBirth;

        function __construct($id, $name = 0, $secondName = 0, $birthDate = 0, $sex = 0, $cityBirth = 0)
        {
            $this->id = $id;
            $this->name = $name;
            $this->secondName = $secondName;
            $this->birthDate = $birthDate;
            $this->sex = $sex;
            $this->cityBirth = $cityBirth;

            if ($this->name) {
                $this->savePerson();
            } else {
                $this->deletePerson();
            }
        }

        private function savePerson()
        {
            $query = "INSERT INTO `people` (`id`, `name`, `secondName`, `dirthDate`, `sex`, `cityBirth`) 
                        VALUES ($this->id, $this->name, $this->secondName, $this->birthDate, $this->sex, $this->cityBirth)";
            return $query;
        }

        private function deletePerson()
        {
            $query = "DELETE FROM `people` WHERE `id`=$this->id";
            return $query;
        }

        static function birthToAge($birthDate)
        {
            $secInYear = 31536000;
            $time = time() - strtotime($birthDate);
            $age = floor($time / $secInYear);
            return $age;
        }

        static function getSex($bool)
        {
            if ($bool) {
                return 'woman';
            }
            return 'man';
        }

        function formated()
        {
            $objStd = new stdClass();
            foreach ($this as $key => $val) {
                if ($key === "sex") {
                    if ($val === 0 || $val === 0) {
                        $objStd->$key = $this->getSex($val);
                    }
                    $objStd->$key = $val;
                } else if ($key === "birthDate") {
                    if (is_numeric($val)) {
                        $objStd->$key = $val;
                    } else {
                        $objStd->$key = $this->birthToAge($val);
                    }
                } else {
                    $objStd->$key = $val;
                }
            }
            if (is_int($this->sex)) {
                $objStd->sex = $this->getSex($this->sex);
            }
            return $objStd;
        }
    }
