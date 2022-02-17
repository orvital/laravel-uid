<?php

namespace Orvital\Uid\Traits;

use Orvital\Uid\Ulid;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasUlid
{
    /**
     * Bootstraper called once on the static model.
     */
    public static function bootHasUlid(): void
    {
        static::creating(function (self $model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = new Ulid();
            }
        });

        /**
         * Prevent changing the model key manually by always keeping the original value.
         * Done this way instead of using the model $guarded property as it triggers an additional database query.
         */
        static::saving(function (self $model) {
            $originalKey = $model->getOriginal($model->getKeyName());
            if ($originalKey !== $model->getKey()) {
                $model->{$model->getKeyName()} = $originalKey;
            }
        });
    }

    /**
     * Initializer called on each new model instance.
     * Traits can't override class properties and using getter methods won't update underlying class properties.
     */
    public function initializeHasUlid(): void
    {
        // Set the primary key type as string and incrementing property as false.
        $this->setKeyType('string')->setIncrementing(false);
    }

    /**
     * Get the model key as a Ulid instance
     */
    public function getUlidAttribute(): Ulid
    {
        // WARN: Do not convert toBase58(), it looses the original sort order!
        return Ulid::fromString($this->getKey());
    }
}
