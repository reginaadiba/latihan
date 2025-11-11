<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Categoryable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable = [
    //     'title',
    //     'description'
    // ];

    /**
     * column yg tidak boleh diisi lewat mass assignment
     * fillable dan guarded tidak boleh digunakan bersamaan
     * dipakai sesuai kebutuhan
     * kalo lebih banyak yg harus diisi user, lebih baik gunakan guarded dan list column yg tidak diisi oleh user
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Get all of the comments for the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The roles that belong to the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        // return $this->belongsToMany(Tag::class, 'blog_tag', 'blog_id', 'tag_id');
        return $this->belongsToMany(Tag::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categoriable', Categoriable::class);
    }

    /**
     * Get the user that owns the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
