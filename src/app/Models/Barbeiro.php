<?php
namespace App\Models;

use App\Models\BD;
use PDO;

class Barbeiro
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = BD::getConnection();
    }


    
}
