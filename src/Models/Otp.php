<?php

namespace BenBjurstrom\Otpz\Models;

use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\InvalidAuthenticatableModel;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;
use BenBjurstrom\Otpz\Support\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

/**
 * @property OtpStatus $status
 * @property string $code
 * @property bool $remember
 * @property int $attempts
 * @property int|string $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class Otp extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OtpStatus::class,
        'code' => 'hashed',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'status',
        'ip_address',
    ];

    /**
     * @return BelongsTo<Model&Otpable, $this>
     *
     * @throws InvalidAuthenticatableModel
     */
    public function user(): BelongsTo
    {
        $authenticatableModel = Config::getAuthenticatableModel();

        return $this->belongsTo($authenticatableModel);
    }

    public function getUrlAttribute(): string
    {
        return URL::temporarySignedRoute('otp.show', now()->addMinutes(5), [
            'id' => $this->id,
            'session' => request()->session()->getId(),
        ]);
    }
}
