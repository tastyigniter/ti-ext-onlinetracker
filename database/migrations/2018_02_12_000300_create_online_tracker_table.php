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
        if (Schema::hasTable('igniter_onlinetracker_tracker')
            OR !Schema::hasTable('customers_online'))
            return;

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

    public function down()
    {
        Schema::table('igniter_onlinetracker_tracker', function (Blueprint $table) {
            $table->dropColumn('session_id');
            $table->dropColumn('geoip_id');
            $table->dropColumn('headers');

            $table->renameColumn('agent', 'access_type');
            $table->string('access_type')->change();
        });

        Schema::rename('igniter_onlinetracker_tracker', 'customers_online');

        Schema::dropIfExists('igniter_onlinetracker_geoip');
    }
}