<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct() {}
    public function create()
    {
        return view('auth.login');
    }
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $client = new Client();

        try {
            $response = $client->post(env('API_URL') . 'login', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'email' => $request->validated()['email'],
                    'password' => $request->validated()['password'],
                ],
            ]);

            $data = json_decode($response->getBody());

            if ($data->status == 'success') {
                if (Auth::attempt($credentials)) {
                    Session::put('token', $data->data[0]);
                    Session::put('user', Auth::user());

                    if ($data->data[1] === 'admin') {
                        return redirect()->route('admin.dashboard')->withSuccess('Đăng nhập thành công với quyền Admin!');
                    } else {
                        return redirect()->route('home')->withSuccess('Đăng nhập thành công!');
                    }
                } else {
                    return redirect()->back()->withErrors([
                        'email' => 'Đăng nhập thất bại, không thể khởi tạo phiên.',
                    ])->withInput();
                }
            } else {
                return redirect()->back()->withErrors($data->message ?? 'Thông tin đăng nhập không hợp lệ.')->withInput();
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->getCode() === 400) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseBodyArray = json_decode($responseBody);
                //dd($responseBodyArray->message);
                Session::flash('error', $responseBodyArray->message);
                return redirect()->back();
            }
            return redirect()->back()->withErrors([
                'email' => 'Đã xảy ra lỗi không xác định. Vui lòng thử lại sau.',
            ])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'email' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
            ])->withInput();
        }
    }



    public function clearSession()
    {
        Session::forget('token');
        Session::forget('user');
        return redirect()->route('home')->withSuccess('Đã xóa session');
    }

    public function logout()
    {
        $client = new Client();
        $token = Session::get('token');

        if (!$token) {
            return redirect()->back()->withErrors(['error' => 'Vui lòng đăng nhập trước khi đăng xuất'])->withInput();
        }

        try {
            $response = $client->post(env('API_URL') . 'logout', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);

                if ($data['status'] === 'success') {

                    Session::forget('token');
                    Session::forget('user');
                    Auth::guard('web')->logout();

                    toastr()->success('Đăng xuất thành công');
                    return redirect()->route('home');
                } else {
                    return redirect()->back()->withErrors($data['errors'] ?? 'Lỗi không xác định')->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Đăng xuất thất bại. Vui lòng thử lại sau'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Không thể kết nối đến API: ' . $e->getMessage()])->withInput();
        }
    }
}
