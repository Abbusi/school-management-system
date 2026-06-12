<?php

namespace Hrshadhin\Userstamps;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserstampsTrait
{
    /**
     * Boot the userstamps trait for a model.
     *
     * @return void
     */
    public static function bootUserstampsTrait()
    {
        $observer = new UserstampsTraitObserver;
        static::creating(function ($model) use ($observer) {
            $observer->creating($model);
        });
        static::updating(function ($model) use ($observer) {
            $observer->updating($model);
        });
        static::saving(function ($model) use ($observer) {
            $observer->saving($model);
        });
        static::deleting(function ($model) use ($observer) {
            $observer->deleting($model);
        });
        if (method_exists(static::class, 'restoring')) {
            static::restoring(function ($model) use ($observer) {
                $observer->restoring($model);
            });
        }
    }

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getCreatedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getUpdatedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    /**
     * Get user model who deleted the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getDeletedByColumn());
    }

    /**
     * Get column name for deleted by.
     *
     * @return string
     */
    protected function getDeletedByColumn()
    {
        return 'deleted_by';
    }

    /**
     * Get created by user name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        if ($this->{$this->getCreatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getCreatedByColumn()});

            return $user ? $user->name : '';
        }

        return '';
    }

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUserInstance()
    {
        $class = config('auth.providers.users.model', User::class);

        return new $class;
    }

    /**
     * Get updated by user name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        if ($this->{$this->getUpdatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getUpdatedByColumn()});

            return $user ? $user->name : '';
        }

        return '';
    }

    /**
     * Get deleted by user name.
     *
     * @return string
     */
    public function getDeletedByNameAttribute()
    {
        if ($this->{$this->getDeletedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getDeletedByColumn()});

            return $user ? $user->name : '';
        }

        return '';
    }
}


