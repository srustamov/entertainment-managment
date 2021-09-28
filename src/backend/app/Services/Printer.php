<?php

namespace App\Services;

use Carbon\Traits\Macro;
use Illuminate\Support\Traits\Macroable;

class Printer extends \Mike42\Escpos\Printer
{
    use Macroable;

    const NEW_LINE = "\r\n";



    public function text(string $str)
    {
        parent::text($str);
        parent::text(self::NEW_LINE);
    }

    public function addLine(string $text): static
    {
        $this->text($text.self::NEW_LINE);

        return $this;
    }

    public function addLineDashed(): static
    {
        return $this->addLine("------------------------------------------------");
    }


    public function setContentCenter()
    {
        $this->setJustification(self::JUSTIFY_CENTER);
    }

}
