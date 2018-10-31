<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    use SoftDeletes;

    const PUBLISHED = '1';
    const PENDING = '2';
    const REJECTED = '3';

    protected $withCount = ['reviews', 'students', 'requirements', 'goals'];
    protected $fillable = ['name', 'teacher_id', 'description', 'image', 'level_id', 'category_id', 'status'];


    public static function boot(){
        parent::boot();
        static::saving(function(Course $course){
            if(! \App::runningInConsole()){
                $course->slug = str_slug($course->name, "-");
            }
        });
        static::saved(function(Course $course){
            if(! \App::runningInConsole()){
                if(request('requirements')){
                    foreach(request('requirements') as $key => $requirement_input){
                        if($requirement_input){
                            Requirement::updateOrCreate(['id' => request('requirement_id'.$key)],[
                                'course_id' => $course->id,
                                'requirement' => $requirement_input
                            ]);
                        }
                    }
                }
                if(request('goals')){
                    foreach(request('goals') as $key => $goal_input){
                        if($goal_input){
                            Goal::updateOrCreate(['id' => request('goal_id'.$key)],[
                                'course_id' => $course->id,
                                'goal' => $goal_input
                            ]);
                        }
                    }
                }
            }
        });
    }

    public function pathAttachment(){
        return "/images/courses/".$this->image;
    }

    /**
     * @return string
     * usa el campo 'slug' como elemento para la ruta
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    /**
     * @return Course[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function relatedCourses(){
        return Course::with(['reviews'])->whereCategoryId($this->category->id)
                                        ->where('id', '!=', $this->id)
                                        ->latest()
                                        ->limit(6)
                                        ->get();
    }

    //accessors
    public function getRatingAttribute(){
        return $this->reviews->avg('rating');
    }
    
}
