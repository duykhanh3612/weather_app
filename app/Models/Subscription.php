<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'city',
        'is_subscribed',
        'unsubscribe_token'
    ];

    // Thêm phương thức để tạo token
    public function generateUnsubscribeToken()
    {
        $this->unsubscribe_token = bin2hex(random_bytes(16));
        $this->save();
    }
}
