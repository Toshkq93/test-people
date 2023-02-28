<?php

namespace App;

use DateTime;
use Exception;
use stdClass;

class Person
{
    /** @var int $id */
    private int $id;
    /** @var string $first_name */
    private string $first_name;
    /** @var string $last_name */
    private string $last_name;
    /** @var string $birthday */
    private string $birthday;
    /** @var int $gender */
    private int $gender;
    /** @var string $city_birthday */
    private string $city_birthday;

    const MALE = 0;
    const FEMALE = 1;
    const GENDERS = [
        self::MALE   => 'муж',
        self::FEMALE => 'жен'
    ];

    public function __construct(array $data)
    {
        $data = $this->validate($data);

        if (!$person = $this->findById($data['id'])) {
            $person = $this->create($data);
        }

        $this->setProperties($person);
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array
    {
        return [];
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        return [];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return true;
    }

    /**
     * @param string $birthday
     * @return int
     * @throws Exception
     */
    public static function calculateAge(string $birthday)
    {
        $birthday = new DateTime($birthday);

        return (new DateTime())->diff($birthday)->y;
    }

    /**
     * @param int $gender
     * @return string
     */
    public static function calculateStringGender(int $gender): string
    {
        return self::GENDERS[$gender];
    }

    /**
     * @param array $data
     * @return stdClass
     */
    public function update(array $data)
    {
        if (!empty($data['gender'])) {
            $data['gender'] = self::calculateStringGender($data['gender']);
        }
        if (!empty($data['birthday'])) {
            $data['birthday'] = self::calculateAge($data['birthday']);
        }

        return $this->generateStdobject();
    }

    /**
     * @param array $person
     * @return void
     */
    private function setProperties(array $person): void
    {
        foreach ($person as $property => $value) {
            if ($this->$property) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @return stdClass
     */
    private function generateStdobject(): stdClass
    {
        $person = new stdClass();
        $person->id = $this->id;
        $person->first_name = $this->first_name;
        $person->last_name = $this->last_name;
        $person->gender = self::GENDERS[$this->gender];
        $person->age = self::calculateAge($this->birthday);
        $person->city_birthday = $this->city_birthday;

        return $person;
    }

    /**
     * @param array $data
     * @return array
     */
    private function validate(array $data): array
    {
        $result = [];

        foreach ($data as $value) {
            $result[] = trim(htmlspecialchars(strip_tags($value)));
        }

        return $result;
    }
}