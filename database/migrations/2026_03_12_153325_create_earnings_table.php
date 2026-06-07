<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xcoins', function (Blueprint $table) {
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
  DECLARE already_rewarded INT DEFAULT 0;

  -- Verificar si este user ya había dado like antes a este post
  --si el usuario se encuentra en la tabla xcoins con el mismo post_id, significa que ya se le ha recompensado por ese post, entonces no se le recompensa de nuevo
  -- select count(*) sirve para que el resultado sea 0 en caso de que no haya registros, y así proceder con la monetización de forma normal.
  SELECT COUNT(*) INTO already_rewarded
  FROM xcoins
  WHERE user_id = (SELECT user_id FROM posts WHERE id = NEW.post_id)
    AND post_id = NEW.post_id;

  -- Solo continuar si nunca se ha recompensado
  IF already_rewarded = 0 THEN
    SELECT tier_id INTO user_tier_id FROM users WHERE id = NEW.user_id;
    SELECT interactions_required INTO pay FROM tiers WHERE id = user_tier_id;
    SELECT monetization INTO monetization_flag FROM tiers WHERE id = user_tier_id;

    IF monetization_flag > 0 THEN
      SET amount = 1 / pay;
    END IF;

    IF amount > 0 THEN
      INSERT INTO xcoins (user_id, post_id, amount, created_at, updated_at)
      VALUES (
        (SELECT user_id FROM posts WHERE id = NEW.post_id),
        NEW.post_id,
        amount,
        NOW(),
        NOW()
      );
    END IF;
  END IF;
END;
');

    }

    public function down(): void
    {
        Schema::dropIfExists('xcoins');
    }
};
