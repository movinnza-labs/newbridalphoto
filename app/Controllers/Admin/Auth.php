<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    // ── Login form ────────────────────────────────────────────────────
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/admin/');
        }

        return view('admin/login', [
            'title'      => 'Login — The Bridal Admin',
            'flashError' => session()->getFlashdata('error'),
        ]);
    }

    // ── Check credentials ─────────────────────────────────────────────
    public function attempt()
    {
        $login    = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($login === '' || $password === '') {
            session()->setFlashdata('error', 'Please enter username and password.');
            return redirect()->to('/admin/login/')->withInput();
        }

        // Username or email both accepted
        $user = db_connect()->table('users')
            ->groupStart()
                ->where('username', $login)
                ->orWhere('email', $login)
            ->groupEnd()
            ->where('is_active', 1)
            ->get()->getRowArray();

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            session()->setFlashdata('error', 'Invalid username or password.');
            return redirect()->to('/admin/login/')->withInput();
        }

        session()->regenerate(true);
        session()->set([
            'admin_id'    => (int) $user['id'],
            'admin_email' => $user['email'],
        ]);

        return redirect()->to('/admin/');
    }

    // ── Logout ────────────────────────────────────────────────────────
    public function logout()
    {
        session()->remove(['admin_id', 'admin_email']);
        session()->regenerate(true);

        return redirect()->to('/admin/login/');
    }
}
