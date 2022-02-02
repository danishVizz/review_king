<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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


    public function getUser($posted_data = array())
    {
        $query = User::latest();

        if (isset($posted_data['name'])) {
            $query = $query->where('name', 'like', '%' . $posted_data['name'] . '%');
        }
        if (isset($posted_data['id'])) {
            $query = $query->where('id', $posted_data['id']);
        }
        if (isset($posted_data['phone_no'])) {
            $query = $query->where('phone_no', $posted_data['phone_no']);
        }
        if (isset($posted_data['role'])) {
            $query = $query->where('role', $posted_data['role']);
        }

        $query->select('*');
        
        $query->getQuery()->orders = null;
        if (isset($posted_data['orderBy_name'])) {
            $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
        } else {
            $query->orderBy('id', 'ASC');
        }

        if (isset($posted_data['paginate'])) {
            $result = $query->paginate($posted_data['paginate']);
        } else {
            if (isset($posted_data['detail'])) {
                $result = $query->first();
            } else if (isset($posted_data['count'])) {
                $result = $query->count();
            } else {
                $result = $query->get();
            }
        }
        return $result;
    }



    public function saveUpdateUser($posted_data = array())
    {
        if (isset($posted_data['update_id'])) {
            $data = User::find($posted_data['update_id']);
        } else {
            $data = new User;
        }

        if (isset($posted_data['name'])) {
            $data->name = $posted_data['name'];
        }
        if (isset($posted_data['email'])) {
            $data->email = $posted_data['email'];
        }
        if (isset($posted_data['password'])) {
            $data->password = Hash::make($posted_data['password']);
        }
        if (isset($posted_data['role'])) {
            $data->role = $posted_data['role'];
        }
        if (isset($posted_data['phone_no'])) {
            $data->phone_no = $posted_data['phone_no'];
        }
        if (isset($posted_data['rating_link'])) {
            $data->rating_link = $posted_data['rating_link'];
        }
        $data->save();
        return $data->id;
    }

    public function deleteUser($id=0)
    {
        $data = User::find($id);
        return $data->delete();
    }
}