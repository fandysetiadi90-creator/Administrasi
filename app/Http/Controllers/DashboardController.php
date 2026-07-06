<?php

namespace App\Http\Controllers;

use App\Models\AkunModel;
use App\Models\PenggunaModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {

        $currentUser = Auth::user();
        $totalUsers = PenggunaModel::count();
        $usersWithAccount = PenggunaModel::has('akun')->count();
        $usersWithoutAccount = PenggunaModel::doesntHave('akun')->count();
        $totalAccounts = AkunModel::count();
        $newUsersToday = PenggunaModel::whereDate('created_at', today())->count();
        $accountCoverage = $totalUsers > 0
            ? round(($usersWithAccount / $totalUsers) * 100)
            : 0;
        $latestUsers = PenggunaModel::with('akun')
            ->latest('created_at')
            ->limit(5)
            ->get();
        $usersPendingAccount = PenggunaModel::doesntHave('akun')
            ->latest('created_at')
            ->limit(5)
            ->get();
        $latestAccounts = AkunModel::with('pengguna')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'currentUser',
            'totalUsers',
            'usersWithAccount',
            'usersWithoutAccount',
            'totalAccounts',
            'newUsersToday',
            'accountCoverage',
            'latestUsers',
            'usersPendingAccount',
            'latestAccounts'
        ));
    }
}
