<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    /*
     * Status: ['pending', 'approve', 'spam']
     * parent_id default 0
     * */
    protected $fillable = ['content', 'user_id', 'status', 'parent_id' ];
    protected $appends = ['created_at_for_human'];

    public function commentable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


    /*
     * Scope
     * */
    public function scopeApproved( $query ) {
        $query->where('status', 'approve');
    }
    public function scopePending( $query ) {
        $query->where('status', 'pending');
    }
    public function scopeSpam( $query ) {
        $query->where('status', 'spam');
    }

    public function scopeRootComments($query) {
        $query->where('parent_id', 0);
    }
    public function scopeParentComments($query, $parent_id) {
        $query->where('parent_id', $parent_id);
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
}
