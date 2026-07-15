<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\AdminTable $Admin
 */
class AdminController extends AppController
{
    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function dashboard()
    {
        if ($this->request->getSession()->read('Auth.Role') !== 'admin') {
            $this->Flash->error(__('Please login as admin first.'));

            return $this->redirect(['action' => 'login']);
        }

        $requisitionTable = $this->fetchTable('Requisition');
        $itemTable = $this->fetchTable('Item');
        $staffTable = $this->fetchTable('Staff');
        $vendorTable = $this->fetchTable('Vendor');
        $requisitionItemTable = $this->fetchTable('RequisitionItem');
        $today = date('Y-m-d');

        $stats = [
            'items' => $itemTable->find()->count(),
            'staff' => $staffTable->find()->count(),
            'categories' => $this->fetchTable('Category')->find()->count(),
            'vendors' => $vendorTable->find()->count(),
            'requisitions' => $requisitionTable->find()->count(),
            'pending' => $requisitionTable->find()
                ->where(['status IN' => ['Pending', 'pending', 'Open', 'open', 'New', 'new']])
                ->count(),
            'approved' => $requisitionTable->find()
                ->where(['status IN' => ['Approved', 'approved']])
                ->count(),
            'lowStock' => $itemTable->find()
                ->where(['quantity_available <= minimum_stock'])
                ->count(),
            'transactions' => $this->fetchTable('StockTransaction')->find()->count(),
            'todayRequests' => $requisitionTable->find()
                ->where(['request_date' => $today])
                ->count(),
        ];
        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($requisitionTable->find()->select(['request_date'])->all() as $request) {
            if ($request->request_date) {
                $monthlyCounts[(int)$request->request_date->format('n')]++;
            }
        }
        $monthlyRequestLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyRequestValues = array_values($monthlyCounts);

        $requestedItems = [];
        foreach ($requisitionItemTable->find()->contain(['Items'])->all() as $line) {
            $itemName = (string)($line->item->item_name ?? ('Item #' . $line->item_id));
            $requestedItems[$itemName] = ($requestedItems[$itemName] ?? 0) + (int)($line->quantity_requested ?? 0);
        }
        arsort($requestedItems);
        $topRequestedItems = array_slice($requestedItems, 0, 5, true);

        $vendorStats = [];
        foreach ($itemTable->find()->contain(['Vendors'])->all() as $item) {
            $vendorName = (string)($item->vendor->vendor_name ?? 'Unassigned');
            $vendorStats[$vendorName] = ($vendorStats[$vendorName] ?? 0) + 1;
        }
        arsort($vendorStats);

        $recentRequisitions = $this->fetchTable('Requisition')->find()
            ->contain(['Staffs'])
            ->orderByDesc('request_date')
            ->orderByDesc('requisition_id')
            ->limit(5)
            ->all();

        $this->set(compact('stats', 'recentRequisitions', 'monthlyRequestLabels', 'monthlyRequestValues', 'topRequestedItems', 'vendorStats'));
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        if ($this->request->getSession()->read('Auth.Role') === 'admin') {
            return $this->redirect(['action' => 'dashboard']);
        }

        if ($this->request->is('post')) {
            $email = (string)$this->request->getData('email');
            $password = (string)$this->request->getData('password');
            $adminEntity = $this->Admin->find()
                ->where(['email' => $email])
                ->first();

            if ($adminEntity && $this->passwordMatches($password, (string)$adminEntity->password)) {
                $this->request->getSession()->write('Auth', [
                    'Role' => 'admin',
                    'User' => [
                    'id' => $adminEntity->admin_id,
                    'name' => $adminEntity->admin_name,
                    'email' => $adminEntity->email,
                    'image' => $adminEntity->profile_image,
                ],
            ]);
                $this->Flash->success(__('Welcome back, {0}.', $adminEntity->admin_name));

                return $this->redirect(['action' => 'dashboard']);
            }

            $this->Flash->error(__('Invalid admin email or password.'));
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
     * Forgot password method for admin accounts.
     *
     * @return \Cake\Http\Response|null|void Redirects to reset form when email is found.
     */
    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = trim((string)$this->request->getData('email'));
            $adminEntity = $this->Admin->find()
                ->where(['email' => $email])
                ->first();

            if (!$adminEntity) {
                $this->Flash->error(__('No admin account found with this email.'));

                return null;
            }

            $this->request->getSession()->write('PasswordReset.Admin', [
                'id' => $adminEntity->admin_id,
                'email' => $adminEntity->email,
            ]);

            return $this->redirect(['action' => 'resetPassword']);
        }
    }

    /**
     * Reset password method for admin accounts.
     *
     * @return \Cake\Http\Response|null|void Redirects to login after successful reset.
     */
    public function resetPassword()
    {
        $session = $this->request->getSession();
        $resetData = (array)$session->read('PasswordReset.Admin');

        if (empty($resetData['id'])) {
            $this->Flash->error(__('Please enter your registered admin email first.'));

            return $this->redirect(['action' => 'forgotPassword']);
        }

        $adminEntity = $this->Admin->get($resetData['id']);

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
                $adminEntity->password = password_hash($password, PASSWORD_DEFAULT);

                if ($this->Admin->save($adminEntity)) {
                    $session->delete('PasswordReset.Admin');
                    $this->Flash->success(__('Password has been reset successfully. Please login again.'));

                    return $this->redirect(['action' => 'login']);
                }

                $this->Flash->error(__('Password could not be reset. Please, try again.'));
            }
        }

        $this->set(compact('adminEntity'));
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
        $query = $this->Admin->find();
        $admin = $this->paginate($query);

        $this->set(compact('admin'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $adminEntity = $this->Admin->get($id, contain: []);
        $this->set(compact('adminEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $adminEntity = $this->Admin->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $imagePath = $this->uploadImage('profile_image', 'admins');
            if ($imagePath) {
                $data['profile_image'] = $imagePath;
            } else {
                unset($data['profile_image']);
            }
            $adminEntity = $this->Admin->patchEntity($adminEntity, $data);
            if ($this->Admin->save($adminEntity)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('adminEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $adminEntity = $this->Admin->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $imagePath = $this->uploadImage('profile_image', 'admins');
            if ($imagePath) {
                $data['profile_image'] = $imagePath;
            } else {
                unset($data['profile_image']);
            }
            $adminEntity = $this->Admin->patchEntity($adminEntity, $data);
            if ($this->Admin->save($adminEntity)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('adminEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $adminEntity = $this->Admin->get($id);
        if ($this->Admin->delete($adminEntity)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
