<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Vendor Controller
 *
 * @property \App\Model\Table\VendorTable $Vendor
 */
class VendorController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Vendor->find();
        $vendor = $this->paginate($query);

        $this->set(compact('vendor'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendorEntity = $this->Vendor->get($id, contain: []);
        $this->set(compact('vendorEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendorEntity = $this->Vendor->newEmptyEntity();
        if ($this->request->is('post')) {
            $vendorEntity = $this->Vendor->patchEntity($vendorEntity, $this->request->getData());
            if ($this->Vendor->save($vendorEntity)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendorEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendorEntity = $this->Vendor->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendorEntity = $this->Vendor->patchEntity($vendorEntity, $this->request->getData());
            if ($this->Vendor->save($vendorEntity)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendorEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendorEntity = $this->Vendor->get($id);
        if ($this->Vendor->delete($vendorEntity)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
