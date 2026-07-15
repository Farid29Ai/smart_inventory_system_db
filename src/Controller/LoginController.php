<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Login Controller
 */
class LoginController extends AppController
{
    /**
     * Unified login for admin and staff.
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $role = $this->request->getSession()->read('Auth.Role');
        if ($role === 'admin') {
            return $this->redirect(['controller' => 'Admin', 'action' => 'dashboard']);
        }
        if ($role === 'staff') {
            return $this->redirect(['controller' => 'Staff', 'action' => 'dashboard']);
        }

        if ($this->request->is('post')) {
            $email = (string)$this->request->getData('email');
            $password = (string)$this->request->getData('password');

            $admin = $this->fetchTable('Admin')->find()
                ->where(['email' => $email])
                ->first();
            if ($admin && $this->passwordMatches($password, (string)$admin->password)) {
                $this->request->getSession()->write('Auth', [
                    'Role' => 'admin',
                    'User' => [
                        'id' => $admin->admin_id,
                        'name' => $admin->admin_name,
                        'email' => $admin->email,
                        'image' => $admin->profile_image,
                    ],
                ]);

                return $this->redirect(['controller' => 'Admin', 'action' => 'dashboard']);
            }

            $staff = $this->fetchTable('Staff')->find()
                ->where(['email' => $email])
                ->first();
            if ($staff && $this->passwordMatches($password, (string)$staff->password)) {
                $this->request->getSession()->write('Auth', [
                    'Role' => 'staff',
                    'User' => [
                        'id' => $staff->staff_id,
                        'name' => $staff->staff_name,
                        'email' => $staff->email,
                        'image' => $staff->profile_image,
                    ],
                ]);

                return $this->redirect(['controller' => 'Staff', 'action' => 'dashboard']);
            }

            $this->Flash->error(__('Invalid email or password.'));
        }
    }

    /**
     * Logout method.
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->request->getSession()->delete('Auth');
        $this->Flash->success(__('You have been logged out.'));

        return $this->redirect('/');
    }

    /**
     * Check hashed and legacy plain text passwords.
     *
     * @param string $password Password from form.
     * @param string $storedPassword Stored password.
     * @return bool
     */
    private function passwordMatches(string $password, string $storedPassword): bool
    {
        $passwordInfo = password_get_info($storedPassword);
        if ($passwordInfo['algo'] !== 0 && $passwordInfo['algo'] !== null) {
            return password_verify($password, $storedPassword);
        }

        return hash_equals($storedPassword, $password);
    }
}
