<?php

namespace Source\Models;

use Source\Core\Model;

class Notification extends Model
{
    public function __construct()
    {
        parent::__construct("notifications", ["id"], ["image, title, link"]);
    }
}
