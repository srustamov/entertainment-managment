<?php


namespace App\Support\Interfaces;

interface Printable
{
    public function print();

    public function setIp(string $ip);

    public function setPort(int $port);

    public function getIp() : string;

    public function getPort() : int;

    public function getPrinter();
}
