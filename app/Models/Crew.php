<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crew extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'rank',
        'email',
        'address',
        'birth_date',
        'age' ,
        'height',
        'weight',
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
        'bmi'
    ];

    /**
     * Attributes
     */
    public function getBmiAttribute()
    {
        if(!empty($this->height) && !empty($this->weight)){
            $bmi = round($this->weight/($this->height^2),2);
            if ($bmi < 18.5) {
                $message="Underweight";
            } else if ($bmi <= 24.9) {
                    $message="Normal";
            } else if ($bmi <= 29.9) {
                    $message="Overweight";
            } else {
                    $message="Obese";
            }
            return $bmi.'('.$message.')';
        }else{
            return 'N/A';
        }

    }

    /**
     * Relationship
     */
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'rank');
    }

}
