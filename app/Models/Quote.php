<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 'Draft';
    const STATUS_PUBLISHED = 'Published';
    const STATUS_REJECTED = 'Client';
    const STATUS_APPROVED = 'Approved';

    const STATUSES = [
        SELF::STATUS_DRAFT,
        SELF::STATUS_PUBLISHED,
        SELF::STATUS_REJECTED,
        SELF::STATUS_APPROVED
    ];

}
