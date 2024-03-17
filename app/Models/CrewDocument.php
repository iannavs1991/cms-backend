<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CrewDocument extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'crew_id',
        'document_id',
        'issue_date',
        'expiry_date',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Append Attribute
     */
    protected $appends = [
        'document_color' //base on expiry date
    ];

    /**
     * Attributes
     */
    public function getDocumentColorAttribute(){
        $date = Carbon::parse($this->expiry_date)->diffForHumans();
        if($date == '1 week from now'){
            return 'red';
        }elseif($date == '1 month from now'){
            return 'yellow';
        }elseif($date == '3 months from now'){
            return 'yellow';
        }else{
            return null;
        }
    }

    /**
     * Relationship
     */
    public function crew(): BelongsTo
    {
        return $this->belongsTo(Crew::class, 'crew_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
