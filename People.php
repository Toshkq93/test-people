<?php

namespace App;

class People
{
    /** @var array $people_ids */
    public array $people_ids;
    /** @var string $operator */
    public string $operator;

    public function __construct(array $people_ids, string $operator)
    {
        if (!$this->isExsistClassPerson()){
            throw new \Exception('Class Person not found!');
        }

        $this->people_ids = $people_ids;
        $this->operator = $operator;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getByIds(): array
    {
        $result = [];
        $people = $this->people_ids;

        foreach ($people as $person) {
            $result[] = new Person($person);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function deleteByIds(): bool
    {
        $people = $this->getByIds($this->people_ids);

        /** @var Person $person */
        foreach ($people as $person) {
            $person->delete($person['id']);
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isExsistClassPerson(): bool
    {
        if (class_exists(Person::class)){
            return true;
        }

        return false;
    }
}