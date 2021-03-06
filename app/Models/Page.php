<?php

namespace App\Models;

use App\Traits\HasComment;
use App\Traits\HasLike;
use App\Traits\HasRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [ 'title', 'content', 'feature_image', 'draft', 'password', 'slug', 'user_id'];
    protected $appends = ['updated_at_for_human', 'created_at_for_human', 'url', 'has_password'];
    protected $hidden = ['password'];


    public function user() {
        return $this->belongsTo(User::class);
    }


    /*
     * Mutator And Accessor
     * */
    public function getUpdatedAtForHumanAttribute() {
        return $this->updated_at->diffForHumans();
    }
    public function getCreatedAtForHumanAttribute() {
        return $this->created_at->diffForHumans();
    }
    public function getUrlAttribute() {
        return route('Page.show', ['page'=>$this->slug]);
    }
    public function getHasPasswordAttribute() {
        return $this->password ? true : false;
    }

    public function scopeDraft($query) {
        $query->where('draft', true);
    }
    public function scopePublished($query) {
        $query->where('draft', false);
    }
    public function scopeUserPages($query) {
        if( auth()->check() ) {
            return $query->where('user_id', auth()->user()->id);
        }
        return $query;
    }
}
