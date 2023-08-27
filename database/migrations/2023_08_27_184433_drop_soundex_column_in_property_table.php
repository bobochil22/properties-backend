<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropSoundexColumnInPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property', function (Blueprint $table) {
            DB::statement("DROP INDEX property_soundex_trgm_idx;");
            $table->dropColumn('soundex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property', function (Blueprint $table) {
            $table->string('soundex')->nullable();
        });
        DB::statement("CREATE INDEX property_soundex_trgm_idx ON property USING GIST (soundex gist_trgm_ops);");
    }
}
