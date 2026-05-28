<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Contenido principal
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable(); // Los famosos "balazos" de la nota
            $table->longText('content');

            // Multimedia
            $table->string('image_banner')->nullable(); // Imagen principal de la noticia
            $table->string('image_caption')->nullable(); // Pie de foto (créditos del fotógrafo)

            // Métricas y SEO
            $table->unsignedBigInteger('views_count')->default(0); // Para medir el tráfico de la nota
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();

            // Control Editorial (Estados)
            // Valores: 'draft' (borrador), 'review' (en revisión), 'published' (publicado)
           // Reemplaza la línea vieja por esta:
            $table->enum('status', ['draft', 'review', 'published'])->default('draft');

            // Fechas cruciales para el orden cronológico
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexar campos que usarás todo el tiempo para buscar y ordenar
            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
