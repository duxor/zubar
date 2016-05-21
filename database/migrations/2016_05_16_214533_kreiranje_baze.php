<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KreiranjeBaze extends Migration{
    public function up(){
        Schema::create('prava_pristupa', function(Blueprint $table){
            $table->increments('id');
            $table->string('naziv', 45)->unique();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('grad', function(Blueprint $table){
            $table->increments('id');
            $table->string('naziv', 45)->unique();
            $table->string('x', 20)->nullable();
            $table->string('y', 20)->nullable();
            $table->string('z', 20)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('korisnici', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('ime', 45)->nullable();
            $table->string('prezime', 45)->nullable();
            //$table->string('naziv', 120)->nullable();
            //$table->string('username', 200)->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('pin', 10)->nullable();
            $table->text('bio')->nullable();
            $table->text('telefon')->nullable();
            $table->unsignedInteger('grad_id')->default(1);
            $table->foreign('grad_id')->references('id')->on('grad');
            $table->unsignedInteger('prava_pristupa_id')->default(2);
            $table->foreign('prava_pristupa_id')->references('id')->on('prava_pristupa');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->string('foto', 250)->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('templejt', function(Blueprint $table){
            $table->increments('id');
            $table->string('naziv', 45)->unique();
            $table->string('slug', 45)->unique();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('ordinacija', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('naziv', 120)->nullable();
            $table->string('slug', 200)->unique();
            $table->text('radno_vrijeme')->nullable();
            $table->text('neradni_dani')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon')->nullable();
            $table->text('adresa')->nullable();
            $table->text('galerija')->nullable();
            $table->string('x', 20)->nullable();
            $table->string('y', 20)->nullable();
            $table->string('z', 20)->nullable();
            $table->unsignedInteger('templejt_id')->default(1);
            $table->unsignedInteger('grad_id')->default(1);
            $table->foreign('grad_id')->references('id')->on('grad');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('upotreba_templejta', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->text('podaci')->nullable();
            $table->unsignedInteger('templejt_id')->default(1);
            $table->foreign('templejt_id')->references('id')->on('templejt');
            $table->unsignedBigInteger('ordinacija_id');
            $table->foreign('ordinacija_id')->references('id')->on('ordinacija');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('usluga', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('naziv', 200)->nullable();
            $table->text('opis')->nullable();
            $table->tinyInteger('vreme_realizacije')->nullable();
            $table->tinyInteger('cena')->nullable();
            $table->unsignedBigInteger('ordinacija_id')->default(2);
            $table->foreign('ordinacija_id')->references('id')->on('ordinacija');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('rezervacija', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->timestamp('termin')->nullable();
            $table->text('dijagnoza')->nullable();
            $table->tinyInteger('ocena')->nullable();
            $table->unsignedBigInteger('korisnici_id')->default(1);
            $table->foreign('korisnici_id')->references('id')->on('korisnici');
            $table->string('usluga_idevi',100)->nullable();
            $table->unsignedBigInteger('ordinacija_id');
            $table->foreign('ordinacija_id')->references('id')->on('ordinacija');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('password_resets', function(Blueprint $table){
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
        Schema::create('log', function(Blueprint $table){
            $table->increments('id');
            $table->string('ip',45)->nullable();
            $table->unsignedBigInteger('korisnici_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }
    public function down(){
        Schema::drop('rezervacija');
        Schema::drop('usluga');
        Schema::drop('upotreba_templejta');
        Schema::drop('ordinacija');
        Schema::drop('templejt');
        Schema::drop('korisnici');
        Schema::drop('prava_pristupa');
        Schema::drop('grad');
        Schema::drop('password_resets');
        Schema::drop('log');
    }
}
