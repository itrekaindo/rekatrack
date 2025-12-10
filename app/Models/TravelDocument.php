<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TravelDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'travel_document';

    protected $fillable = [
        'no_travel_document', 'date_no_travel_document', 'send_to', 'po_number', 'reference_number', 'project', 'status','start_time', 'end_time'
    ];

    protected $dates = [
        'deleted_at',
        'date_no_travel_document','start_time','end_time'
    ];

    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function trackingSystems()
    {
        return $this->hasMany(TrackingSystem::class);
    }
}
