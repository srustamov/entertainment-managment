<?php


namespace App\Interfaces;

interface PrinterInterface
{

    public function print();

    public function setIp(string $ip);

    public function setPort(int $port);

    public function getIp() : string;

    public function getPort() : int;

    public function getPrinter();
}
