<?php

namespace Orvital\Uid\Traits;

use Illuminate\Database\Eloquent\Model;
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
        static::creating(function (Model $model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = new Ulid();
            }
        });
    }

    /**
     * Initializer called on each new model instance.
     * Traits can't override class properties and using getter methods won't update underlying class properties.
     */
    public function initializeHasUlid(): void
    {
        $primaryKey = $this->getKeyName();

        // Set the primary key type as string and incrementing property as false.
        $this->setKeyType('string')->setIncrementing(false);

        // Guard model key from mass assignment.
        if (!$this->isGuarded($primaryKey)) {
            $this->mergeGuarded([$primaryKey]);
        }
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
