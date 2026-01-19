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
                Schema::create('orders', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade')->onUpdate('cascade');
                    $table->foreignId('technician_id')->nullable()->references('id')->on('technicians')->constrained()->onDelete('cascade')->onUpdate('cascade');
                    $table->enum('device_type', ['hp','laptop','tablet']);
                    $table->string('brand');
                    $table->text('issue_description');
                    $table->text('address');
                    $table->date('schedule_date');
                    $table->enum('status', ['pending','on_process','completed','cancelled']);
                    $table->integer('estimated_cost')->nullable();
                    $table->integer('final_cost')->nullable();
                    $table->text('photo')->nullable();
                    $table->text('notes')->nullable();
                    $table->timestamps();
                    $table->timestamp('completed_at')->nullable();
                    $table->timestamp('cancelled_at')->nullable();
                    $table->softdeletes('deleted_at')->nullable();

                });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('orders');
        }
    };
