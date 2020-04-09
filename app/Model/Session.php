<?php 

namespace Model;

class Session extends \Illuminate\Database\Eloquent\Model {

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}