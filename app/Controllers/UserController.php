<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google_Client;
use Google_Service_Oauth2;
use App\Models\UsersModel;

class UserController extends Controller
{
    protected $db;
    protected $googleClient;
    protected $users;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = new UsersModel();

        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId('1025060015631-spaaterv7ohes6p15lvaistiveg3kc09.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri(base_url('login/proses'));
        $this->googleClient->setScopes(['email', 'profile']);
    }

    private function getUserData()
    {
        $googleId = session()->get('google_id');
        $userData = $this->users
            ->where('id', $googleId)
            ->get()
            ->getRow();

        return $userData;
    }

    public function showLoginForm()
    {
        $data['link'] = $this->googleClient->createAuthUrl();
        return view('auth/index', $data);
    }

    public function showRegisterForm()
    {
        $data['link'] = $this->googleClient->createAuthUrl();
        return view('auth/register', $data);
    }

    public function index()
    {
        $userData = $this->getUserData();
        return view('dashboard/dashboard', ['userData' => $userData]);
    }

    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }
        $userData = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'role' => 'siswa',
        ];
        $this->users->insert($userData);
        return redirect()->to('/login')->with('success', 'Pengguna berhasil mendaftar');
    }

    public function proses()
    {
        $code = $this->request->getVar('code');
        if (!$code) {
            return redirect()->to('/login')->with('error', 'Otorisasi Google gagal');
        }
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        if (!isset($token['error'])) {
            $this->googleClient->setAccessToken($token['access_token']);
            $googleService = new Google_Service_Oauth2($this->googleClient);
            $userData = $googleService->userinfo->get();
            $existingUser = $this->users->where('google_id', $userData->getId())->get()->getRow();
            $userId = null;
            if (!$existingUser) {
                // Jika pengguna belum ada, tambahkan pengguna baru
                $userId = $this->users->saveUserData($userData);
            } else {
                // Jika pengguna sudah ada, gunakan ID pengguna yang sudah ada
                $userId = $existingUser->id;
            }
            session()->set('google_id', $userId);
            return redirect()->to('/course');
        } else {
            return redirect()->to('/login')->with('error', 'Otorisasi Google gagal');
        }
    }

    public function showProfile()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        $userId = session()->get('google_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();
        if (!$userData) {
            return redirect()->to('/login')->with('error', 'Data pengguna tidak ditemukan.');
        }

        return view('users/index', ['userData' => $userData]);
    }

    public function logout()
    {
        session()->remove('google_id');
        return redirect()->to('/');
    }
}
