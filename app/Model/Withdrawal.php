<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    //
     /**
     * Set status to Pending
     *
     * @return void
     */
    public function setQueued()
    {
        $this->attributes['status'] = 'queued';
        self::save();
    }

    public function setapproved()
    {
        $this->attributes['status'] = 'approved';
        self::save();
    }

    public function setrejected()
    {
        $this->attributes['status'] = 'rejected';
        self::save();
    }
 
    /**
     * Set status to Success
     *
     * @return void
     */
    public function setprocessed()
    {
        $this->attributes['status'] = 'processed';
        self::save();
    }
 
    /**
     * Set status to Failed
     *
     * @return void
     */
    public function setcompleted()
    {
        $this->attributes['status'] = 'completed';
        self::save();
    }
 
    /**
     * Set status to Expired
     *
     * @return void
     */
    public function setfailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }
}
