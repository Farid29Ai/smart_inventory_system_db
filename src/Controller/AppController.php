<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    /**
     * Basic role gate for the admin and staff portals.
     *
     * @param \Cake\Event\EventInterface $event Event object.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $controller = (string)$this->request->getParam('controller');
        $action = (string)$this->request->getParam('action');
        $role = $this->request->getSession()->read('Auth.Role');

        $publicRoutes = [
            'Pages' => ['display'],
            'Login' => ['index', 'logout'],
            'Admin' => ['login', 'logout', 'dashboard', 'forgotPassword', 'resetPassword'],
            'Staff' => ['login', 'logout', 'dashboard', 'forgotPassword', 'resetPassword'],
        ];

        if (in_array($action, $publicRoutes[$controller] ?? [], true)) {
            return null;
        }

        if ($role === 'admin') {
            return null;
        }

        if ($role === 'staff') {
            $staffRoutes = [
                'Item' => ['index', 'view'],
                'Category' => ['index', 'view'],
                'Vendor' => ['index', 'view'],
                'Requisition' => ['index', 'view', 'add', 'edit', 'delete'],
                'RequisitionItem' => ['index', 'view', 'add', 'edit'],
                'Staff' => ['view', 'edit'],
            ];

            if (in_array($action, $staffRoutes[$controller] ?? [], true)) {
                return null;
            }

            $this->Flash->error(__('This page is for admin users.'));

            return $this->redirect(['controller' => 'Staff', 'action' => 'dashboard']);
        }

        $this->Flash->error(__('Please login first.'));

        return $this->redirect('/');
    }

    /**
     * Share the signed-in user details with every template.
     *
     * @param \Cake\Event\EventInterface $event Event object.
     * @return void
     */
    public function beforeRender(\Cake\Event\EventInterface $event): void
    {
        parent::beforeRender($event);

        $session = $this->request->getSession();
        $this->set('currentUser', $session->read('Auth.User'));
        $this->set('currentRole', $session->read('Auth.Role'));
    }

    /**
     * Store an uploaded image and return a browser-friendly relative path.
     *
     * @param string $field Form field name.
     * @param string $folder Upload subfolder.
     * @return string|null
     */
    protected function uploadImage(string $field, string $folder): ?string
    {
        $file = $this->request->getData($field);
        if (!$file || !method_exists($file, 'getError') || $file->getError() !== UPLOAD_ERR_OK) {
            return null;
        }

        $clientName = (string)$file->getClientFilename();
        $extension = strtolower(pathinfo($clientName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($extension, $allowedExtensions, true)) {
            $this->Flash->error(__('Please upload an image file only.'));

            return null;
        }

        $uploadDir = WWW_ROOT . 'uploads' . DS . $folder . DS;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $filename = $folder . '-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $extension;
        $file->moveTo($uploadDir . $filename);

        return '/uploads/' . $folder . '/' . $filename;
    }
}
