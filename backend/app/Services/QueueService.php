<?php

namespace App\Services;

use App\Models\Queue;
use App\Support\Interfaces\Printable;
use Exception;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use JetBrains\PhpStorm\Pure;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class QueueService implements Printable
{
    public const PRINTER_TIMEOUT = 15;

    public const NEW_LINE = "\r\n";

    public string $ip = '0.0.0.0';

    public int $port = 9100;

    public Queue $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    #[Pure]
    public static function make(Queue $queue): static
    {
        return new static($queue);
    }

    /**
     * @throws Exception
     */
    public function print()
    {
        $printer = $this->getPrinter();

        $printer->setContentCenter();
        $printer->setTextSize(1, 3);
        $printer->text($this->queue->number);

        $printer->addLineDashed();

        $printer->setTextSize(1, 2);
        $printer->text($this->queue->queueable->name);

        $printer->setTextSize(1, 1);
        $printer->addLineDashed();
        $printer->setTextSize(1, 2);

        $printer->setContentCenter();
        $printer->setTextSize(1, 1);
        $printer->text('Növbə:'.$this->queue->number);

        $printer->qrCode($this->queue->id, 0, 5);

        $printer->setTextSize(1, 1);
        $printer->addLineDashed();
        $printer->setTextSize(1, 2);

        $printer->setContentCenter();
        $printer->text($this->queue->created_at->toString());

        $printer->feed();
        $printer->cut();

        $printer->close();
    }

    /**
     * @throws Exception
     */
    public function getPrinter(): Printer
    {
        return new Printer(
            new NetworkPrintConnector(
                $this->getIp(),
                $this->getPort(),
                self::PRINTER_TIMEOUT
            )
        );
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp($ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getPort(): int
    {
        return $this->port ?? 9100;
    }

    public function setPort($port): static
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function printImage()
    {
        file_put_contents($qrPath = storage_path('tmp_qr.png'), '');

        $image = Image::canvas(1000, 690, '#ffff')
            ->insert($qrPath, 'left-top', 50, 50)
            ->text('Test 1', 530, 150, function ($font) {
                $font->file(storage_path('fonts/Roboto-Regular.ttf'));
                $font->size(40);
                $font->valign('top');
            })
            ->text('Test 2', 620, 300, function ($font) {
                $font->file(storage_path('fonts/Roboto-Regular.ttf'));
                $font->size(60);
                $font->valign('top');
            })
            ->save(storage_path($filename = "{$this->queue->location_id}-{$this->queue->queueable_id}-printer-image.png"));

        $response = Response::make($image->encode('png'));

        $response->header('Content-Type', 'image/png');

        $printer = $this->getPrinter();

        try {
            $printer->bitImage(
                EscposImage::load(storage_path($filename), false)
            );
        } catch (Exception $e) {
            $printer->text($e->getMessage()."\n");
        }

        $printer->cut();
        $printer->close();
    }
}
