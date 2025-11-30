<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexCustomer()
    {
        // Ambil user yang role-nya pelanggan
        $customers = User::where('role', 'pelanggan')->latest()->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function destroyCustomer(User $user)
    {
        if($user->role !== 'pelanggan') return back()->with('error', 'Tidak bisa hapus admin/kasir disini');
        $user->delete();
        return back()->with('success', 'Pelanggan dihapus');
    }
}