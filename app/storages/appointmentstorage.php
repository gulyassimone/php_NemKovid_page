<?php
include_once(__DIR__ . '/../lib/storage.php');

class AppointmentStorage extends Storage
{
    public function __construct()
    {
        parent::__construct(new JsonIO(__DIR__ . '/../datas/appointments.json'));
    }

    public function  findAllActualMonth(int $actual):array{
       return $this->findMany(function($date) use ($actual){
           return (int)date('m', $date['time']) === $actual;
           });
    }
}