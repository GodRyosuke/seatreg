<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use LdapRecord\Connection as LdapConnection;
use LdapRecord\Container as LdapContainer;

use Spatie\Permission\Traits\HasRoles;

use \Carbon\Carbon;

use Cache;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ocuid', 'primaryid', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relations
    public function registRecords()
    {
        return $this->hasMany('App\RegistRecord');
    }
    public function seats()
    {
        return $this->hasManyThrough('App\Seat', 'App\RegistRecord', 'user_id', 'id', null, 'seat_id');
    }

    /**
     * LDAP からユーザ情報を取得
     *
     * @param  string $uid
     * @return string
     */
    public static function getUserInfoFromLDAP($uid)
    {
        $minutes = 5; // 5 minutes
        $ldapconfig = config('ldap')['connections']['default'];

        $result =  Cache::remember('ldap_user_info:' . $uid, $minutes, function() use ($ldapconfig, $uid) {
            $connection = new LdapConnection($ldapconfig);
            try {
                $connection->connect();
                $query = $connection->query();
                $result = $query->where('uid', $uid)->first();
                return $result;
            } catch (\LdapRecord\Auth\BindException $e) {
                $error = $e->getDetailedError();
                return null;
            }
        });
        return $result;
    }

    /**
     *  SSO によりログインされている ID の取得
     *
     * @param  none
     * @return string
     */
    public static function getPrimaryIdFromSSO()
    {
        return $_SERVER['HTTP_SSOID'] ?? null;
    }

    /**
     * LDAP からユーザ情報を取得
     *
     * @param  string $key
     * @return string
     */
    public function getLDAPAttribute(string $key)
    {
        $result = self::getUserInfoFromLDAP($this->primaryid);
        return $result[$key][0];
    }

    /**
     * LDAP 情報からユーザデータベースを更新
     *
     * @param  string $key
     * @return string
     */
    public function updateUserFromLDAP()
    {
        $result = self::getUserInfoFromLDAP($this->primaryid);
        if (!$result) {
            return;
        }
        $this->name = $result['kanjiname'][0] ?? null;
        $this->kana = mb_convert_kana($result['kananame'][0], 'KV')  ?? null;
//        $this->romaji = $result[''][0];
        $this->code_u = $result['usertypecode1'][0] ?? null;
        $this->name_u = $result['usertypename1'][0] ?? null;
        $this->code_e = $result['employeetypecode1'][0] ?? null;
        $this->name_e = $result['nbunruiname'][0] ?? null;
        $this->code_p = $result['postcode1'][0] ?? null;
        $this->name_p = $result['npostname'][0] ?? null;
        $this->code_d = $result['deptlv2code1'][0] ?? null;
        $this->name_d = $result['deptlv2name1'][0] ?? null;
        $this->email = $result['mailaddress1'][0] ?? null;
        $this->ocumail = $result['o365mailaddress'][0] ?? null;
        $this->ocualias = $result['o365aliasname'][0] ?? null;
        $this->o365flag = $result['o365proplusflg'][0] ?? null;
        if ($this->isStudent()) {
            $this->ocuid = $this->primaryid;
        } else {
            $this->ocuid = $result['ssonsyokuinno'][0] ?? null;
        }
        $this->started_at = Carbon::createFromFormat('Ymd', $result['startdate'][0])->startOfDay() ?? null;
        $this->moved_at = Carbon::createFromFormat('Ymd', $result['changedate'][0] ?? '20200101')->startOfDay() ?? null;
//        $this->expired_by = $result['startdate'][0];
        $this->save();
    }
    
    public static function getOcuidFromLDAP($result)
    {
        $code_u = (int)($result['usertypecode1'][0] ?? 1);
        if ($code_u < 10) {
            return $result['uid'][0] ?? null;
        } else {
            return $result['ssonsyokuinno'][0] ?? null;
        }

    }

    public function isStudent()
    {
        $code = (int)$this->code_u;
        return ($code < 10);
    }
    
    public function isFaculty()
    {
        $code = (int)$this->code_u;
        return ($code == 61);
    }
    
    public function isPermanent()
    {
        $code = (int)$this->code_u;
        return ($code == 61 || $code == 71);
    }

}
