<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;
    protected $table = 'errorLogs';

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    protected $fillable =
        [
            'filePath',
            'lineNo',
            'statusCode',
            'errorMessage',
            'ticketStatus',
            'developerCommnet',
        ];
    public function getDateFormat()
    {
        return 'U';
    }}
