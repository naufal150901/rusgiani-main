<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap transaksi masuk
            $table->string('uuid')->unique();
            $table->date('in_date'); // Tanggal gas diterima di gudang
            $table->string('gas_type'); // Jenis gas, misalnya, Gas 3 Kg, 5.5 Kg, 12 Kg
            $table->integer('quantity_in'); // Jumlah unit gas yang diterima
            $table->decimal('unit_price', 10, 2); // Harga satuan per unit gas yang diterima
            $table->decimal('total_cost', 15, 2); // Total biaya transaksi masuk (jumlah masuk × harga per unit)
            $table->string('supplier'); // Nama atau identitas pemasok gas
            $table->string('batch_number')->nullable(); // Nomor batch atau kode pengiriman
            $table->string('warehouse_location')->nullable(); // Lokasi gudang atau penyimpanan gas
            $table->text('additional_notes')->nullable(); // Keterangan tambahan terkait pengiriman, seperti kondisi tabung atau tanggal kadaluarsa
            $table->timestamps();
        });
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap transaksi keluar
            $table->string('uuid')->unique();
            $table->date('out_date'); // Tanggal pengiriman gas keluar dari gudang
            $table->string('gas_type'); // Jenis gas yang dikirim (Gas 3 Kg, 5.5 Kg, 12 Kg, dsb.)
            $table->integer('quantity_out'); // Jumlah unit gas yang dikirim keluar
            $table->decimal('unit_price', 10, 2); // Harga satuan per unit gas yang dikirim
            $table->decimal('total_revenue', 15, 2); // Total pendapatan dari transaksi keluar (jumlah keluar × harga per unit)
            $table->string('recipient'); // Nama agen, pelanggan, atau outlet penerima gas
            $table->string('shipment_number'); // Nomor pengiriman atau nomor invoice
            $table->string('shipment_method'); // Cara pengiriman, misalnya, kurir, pengambilan sendiri, dll.
            $table->string('warehouse_location'); // Lokasi gudang asal gas yang dikirim
            $table->enum('shipment_status', ['dalam_pengiriman', 'transit']); // Status apakah gas sudah sampai atau masih dalam perjalanan
            $table->text('additional_notes')->nullable(); // Keterangan tambahan terkait pengiriman, seperti kondisi tabung atau permintaan khusus
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('gas_type');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incoming_items');
        Schema::dropIfExists('outgoing_items');
        Schema::dropIfExists('stocks');
    }
}
