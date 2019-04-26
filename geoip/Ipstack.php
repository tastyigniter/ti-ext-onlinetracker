<?php

namespace Igniter\OnlineTracker\Geoip;

use Exception;
use Igniter\OnlineTracker\Models\Settings;

class Ipstack extends AbstractReader
{
    /**
     * Returns an endpoint to fetch the record from
     *
     * @param string $ip IP address to fetch geoip record for
     * @return string
     */
    protected function getEndpoint($ip)
    {
        $accessKey = Settings::get('ipstack_access_key');

        if (!strlen($accessKey))
            throw new Exception('Missing ipstack access key');

        return "http://api.ipstack.com/{$ip}?access_key={$accessKey}";
    }

    /**
     * Returns latitude from the geoip record
     *
     * @return string
     */
    public function latitude()
    {
        return $this->record->latitude;
    }

    /**
     * Returns longitude from the geoip record
     *
     * @return string
     */
    public function longitude()
    {
        return $this->record->longitude;
    }

    /**
     * Returns region from the geoip record
     *
     * @return string
     */
    public function region()
    {
        return $this->record->region_name;
    }

    /**
     * Returns region ISO code from the geoip record
     *
     * @return string
     */
    public function regionISOCode()
    {
        return $this->record->region_code;
    }

    /**
     * Returns city from the geoip record
     *
     * @return string
     */
    public function city()
    {
        return $this->record->city;
    }

    /**
     * Returns postal code from the geoip record
     *
     * @return string
     */
    public function postalCode()
    {
        return $this->record->zip;
    }

    /**
     * Returns country from the geoip record
     *
     * @return string
     */
    public function country()
    {
        return $this->record->country_name;
    }

    /**
     * Returns country ISO code from the geoip record
     *
     * @return string
     */
    public function countryISOCode()
    {
        return $this->record->country_code;
    }
}