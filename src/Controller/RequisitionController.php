<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;

/**
 * Requisition Controller
 *
 * @property \App\Model\Table\RequisitionTable $Requisition
 */
class RequisitionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $role = $this->request->getSession()->read('Auth.Role');
        $staffId = $this->request->getSession()->read('Auth.User.id');
        $query = $this->Requisition->find()
            ->contain(['Staffs', 'Admins', 'Item']);

        if ($role === 'staff') {
            $query->where(['Requisition.staff_id' => $staffId]);
        }

        $requisition = $this->paginate($query);

        $this->set(compact('requisition'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisitionEntity = $this->Requisition->get($id, contain: ['Staffs', 'Admins', 'Item']);
        if (
            $this->request->getSession()->read('Auth.Role') === 'staff' &&
            (int)$requisitionEntity->staff_id !== (int)$this->request->getSession()->read('Auth.User.id')
        ) {
            $this->Flash->error(__('This requisition belongs to another staff account.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('requisitionEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisitionEntity = $this->Requisition->newEmptyEntity();
        $selectedItemId = $this->request->getQuery('item_id');
        $selectedItemIds = $selectedItemId ? [(int)$selectedItemId] : [];

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $selectedItemIds = array_values(array_filter(array_map('intval', (array)($data['item']['_ids'] ?? []))));
            $quantityRequested = (int)($data['quantity_requested'] ?? 0);
            unset($data['item'], $data['quantity_requested']);

            if ($selectedItemIds === [] || $quantityRequested < 1) {
                $this->Flash->error(__('Please select an item and enter a quantity requested of at least 1.'));
            } else {
                $requisitionEntity = $this->Requisition->patchEntity($requisitionEntity, $data);
                if ($this->Requisition->save($requisitionEntity)) {
                    $requisitionItems = [];
                    foreach ($selectedItemIds as $itemId) {
                        $requisitionItems[] = $this->fetchTable('RequisitionItem')->newEntity([
                            'requisition_id' => $requisitionEntity->requisition_id,
                            'item_id' => $itemId,
                            'quantity_requested' => $quantityRequested,
                        ]);
                    }
                    $this->fetchTable('RequisitionItem')->saveMany($requisitionItems);
                    $this->Flash->success(__('The requisition has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The requisition could not be saved. Please, try again.'));
            }
        }
        $staffs = $this->Requisition->Staffs->find('list', limit: 200)->all();
        $admins = $this->Requisition->Admins->find('list', limit: 200)->all();
        $item = $this->Requisition->Item->find('list', limit: 200)->all();
        $this->set(compact('requisitionEntity', 'staffs', 'admins', 'item', 'selectedItemIds'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisitionEntity = $this->Requisition->get($id, contain: ['Item']);
        if ($this->request->getSession()->read('Auth.Role') === 'staff') {
            $staffId = (int)$this->request->getSession()->read('Auth.User.id');
            if ((int)$requisitionEntity->staff_id !== $staffId) {
                $this->Flash->error(__('You are not allowed to edit this request.'));

                return $this->redirect(['action' => 'index']);
            }

            if (strtolower((string)($requisitionEntity->status ?: 'Pending')) !== 'pending') {
                $this->Flash->error(__('Only pending requests can be edited.'));

                return $this->redirect(['action' => 'view', $id]);
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $selectedItemIds = array_values(array_filter(array_map('intval', (array)($data['item']['_ids'] ?? []))));
            $quantityRequested = (int)($data['quantity_requested'] ?? 0);
            unset($data['item'], $data['quantity_requested']);

            if ($selectedItemIds === [] || $quantityRequested < 1) {
                $this->Flash->error(__('Please select an item and enter a quantity requested of at least 1.'));
            } else {
                $requisitionEntity = $this->Requisition->patchEntity($requisitionEntity, $data);
                if ($this->Requisition->save($requisitionEntity)) {
                    $requisitionItemTable = $this->fetchTable('RequisitionItem');
                    $requisitionItemTable->deleteAll([
                        'requisition_id' => $requisitionEntity->requisition_id,
                        'item_id NOT IN' => $selectedItemIds,
                    ]);

                    foreach ($selectedItemIds as $itemId) {
                        $requisitionItemEntity = $requisitionItemTable->find()
                            ->where([
                                'requisition_id' => $requisitionEntity->requisition_id,
                                'item_id' => $itemId,
                            ])
                            ->first() ?: $requisitionItemTable->newEmptyEntity();

                        $requisitionItemEntity = $requisitionItemTable->patchEntity($requisitionItemEntity, [
                            'requisition_id' => $requisitionEntity->requisition_id,
                            'item_id' => $itemId,
                            'quantity_requested' => $quantityRequested,
                        ]);
                        $requisitionItemTable->save($requisitionItemEntity);
                    }

                    $this->Flash->success(__('The requisition has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The requisition could not be saved. Please, try again.'));
            }
        }
        $staffs = $this->Requisition->Staffs->find('list', limit: 200)->all();
        $admins = $this->Requisition->Admins->find('list', limit: 200)->all();
        $item = $this->Requisition->Item->find('list', limit: 200)->all();
        $this->set(compact('requisitionEntity', 'staffs', 'admins', 'item'));
    }

    /**
     * Approve method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null
     */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post']);
        if ($this->request->getSession()->read('Auth.Role') !== 'admin') {
            $this->Flash->error(__('Only admin users can approve requisitions.'));

            return $this->redirect(['action' => 'index']);
        }

        $requisitionEntity = $this->Requisition->get($id);
        $currentStatus = strtolower((string)($requisitionEntity->status ?: 'Pending'));
        if ($currentStatus !== 'pending') {
            $this->Flash->error(__('Only pending requisitions can be approved.'));

            return $this->redirect(['action' => 'index']);
        }

        $adminId = (int)$this->request->getSession()->read('Auth.User.id');
        $requisitionItemTable = $this->fetchTable('RequisitionItem');
        $itemsTable = $this->fetchTable('Item');
        $stockTransactionTable = $this->fetchTable('StockTransaction');
        $requisitionItems = $requisitionItemTable->find()
            ->contain(['Items'])
            ->where(['requisition_id' => $requisitionEntity->requisition_id])
            ->all();

        try {
            $this->Requisition->getConnection()->transactional(function () use (
                $requisitionEntity,
                $requisitionItems,
                $requisitionItemTable,
                $itemsTable,
                $stockTransactionTable,
                $adminId
            ): void {
                foreach ($requisitionItems as $line) {
                    $approvedQuantity = (int)($line->quantity_approved ?: $line->quantity_requested);
                    if ($approvedQuantity < 1) {
                        throw new \RuntimeException(__('Approved quantity must be at least 1.'));
                    }

                    $item = $itemsTable->get($line->item_id);
                    $availableQuantity = (int)($item->quantity_available ?? 0);
                    if ($approvedQuantity > $availableQuantity) {
                        throw new \RuntimeException(__('Insufficient stock quantity.'));
                    }

                    $item->quantity_available = $availableQuantity - $approvedQuantity;
                    if (!$itemsTable->save($item)) {
                        throw new \RuntimeException(__('Unable to update item stock quantity.'));
                    }

                    if (!$line->quantity_approved) {
                        $line->quantity_approved = $approvedQuantity;
                        if (!$requisitionItemTable->save($line)) {
                            throw new \RuntimeException(__('Unable to update approved quantity.'));
                        }
                    }

                    $itemName = $line->hasValue('item') ? $line->item->item_name : ('Item #' . $line->item_id);
                    $stockTransaction = $stockTransactionTable->newEntity([
                        'item_id' => $line->item_id,
                        'admin_id' => $adminId,
                        'transaction_type' => 'Stock Out',
                        'quantity' => $approvedQuantity,
                        'transaction_date' => DateTime::now(),
                        'remarks' => sprintf(
                            'Auto generated from approved requisition #%s for %s.',
                            (string)$requisitionEntity->requisition_id,
                            (string)$itemName
                        ),
                    ]);

                    if (!$stockTransactionTable->save($stockTransaction)) {
                        throw new \RuntimeException(__('Unable to create stock transaction record.'));
                    }
                }

                $requisitionEntity->status = 'Approved';
                $requisitionEntity->admin_id = $adminId;
                if (!$this->Requisition->save($requisitionEntity)) {
                    throw new \RuntimeException(__('Unable to approve requisition.'));
                }
            });
            $this->Flash->success(__('Requisition approved successfully.'));
        } catch (\RuntimeException $exception) {
            $this->Flash->error($exception->getMessage());
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reject method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null
     */
    public function reject($id = null)
    {
        $this->request->allowMethod(['post']);
        if ($this->request->getSession()->read('Auth.Role') !== 'admin') {
            $this->Flash->error(__('Only admin users can reject requisitions.'));

            return $this->redirect(['action' => 'index']);
        }

        $requisitionEntity = $this->Requisition->get($id);
        $currentStatus = strtolower((string)($requisitionEntity->status ?: 'Pending'));
        if ($currentStatus !== 'pending') {
            $this->Flash->error(__('Only pending requisitions can be rejected.'));

            return $this->redirect(['action' => 'index']);
        }

        $requisitionEntity->status = 'Rejected';
        $requisitionEntity->admin_id = $this->request->getSession()->read('Auth.User.id');
        if ($this->Requisition->save($requisitionEntity)) {
            $this->Flash->success(__('Requisition rejected successfully.'));
        } else {
            $this->Flash->error(__('Unable to reject requisition.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requisitionEntity = $this->Requisition->get($id);
        $role = $this->request->getSession()->read('Auth.Role');

        if ($role === 'staff') {
            $staffId = (int)$this->request->getSession()->read('Auth.User.id');
            if ((int)$requisitionEntity->staff_id !== $staffId) {
                $this->Flash->error(__('You are not allowed to delete this request.'));

                return $this->redirect(['action' => 'index']);
            }

            if (strtolower((string)($requisitionEntity->status ?: 'Pending')) !== 'pending') {
                $this->Flash->error(__('Only pending requests can be deleted.'));

                return $this->redirect(['action' => 'view', $id]);
            }
        }

        $connection = $this->Requisition->getConnection();
        $deleted = false;
        $connection->transactional(function () use ($requisitionEntity, &$deleted): void {
            $this->fetchTable('RequisitionItem')->deleteAll([
                'requisition_id' => $requisitionEntity->requisition_id,
            ]);
            $deleted = (bool)$this->Requisition->delete($requisitionEntity);
        });

        if ($deleted) {
            $this->Flash->success($role === 'staff' ? __('Request deleted successfully.') : __('The requisition has been deleted.'));
        } else {
            $this->Flash->error($role === 'staff' ? __('Unable to delete request. Please try again.') : __('The requisition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
