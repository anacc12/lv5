<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'title_en',
        'study_type',
        'teacher_id',
        'student_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class);
    }
}
