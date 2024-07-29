<?php

namespace Core\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use LogsActivity;
    use Notifiable;

    protected $table = "tl_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'status'
    ];

    /**
     * Will return notification
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }

    /**
     * Get the entity's unread notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->hasOne(\Plugin\Multivendor\Models\SellerShop::class, 'seller_id');
    }

    public function sellerPayoutInfo()
    {
        return $this->hasOne(\Plugin\Multivendor\Models\SellerPayoutInfo::class, 'seller_id');
    }

    public function sellerWithdrawableBalance()
    {
        if (isActivePlugin('multivendor-cartlooks')) {

            $total_earning = \Plugin\Multivendor\Models\SellerEarnings::where('seller_id', $this->id)
                ->where('status', config('cartlookscore.seller_earning_status.approve'))
                ->sum('earning');

            $total_payout = \Plugin\Multivendor\Models\SellerPayoutRequests::where('seller_id', $this->id)
                ->whereNot('status', config('multivendor-cartlooks.payout_request_status.cancelled'))
                ->sum('amount');

            return $total_earning - $total_payout;
        } else {
            return 0;
        }
    }
    /**
     * Set activity log data 
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'image',
                'status'
            ]);
    }
}
