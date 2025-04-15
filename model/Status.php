<?php

namespace App\Models;

enum status: String{
    case prospect = "Prospect";
    case inprogress = "In Progress";
    case onhold = "On Hold";
    case completed = "Completed";
}
