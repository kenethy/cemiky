<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // HAPUS constructor injection, biarkan kosong
    public function __construct() {}

    public function index()
    {
        // Gunakan langsung di method
        $subscriptions = SubscriptionPlan::all();
        return view('subscriptions', [
            'subscriptions' => $subscriptions,
            'title' => 'Subscription Plans'
        ]);    }

    // Metode untuk mengarahkan user ke website resmi
    public function visit($id)
    {
        $subscription = SubscriptionPlan::findOrFail($id);
        return redirect()->away($subscription->website);
    }
}
