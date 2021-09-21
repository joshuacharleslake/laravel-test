<?php

use App\Models\Quote;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')
                ->nullable();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
            $table->string('name', 255);
            $table->text('description', 255);
            $table->longText('content')
                ->nullable();
            $table->enum('status', Quote::STATUSES);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
