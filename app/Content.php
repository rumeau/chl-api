<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 026 26 01 2015
 * Time: 13:59
 */

namespace App;


use App\Paginator\PaginableTrait;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use PaginableTrait;

    const CONTENT_TYPE_SERVICE = 1;
    const CONTENT_TYPE_BLOCK   = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['users_id', 'title', 'summary', 'body', 'type', 'api'];

    /**
     * @var array
     */
    protected $casts = [
        'summary' => 'array',
        'body' => 'array',
    ];

    /**
     * @var array
     */
    protected $queryFields = ['title', 'summary', 'body'];

    /**
     * @var array
     */
    protected $by = ['title', 'version'];
}
