<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerOrder extends Model
{
    use HasFactory;

    public function getCustomerOrder($posted_data = array())
    {
        $query = CustomerOrder::latest();

        if (isset($posted_data['company_name'])) {
            $query = $query->where('users.name', 'like', '%' . $posted_data['company_name'] . '%');
        }
        if (isset($posted_data['phone_number_like'])) {
            $query = $query->where('customer_orders.phone_number', 'like', '%' . $posted_data['phone_number_like'] . '%');
        }
        if (isset($posted_data['phone_number'])) {
            $query = $query->where('customer_orders.phone_number',  $posted_data['phone_number']);
        }
        if (isset($posted_data['id'])) {
            $query = $query->where('customer_orders.id', $posted_data['id']);
        }
        if (isset($posted_data['slug'])) {
            $query = $query->where('customer_orders.slug', $posted_data['slug']);
        }
        if (isset($posted_data['status'])) {
            $query = $query->where('customer_orders.status', $posted_data['status']);
        }
        if (isset($posted_data['user_id'])) {
            $query = $query->where('customer_orders.user_id', $posted_data['user_id']);
        }

        
        $query->join('users', 'users.id', '=', 'customer_orders.user_id');        
        $query->leftJoin('renew_stampcards', function($join)
        {
            $join->on('renew_stampcards.user_id', '=', 'customer_orders.user_id');
            $join->on('renew_stampcards.phone_number', '=', 'customer_orders.phone_number');
        });

        $query->getQuery()->orders = null;
        if (isset($posted_data['orderBy_name'])) {
            $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
        } else {
            $query->orderBy('id', 'ASC');
        }

        
        if (isset($posted_data['groupBy'])) {
            $query->select(DB::raw('renew_stampcards.total_renew_orders, renew_stampcards.stampcard_count, customer_orders.*, users.name as user_name, count(*) as total_orders'));
            $query->groupBy($posted_data['groupBy']);
            if (isset($posted_data['groupBy2'])) {
                $query->groupBy($posted_data['groupBy2']);
            }
        }else{
            $query->select('customer_orders.*', 'users.name as user_name', 'renew_stampcards.stampcard_count');
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



    public function saveUpdateCustomerOrder($posted_data = array())
    {
        if (isset($posted_data['update_id'])) {
            $data = CustomerOrder::find($posted_data['update_id']);
        } else {
            $data = new CustomerOrder;
        }

        if (isset($posted_data['phone_number'])) {
            $data->phone_number = $posted_data['phone_number'];
        }
        if (isset($posted_data['slug'])) {
            $data->slug = $posted_data['slug'];
        }
        if (isset($posted_data['status'])) {
            $data->status = $posted_data['status'];
        }
        if (isset($posted_data['user_id'])) {
            $data->user_id = $posted_data['user_id'];
        }
        
        $data->save();
        return $data->id;
    }



    public function renew_stampcard($posted_data = array())
    {
        $data = CustomerOrder::where('phone_number', $posted_data['phone_number'])->where('user_id', $posted_data['user_id'])->update(['status'=> 1]);
        return true;
    }
    
}