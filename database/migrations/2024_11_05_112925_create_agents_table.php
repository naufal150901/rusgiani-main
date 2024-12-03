<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap agen
            $table->string('uuid')->unique();
            $table->string('agent_name'); // Nama lengkap agen
            $table->text('address'); // Alamat lengkap agen
            $table->string('phone_number')->nullable(); // Kontak telepon agen
            $table->string('email')->unique(); // Email agen
            $table->date('join_date'); // Tanggal agen mulai bergabung
            $table->enum('active_status', ['aktif', 'nonaktif']); // Status keaktifan
            $table->text('additional_notes')->nullable(); // Catatan atau keterangan tambahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
