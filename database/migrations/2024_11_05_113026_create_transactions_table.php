<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap transaksi
            $table->string('uuid')->unique();
            $table->date('transaction_date'); // Tanggal transaksi dilakukan
            $table->string('transaction_type'); // Jenis transaksi, misalnya, Penjualan, Pembelian, Pengeluaran Operasional
            $table->text('transaction_description'); // Keterangan singkat tentang transaksi
            $table->string('agent_client_name'); // Nama agen atau klien yang terlibat dalam transaksi
            $table->integer('unit_quantity'); // Jumlah unit gas yang terjual atau dibeli
            $table->decimal('unit_price', 10, 2); // Harga per unit dari barang yang ditransaksikan
            $table->decimal('total_amount', 15, 2); // Total nilai transaksi
            $table->string('payment_method'); // Metode pembayaran, misalnya, Tunai, transfer bank, kartu kredit, dll.
            $table->enum('payment_status', ['Paid', 'Unpaid', 'Partial']); // Status pembayaran
            $table->string('expense_category')->nullable(); // Kategori pengeluaran jika transaksi adalah pengeluaran
            $table->text('additional_notes')->nullable(); // Keterangan atau detail tambahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_transactions');
    }
}
