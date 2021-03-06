<?php
    namespace App;
    use Illuminate\Database\Eloquent\Model;
    use App\User;
    use App\UserType;

    class Customer extends Model
    {
        protected $table = 'customer';
        public $timestamps = false;

        /**
         * Customer Related User
         * @return mixed
         */
        public function user()
        {
            return $this->hasOne('App\User', 'user_id', 'id')->where('user_type_id', '=', UserType::CUSTOMER())->first();

        }

        public function treatments()
        {
            return $this->hasMany('App\Treatment', 'customer_id', 'id');

        }

        public function professionals()
        {
            return $this->belongsToMany('App\Professional', 'customer_professional');
        }

    }
