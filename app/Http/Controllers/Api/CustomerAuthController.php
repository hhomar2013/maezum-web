<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required',
            'phone'    => 'required',
            'address'  => 'required',
        ]);

        $customer = customers::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'location' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // $token = $customer->createToken('CustomerToken')->plainTextToken;

        return response()->json([
            'message'  => __('Done Login Successfully'),
            // 'token' => $token,
            'customer' => $customer,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $customer = customers::where('email', $request->email)->first();

        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }

        $token = $customer->createToken('CustomerToken')->plainTextToken;
        if ($token) {
            $customer->fcm_token = $token;
            $customer->save();
        }
        return response()->json([
            'message'  => __('Done Login Successfully'),
            'token'    => $token,
            'customer' => $customer,
        ]);
    }

    public function show(Request $request)
    {
        return response()->json([
            'customer' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);
        $customer = auth('api')->user();
        if ($customer) {
            $customer->update([
                'fcm_token' => $request->fcm_token,
            ]);
            return response()->json(['message' => 'Token updated successfully']);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
