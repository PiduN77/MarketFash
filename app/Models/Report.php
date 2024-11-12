<?php

// File: app/Models/Report.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // This is a dummy model and doesn't correspond to any database table
    protected $table = null;

    public function getKeyName()
    {
        return 'id';
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}