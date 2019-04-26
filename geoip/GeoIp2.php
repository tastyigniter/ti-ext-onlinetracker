<?php

namespace Igniter\OnlineTracker\Geoip;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Igniter\OnlineTracker\Models\Settings;
use MaxMind\Db\Reader\InvalidDatabaseException;

class GeoIp2 extends AbstractReader
{
    /**
     * Fetch data from a remote geoapi service
     *
     * @param string $ip
     * @return $this
     */
    public function retrieve($ip)
    {
        try {
            $reader = new Reader((new Settings)->ensureDatabaseExists()->getDatabasePath());
            $this->record = $reader->city($ip);
        }
        catch (AddressNotFoundException $e) {
        }
        catch (InvalidDatabaseException $e) {
        }

        return $this;
    }

    /**
     * Returns an endpoint to fetch the record from
     *
     * @param string $ip IP address to fetch geoip record for
     * @return string
     */
    protected function getEndpoint($ip)
    {
    }

    /**
     * Returns latitude from the geoip record
     *
     * @return string
     */
    public function latitude()
    {
        return $this->record->location->latitude;
    }

    /**
     * Returns longitude from the geoip record
     *
     * @return string
     */
    public function longitude()
    {
        return $this->record->location->longitude;
    }

    /**
     * Returns region from the geoip record
     *
     * @return string
     */
    public function region()
    {
        return $this->record->mostSpecificSubdivision->name;
    }

    /**
     * Returns region from the geoip record
     *
     * @return string
     */
    public function regionISOCode()
    {
        return $this->record->mostSpecificSubdivision->isoCode;
    }

    /**
     * Returns city from the geoip record
     *
     * @return string
     */
    public function city()
    {
        return $this->record->city->name;
    }

    /**
     * Returns postal code from the geoip record
     *
     * @return string
     */
    public function postalCode()
    {
        return $this->record->postal->code;
    }

    /**
     * Returns country from the geoip record
     *
     * @return string
     */
    public function country()
    {
        return $this->record->country->name;
    }

    /**
     * Returns country code from the geoip record
     *
     * @return string
     */
    public function countryISOCode()
    {
        return $this->record->country->isoCode;
    }
}