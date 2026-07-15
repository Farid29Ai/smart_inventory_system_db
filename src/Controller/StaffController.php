<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Staff Controller
 *
 * @property \App\Model\Table\StaffTable $Staff
 */
class StaffController extends AppController
{
    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function dashboard()
    {
        if ($this->request->getSession()->read('Auth.Role') !== 'staff') {
            $this->Flash->error(__('Please login as staff first.'));

            return $this->redirect(['action' => 'login']);
        }

        $staffId = $this->request->getSession()->read('Auth.User.id');
        $requisitionTable = $this->fetchTable('Requisition');
        $stats = [
            'items' => $this->fetchTable('Item')->find()->count(),
            'myRequisitions' => $requisitionTable->find()
                ->where(['staff_id' => $staffId])
                ->count(),
            'pending' => $requisitionTable->find()
                ->where(['staff_id' => $staffId, 'status IN' => ['Pending', 'pending', 'Open', 'open']])
                ->count(),
            'approved' => $requisitionTable->find()
                ->where(['staff_id' => $staffId, 'status IN' => ['Approved', 'approved']])
                ->count(),
            'rejected' => $requisitionTable->find()
                ->where(['staff_id' => $staffId, 'status IN' => ['Rejected', 'rejected']])
                ->count(),
        ];
        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($requisitionTable->find()->select(['request_date'])->where(['staff_id' => $staffId])->all() as $request) {
            if ($request->request_date) {
                $monthlyCounts[(int)$request->request_date->format('n')]++;
            }
        }
        $monthlyRequestLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyRequestValues = array_values($monthlyCounts);
        $recentRequisitions = $requisitionTable->find()
            ->where(['staff_id' => $staffId])
            ->orderByDesc('request_date')
            ->orderByDesc('requisition_id')
            ->limit(5)
            ->all();

        $this->set(compact('stats', 'recentRequisitions', 'monthlyRequestLabels', 'monthlyRequestValues'));
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        if ($this->request->getSession()->read('Auth.Role') === 'staff') {
            return $this->redirect(['action' => 'dashboard']);
        }

        if ($this->request->is('post')) {
            $email = (string)$this->request->getData('email');
            $password = (string)$this->request->getData('password');
            $staffEntity = $this->Staff->find()
                ->where(['email' => $email])
                ->first();

            if ($staffEntity && $this->passwordMatches($password, (string)$staffEntity->password)) {
                $this->request->getSession()->write('Auth', [
                    'Role' => 'staff',
                    'User' => [
                    'id' => $staffEntity->staff_id,
                    'name' => $staffEntity->staff_name,
                    'email' => $staffEntity->email,
                    'image' => $staffEntity->profile_image,
                ],
            ]);
                $this->Flash->success(__('Welcome back, {0}.', $staffEntity->staff_name));

                return $this->redirect(['action' => 'dashboard']);
            }

            $this->Flash->error(__('Invalid staff email or password.'));
        }
    }

    /**
     * Logout method
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
     * Forgot password method for staff accounts.
     *
     * @return \Cake\Http\Response|null|void Redirects to reset form when email is found.
     */
    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = trim((string)$this->request->getData('email'));
            $staffEntity = $this->Staff->find()
                ->where(['email' => $email])
                ->first();

            if (!$staffEntity) {
                $this->Flash->error(__('No staff account found with this email.'));

                return null;
            }

            $this->request->getSession()->write('PasswordReset.Staff', [
                'id' => $staffEntity->staff_id,
                'email' => $staffEntity->email,
            ]);

            return $this->redirect(['action' => 'resetPassword']);
        }
    }

    /**
     * Reset password method for staff accounts.
     *
     * @return \Cake\Http\Response|null|void Redirects to login after successful reset.
     */
    public function resetPassword()
    {
        $session = $this->request->getSession();
        $resetData = (array)$session->read('PasswordReset.Staff');

        if (empty($resetData['id'])) {
            $this->Flash->error(__('Please enter your registered staff email first.'));

            return $this->redirect(['action' => 'forgotPassword']);
        }

        $staffEntity = $this->Staff->get($resetData['id']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $password = (string)$this->request->getData('password');
            $confirmPassword = (string)$this->request->getData('confirm_password');

            if ($password === '') {
                $this->Flash->error(__('New password cannot be empty.'));
            } elseif (strlen($password) < 6) {
                $this->Flash->error(__('Password must be at least 6 characters.'));
            } elseif ($password !== $confirmPassword) {
                $this->Flash->error(__('Confirm password must match new password.'));
            } else {
                $staffEntity->password = password_hash($password, PASSWORD_DEFAULT);

                if ($this->Staff->save($staffEntity)) {
                    $session->delete('PasswordReset.Staff');
                    $this->Flash->success(__('Password has been reset successfully. Please login again.'));

                    return $this->redirect(['action' => 'login']);
                }

                $this->Flash->error(__('Password could not be reset. Please, try again.'));
            }
        }

        $this->set(compact('staffEntity'));
    }

    /**
     * Check both hashed and legacy plain-text passwords.
     *
     * @param string $password Password from login form.
     * @param string $storedPassword Password from database.
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Staff->find();
        $staff = $this->paginate($query);

        $this->set(compact('staff'));
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if (
            $this->request->getSession()->read('Auth.Role') === 'staff' &&
            (int)$id !== (int)$this->request->getSession()->read('Auth.User.id')
        ) {
            $this->Flash->error(__('You can only view your own profile.'));

            return $this->redirect(['action' => 'dashboard']);
        }

        $staffEntity = $this->Staff->get($id, contain: []);
        $this->set(compact('staffEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $staffEntity = $this->Staff->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $imagePath = $this->uploadImage('profile_image', 'staff');
            if ($imagePath) {
                $data['profile_image'] = $imagePath;
            } else {
                unset($data['profile_image']);
            }
            $staffEntity = $this->Staff->patchEntity($staffEntity, $data);
            if ($this->Staff->save($staffEntity)) {
                $this->Flash->success(__('The staff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staffEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->request->getSession()->read('Auth.Role');
        $currentStaffId = (int)$this->request->getSession()->read('Auth.User.id');
        if ($role === 'staff' && (int)$id !== $currentStaffId) {
            $this->Flash->error(__('You can only edit your own profile.'));

            return $this->redirect(['action' => 'dashboard']);
        }

        $staffEntity = $this->Staff->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ($role === 'staff') {
                $data = array_intersect_key($data, array_flip([
                    'staff_name',
                    'email',
                    'phone_no',
                    'department',
                    'position',
                    'profile_image',
                    'password',
                ]));
            }
            unset($data['confirm_password']);
            if (($data['password'] ?? '') === '') {
                unset($data['password']);
            }
            $imagePath = $this->uploadImage('profile_image', 'staff');
            if ($imagePath) {
                $data['profile_image'] = $imagePath;
            } else {
                unset($data['profile_image']);
            }
            $staffEntity = $this->Staff->patchEntity($staffEntity, $data);
            if ($this->Staff->save($staffEntity)) {
                $this->Flash->success(__('The staff has been saved.'));

                if ($role === 'staff') {
                    $this->request->getSession()->write('Auth.User', [
                        'id' => $staffEntity->staff_id,
                        'name' => $staffEntity->staff_name,
                        'email' => $staffEntity->email,
                        'image' => $staffEntity->profile_image,
                    ]);

                    return $this->redirect(['action' => 'view', $staffEntity->staff_id]);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staffEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $staffEntity = $this->Staff->get($id);
        if ($this->Staff->delete($staffEntity)) {
            $this->Flash->success(__('The staff has been deleted.'));
        } else {
            $this->Flash->error(__('The staff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
