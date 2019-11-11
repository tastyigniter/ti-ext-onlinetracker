<?php namespace Igniter\OnlineTracker\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create igniter_onlinetracker_tracker table
 */
class CreateOnlineTrackerTable extends Migration
{
    public function up()
    {
        $this->createTrackerTable();

        $this->createGeoIpTable();
    }

    public function down()
    {
        if (!Schema::hasTable('igniter_onlinetracker_tracker'))
            return;

        Schema::table('igniter_onlinetracker_tracker', function (Blueprint $table) {
            $table->dropColumn('session_id');
            $table->dropColumn('geoip_id');
            $table->dropColumn('platform');
            $table->dropColumn('headers');
            $table->dropColumn('query');
            $table->dropTimestamps();
            $table->dateTime('date_added');
        });

        Schema::rename('igniter_onlinetracker_tracker', 'customers_online');

        Schema::dropIfExists('igniter_onlinetracker_geoip');
    }

    protected function createTrackerTable()
    {
        if (Schema::hasTable('igniterlab_onlinetracker_tracker'))
            Schema::rename('igniterlab_onlinetracker_tracker', 'igniter_onlinetracker_tracker');

        if (Schema::hasTable('igniter_onlinetracker_tracker'))
            return;

        if (Schema::hasTable('customers_online'))
            Schema::rename('customers_online', 'igniter_onlinetracker_tracker');

        Schema::table('igniter_onlinetracker_tracker', function (Blueprint $table) {
            $table->bigIncrements('activity_id')->change();
            $table->string('session_id')->nullable();
            $table->integer('geoip_id')->nullable();
            $table->string('platform')->nullable();
            $table->text('headers')->nullable();
            $table->text('query')->nullable();
            $table->dropColumn('date_added');
            $table->timestamps();
        });
    }

    protected function createGeoIpTable()
    {
        if (Schema::hasTable('igniterlab_onlinetracker_geoip'))
            Schema::rename('igniterlab_onlinetracker_geoip', 'igniter_onlinetracker_geoip');

        if (Schema::hasTable('igniter_onlinetracker_geoip'))
            return;

        Schema::create('igniter_onlinetracker_geoip', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->double('latitude')->nullable()->index();
            $table->double('longitude')->nullable()->index();
            $table->string('region', 6)->nullable();
            $table->string('city', 50)->nullable()->index();
            $table->string('postal_code', 20)->nullable();
            $table->string('country_iso_code_2', 2)->nullable()->index();
            $table->timestamps();
        });
    }
}