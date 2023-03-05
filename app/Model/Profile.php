<?php

namespace App\Models;

use App\Models\Traits\ProfileAccountantTrait;
use App\Models\Traits\ProfileDataTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use SoftDeletes;

    use ProfileDataTableTrait;
    use ProfileAccountantTrait;

    const PERMISSION_CREATE = 'profiles_create';
    const PERMISSION_UPDATE = 'profiles_update';

    const DANG_KY_MOI = 0;
    const DA_GOI = 1;
    const DAT_LICH_TU_VAN = 2;
    const DA_DANG_KY = 3;
    const MUON_COC = 4;
    const DEN_KHONG_DANG_KY = 5;
    const KHONG_TIEM_NANG = 6;

    const STATUS_LIST = [
        self::DANG_KY_MOI => 'Đăng ký mới',
        self::DA_GOI => 'Đã gọi',
        self::DAT_LICH_TU_VAN => 'Đặt lịch Tư vấn',
        self::DA_DANG_KY => 'Đã đăng ký',
        self::MUON_COC => 'Mượn cọc',
        self::DEN_KHONG_DANG_KY => 'Đến không đăng ký',
        self::KHONG_TIEM_NANG => 'Không tiềm năng'
    ];

    protected static function booted()
    {
        static::creating(function ($profile) {
            $profile->fill([
                'marketer_id' => Auth::id()
            ]);
        });

        static::updating(function ($profile) {
            $profile->fill([
                'tele_sale_id' => Auth::id()
            ]);
        });
    }

    protected $fillable = [
        'name', 'phone', 'email', 'address', 'city_id', 'district_id', 'appointment_time', 'status_id', 'marketer_id', 'tele_sale_id', 'note',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
        'appointment_time' => 'datetime:d/m/Y H:i',
    ];

    /** Relationship n - 1 */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function marketer()
    {
        return $this->belongsTo('App\Models\User', 'marketer_id', 'id')->permission(self::PERMISSION_CREATE);
    }

    public function tele_sale()
    {
        return $this->belongsTo('App\Models\User', 'tele_sale_id', 'id')->permission(self::PERMISSION_UPDATE);
    }

    /** Relationship 1 - n */
    public function accountants()
    {
        return $this->hasMany('App\Models\Accountant');
    }

    public function paid_fee()
    {
        return $this->hasMany('App\Models\Accountant')->where('type_id', Accountant::INCOME_ID);
    }

    public function deposited_fee()
    {
        return $this->hasOne('App\Models\Accountant')->where('type_id', Accountant::DEPOSIT_ID);
    }

    /** Helper Functions */
    public function getFullAddressAttribute()
    {
        $fullAddress = '';
        if (!empty($this->address)) {
            $fullAddress .= $this->address;
        }

        if ($this->district) {
            $fullAddress .= (!empty($fullAddress) ? ', ' : '') . $this->district->name;
        }
        if ($this->city) {
            $fullAddress .= (!empty($fullAddress) ? ', ' : '') . $this->city->name;
        }

        return $fullAddress;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = \standardize_profile_phone($value);
    }

    public function getPhoneListAttribute()
    {
        return \phone_str_to_array($this->phone);
    }

    //if Status la DK Moi ==> so sanh created_at
    //elseif status là đặt lịch hẹn ==> so sanh lịch hen (appointment_time)
    // So sánh updated_at
    public function scopeFilterDate(Builder $query, $from_date = null, $to_date = null)
    {
        if ($from_date && $to_date) {
            return $query->where(function ($secondQuery) use ($from_date, $to_date) {
                $secondQuery->orWhere(function ($newRegisterQuery) use ($from_date, $to_date) {
                    $newRegisterQuery->where('status_id', self::DANG_KY_MOI)->whereBetween('created_at', [$from_date, $to_date]);
                })->orWhere(function ($appointmentQuery) use ($from_date, $to_date) {
                    $appointmentQuery->where('status_id', self::DAT_LICH_TU_VAN)->whereBetween('appointment_time', [$from_date, $to_date]);
                })->orWhere(function ($otherQuery) use ($from_date, $to_date) {
                    $otherQuery->whereNotIn('status_id', [self::DANG_KY_MOI, self::DAT_LICH_TU_VAN])->whereBetween('updated_at', [$from_date, $to_date]);
                });
            });
        } elseif (!$from_date && $to_date) {
            return $query->where(function ($secondQuery) use ($to_date) {
                $secondQuery->orWhere(function ($newRegisterQuery) use ($to_date) {
                    $newRegisterQuery->where('status_id', self::DANG_KY_MOI)->whereDate('created_at', '<=', $to_date);
                })->orWhere(function ($appointmentQuery) use ($to_date) {
                    $appointmentQuery->where('status_id', self::DAT_LICH_TU_VAN)->whereDate('appointment_time', '<=', $to_date);
                })->orWhere(function ($otherQuery) use ($to_date) {
                    $otherQuery->whereNotIn('status_id', [self::DANG_KY_MOI, self::DAT_LICH_TU_VAN])->whereDate('updated_at', '<=', $to_date);
                });
            });
        } elseif (!$to_date && $from_date) {
            return $query->where(function ($secondQuery) use ($from_date) {
                $secondQuery->orWhere(function ($newRegisterQuery) use ($from_date) {
                    $newRegisterQuery->where('status_id', self::DANG_KY_MOI)->whereDate('created_at', '>=', $from_date);
                })->orWhere(function ($appointmentQuery) use ($from_date) {
                    $appointmentQuery->where('status_id', self::DAT_LICH_TU_VAN)->whereDate('appointment_time', '>=', $from_date);
                })->orWhere(function ($otherQuery) use ($from_date) {
                    $otherQuery->whereNotIn('status_id', [self::DANG_KY_MOI, self::DAT_LICH_TU_VAN])->whereDate('updated_at', '>=', $from_date);
                });
            });
        }

        return $query;
    }

    public function scopeFilterPhone(Builder $builder, $phone)
    {
        if (!is_array($phone)) {
            $phoneList = \phone_str_to_array($phone);
        } else {
            $phoneList = $phone;
        }

        $builder->where(function ($phoneQuery) use ($phoneList) {
            foreach ($phoneList as $phoneItem) {
                $phoneQuery->orWhere('phone', 'LIKE', '%' . $phoneItem . '%');
            }
        });
    }
}
