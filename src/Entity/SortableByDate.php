<?php

namespace App\Entity;

use DateTime;

interface SortableByDate
{
    public function getDate(): DateTime;
}