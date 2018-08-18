<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Course
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property string $status
 * @property int $previous_approved
 * @property int $previous_rejected
 * @property string $slug
 * @property int $teacher_id
 * @property int $category_id
 * @property int $level_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePreviousApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePreviousRejected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 */
class Course extends Model
{
    const PUBLISHED = 1;
    const PENDING = 2;
    const REJECTED = 3;

    public function requirements(){
        return $this->hasMany(Requirement::class);
    }
    public function goals(){
        return $this->hasMany(Goal::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function students(){
        return $this->belongsToMany(Student::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    
}
