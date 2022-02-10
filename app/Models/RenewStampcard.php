<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewStampcard extends Model
{
    use HasFactory;

    public function getRenewStampcard($posted_data = array())
    {
        $query = RenewStampcard::latest();

        if (isset($posted_data['phone_number'])) {
            $query = $query->where('phone_number',  $posted_data['phone_number']);
        }
        if (isset($posted_data['user_id'])) {
            $query = $query->where('user_id', $posted_data['user_id']);
        }
        if (isset($posted_data['stampcard_count'])) {
            $query = $query->where('stampcard_count', $posted_data['stampcard_count']);
        }
        if (isset($posted_data['total_renew_orders'])) {
            $query = $query->where('total_renew_orders', $posted_data['total_renew_orders']);
        }
        
        $query->getQuery()->orders = null;
        if (isset($posted_data['orderBy_name'])) {
            $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
        } else {
            $query->orderBy('id', 'ASC');
        }

        $query->select('*');


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



    public function saveUpdateRenewStampcard($posted_data = array())
    {
        if (isset($posted_data['update_id'])) {
            $data = RenewStampcard::find($posted_data['update_id']);
        } else {
            $data = new RenewStampcard;
        }

        if (isset($posted_data['phone_number'])) {
            $data->phone_number = $posted_data['phone_number'];
        }
        if (isset($posted_data['stampcard_count'])) {
            $data->stampcard_count = $posted_data['stampcard_count'];
        }
        if (isset($posted_data['total_renew_orders'])) {
            $data->total_renew_orders = $posted_data['total_renew_orders'];
        }
        if (isset($posted_data['user_id'])) {
            $data->user_id = $posted_data['user_id'];
        }
        
        $data->save();
        return $data->id;
    }
}