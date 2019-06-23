<?php


namespace App\Helper;


class ConsoleProgressBar
{
    private $steps;
    private $step = 0;
    private $size;

    public function __construct(int $steps, int $size = 50)
    {
        $this->steps = $steps;
        $this->size = ($size > 100) ? 100 : $size;
        $this->size = ($size < 1) ? 10 : $size;
    }

    public function progress()
    {
        $this->step++;
        $this->display();
    }

    private function display()
    {
        $stepScalled = round($this->step / $this->steps * $this->size);
        $stepPercent = round($this->step / $this->steps * 100);
        echo "\r[";
        for ($i = 0; $i < $stepScalled - 1; $i++) {
            echo "=";
        }
        if ($stepScalled != $this->size) {
            echo ">";
        } else {
            echo "=";
        }
        for ($i = $stepScalled; $i < $this->size; $i++) {
            echo "-";
        }
        echo "] " . $stepPercent . "%";
    }
}
