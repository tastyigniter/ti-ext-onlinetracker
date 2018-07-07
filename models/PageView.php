<?php namespace IgniterLab\OnlineTracker\Models;

use Auth;
use Country;
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
    protected $table = 'igniterlab_onlinetracker_tracker';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'activity_id';

    protected $guarded = [];

    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'geoip'    => ['IgniterLab\OnlineTracker\Models\GeoIp'],
            'customer' => ['Admin\Models\Customers_model', 'foreignKey' => 'customer_id'],
        ],
    ];
}