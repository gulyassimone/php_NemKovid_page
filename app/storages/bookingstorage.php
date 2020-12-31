<?php
include_once(__DIR__ . '/../lib/storage.php');

class BookingStorage extends Storage {
    public function __construct() {
        parent::__construct(new JsonIO(__DIR__ . '/../datas/booking.json'));
    }
}