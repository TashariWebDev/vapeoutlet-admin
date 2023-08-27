<?php

use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('order_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('order_id');
        });

        Tag::updateOrCreate(['name' => 'awaiting payment']);
        Tag::updateOrCreate(['name' => 'own courier']);
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('order_tag');
    }
};
