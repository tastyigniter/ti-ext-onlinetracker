<?php namespace Igniter\OnlineTracker\Models;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Jenssegers\Agent\Agent;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Model;

/**
 * PageVisit Model Class
 *
 * @package Admin
 */
class PageView extends Model
{
    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_onlinetracker_tracker';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'activity_id';

    protected $guarded = [];

    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'geoip' => ['Igniter\OnlineTracker\Models\GeoIp'],
            'customer' => ['Admin\Models\Customers_model', 'foreignKey' => 'customer_id'],
        ],
    ];
}