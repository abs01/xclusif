<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('post_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            
            $table->timestamps();
        });
        DB::unprepared('CREATE TRIGGER trg_after_like_insert
        AFTER INSERT ON likes
        FOR EACH ROW
        BEGIN
         DECLARE user_tier_id BIGINT;
         DECLARE monetization_flag TINYINT(1);
         DECLARE pay INT DEFAULT 1;
         DECLARE amount DECIMAL(10,2) DEFAULT 0;

         SELECT tier_id INTO user_tier_id
         FROM users
         WHERE id = NEW.user_id;

         SELECT comments_required INTO pay
         FROM tiers
         WHERE id = user_tier_id;

         SELECT monetization INTO monetization_flag
         FROM tiers
         WHERE id = user_tier_id;
        

        IF monetization_flag > 0 THEN
             IF user_tier_id = 2 THEN
                 SET amount = 1/pay + 0.3;
             ELSEIF user_tier_id = 3 THEN
                 SET amount = 1/pay;
             END IF;
        END IF;

         IF amount > 0 THEN
             INSERT INTO earnings (user_id, post_id, amount, created_at, updated_at)
             VALUES (
                 (SELECT user_id FROM posts WHERE id = NEW.post_id),
                 NEW.post_id,
                 amount,
                 NOW(),
                 NOW()
             );
         END IF;
        END;
');

    }

    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
