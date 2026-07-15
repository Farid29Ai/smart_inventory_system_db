<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RequisitionItem Controller
 *
 * @property \App\Model\Table\RequisitionItemTable $RequisitionItem
 */
class RequisitionItemController extends AppController
{
    /**
     * Fields accepted from the requisition item form.
     *
     * @var array<string>
     */
    private array $requisitionItemFields = [
        'requisition_id',
        'item_id',
        'quantity_requested',
        'quantity_approved',
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->RequisitionItem->find()
            ->contain(['Requisitions', 'Items']);
        $requisitionItem = $this->paginate($query);

        $this->set(compact('requisitionItem'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisition Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisitionItemEntity = $this->RequisitionItem->get($id, contain: ['Requisitions', 'Items']);
        $this->set(compact('requisitionItemEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisitionItemEntity = $this->RequisitionItem->newEmptyEntity();
        if ($this->request->is('post')) {
            $requisitionItemEntity = $this->RequisitionItem->patchEntity($requisitionItemEntity, $this->request->getData(), [
                'fields' => $this->requisitionItemFields,
            ]);
            if ($this->RequisitionItem->save($requisitionItemEntity)) {
                $this->Flash->success(__('The requisition item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisition item could not be saved. Please, try again.'));
        }
        $requisitions = $this->RequisitionItem->Requisitions->find('list', limit: 200)->all();
        $items = $this->RequisitionItem->Items->find('list', limit: 200)->all();
        $this->set(compact('requisitionItemEntity', 'requisitions', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisition Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisitionItemEntity = $this->RequisitionItem->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requisitionItemEntity = $this->RequisitionItem->patchEntity($requisitionItemEntity, $this->request->getData(), [
                'fields' => $this->requisitionItemFields,
            ]);
            if ($this->RequisitionItem->save($requisitionItemEntity)) {
                $this->Flash->success(__('The requisition item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisition item could not be saved. Please, try again.'));
        }
        $requisitions = $this->RequisitionItem->Requisitions->find('list', limit: 200)->all();
        $items = $this->RequisitionItem->Items->find('list', limit: 200)->all();
        $this->set(compact('requisitionItemEntity', 'requisitions', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisition Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requisitionItemEntity = $this->RequisitionItem->get($id);
        if ($this->RequisitionItem->delete($requisitionItemEntity)) {
            $this->Flash->success(__('The requisition item has been deleted.'));
        } else {
            $this->Flash->error(__('The requisition item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
