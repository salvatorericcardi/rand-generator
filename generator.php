<?php

class RandGenerator {
    private array $nums;
    private int $sum = 0;

    private string $type = "";

    function __construct(int $dices, int $sides) {
        $nums = [];
        $sum = 0;

        switch ($sides) {
            case 4:
                $this->type = "d4";
                break;
            case 6:
                $this->type = "d6";
                break;
            case 8:
                $this->type = "d8";
                break;
            case 10:
                $this->type = "d10";
                break;
            case 12:
                $this->type = "d12";
                break;
            case 20:
                $this->type = "d20";
                break;
        }

        while ($dices) {
            $rolled = random_int(1, $sides);
            array_push($nums, $rolled);
            $sum += $rolled;
            $dices--;   
        }

        $this->nums = $nums;
        $this->sum = $sum;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
}

$rand = new RandGenerator((int)$_POST['dices'], (int)$_POST['sides']);
echo json_encode([
    "sum" => $rand->__get("sum"),
    "type" => $rand->__get("type"),
    "nums" => $rand->__get("nums")
]);
