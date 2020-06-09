<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Fillable attribute.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'kode',
        'product_id',
        'tenant_id',
        'amount',
        'note',
    ];
 
    /**
     * Set status to Pending
     *
     * @return void
     */
    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }
 
    /**
     * Set status to Success
     *
     * @return void
     */
    public function setSuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }
 
    /**
     * Set status to Failed
     *
     * @return void
     */
    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }
 
    /**
     * Set status to Expired
     *
     * @return void
     */
    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }
}
