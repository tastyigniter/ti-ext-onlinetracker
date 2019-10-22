<?php

namespace Igniter\OnlineTracker\Classes;

use Igniter\OnlineTracker\Models\GeoIp;
use Igniter\OnlineTracker\Models\PageVisit as TrackerModel;

class RepositoryManager
{
    /**
     * @var \Igniter\OnlineTracker\Models\PageVisit
     */
    protected $trackerModel;

    /**
     * @var \Igniter\OnlineTracker\Models\GeoIp
     */
    protected $geoIpModel;

    public function __construct(TrackerModel $trackerModel, GeoIp $geoIpModel)
    {
        $this->trackerModel = $trackerModel;
        $this->geoIpModel = $geoIpModel;
    }

    public function createLog($log)
    {
        return $this->trackerModel->create($log);
    }

    public function createGeoIp($geoip, $keys = null)
    {
        $geoip = $this->findOrCreate($this->geoIpModel, $geoip, $keys);

        return $geoip ? $geoip->id : null;
    }

    public function findOrCreate($model, $attributes, $keys = null)
    {
        $query = $model->newQuery();

        $keys = $keys ?: array_keys($attributes);

        foreach ($keys as $key) {
            $query = $query->where($key, $attributes[$key]);
        }

        if (!$foundModel = $query->first()) {
            $foundModel = $model->create($attributes);
        }

        if (!$foundModel->exists)
            return null;

        return $foundModel;
    }
}