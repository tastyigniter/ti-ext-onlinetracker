<?php

namespace Igniter\OnlineTracker\Models;

use Model;

class GeoIp extends Model
{
    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_onlinetracker_geoip';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'id';

    public $timestamps = TRUE;

    protected $guarded = [];

}