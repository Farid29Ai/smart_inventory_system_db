<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Item Controller
 *
 * @property \App\Model\Table\ItemTable $Item
 */
class ItemController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $keyword = trim((string)$this->request->getQuery('keyword', ''));
        $categoryId = $this->request->getQuery('category_id');
        if ($this->request->getSession()->read('Auth.Role') === 'admin') {
            $this->paginate = [
                'limit' => 12,
                'maxLimit' => 12,
                'order' => [
                    'Item.item_id' => 'ASC',
                ],
            ];
        }

        $query = $this->Item->find()
            ->contain(['Categories', 'Vendors'])
            ->leftJoinWith('Categories')
            ->leftJoinWith('Vendors')
            ->distinct(['Item.item_id']);

        if ($categoryId !== null && $categoryId !== '') {
            $query->where(['Item.category_id' => (int)$categoryId]);
        }

        if ($keyword !== '') {
            $likeKeyword = '%' . $keyword . '%';
            $query->where([
                'OR' => [
                    'Item.item_name LIKE' => $likeKeyword,
                    'Categories.category_name LIKE' => $likeKeyword,
                    'Vendors.vendor_name LIKE' => $likeKeyword,
                ],
            ]);
        }

        $item = $this->paginate($query);
        $categories = $this->Item->Categories->find('list', [
            'keyField' => 'category_id',
            'valueField' => 'category_name',
        ])->orderByAsc('category_name')->toArray();

        $this->set(compact('item', 'categories', 'keyword', 'categoryId'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemEntity = $this->Item->get($id, contain: ['Categories', 'Vendors', 'Requisition']);
        $this->set(compact('itemEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemEntity = $this->Item->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $imagePath = $this->uploadImage('item_image', 'items');
            if ($imagePath) {
                $data['item_image'] = $imagePath;
            } else {
                unset($data['item_image']);
            }
            $itemEntity = $this->Item->patchEntity($itemEntity, $data);
            if ($this->Item->save($itemEntity)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $categories = $this->Item->Categories->find('list', limit: 200)->all();
        $vendors = $this->Item->Vendors->find('list', limit: 200)->all();
        $requisition = $this->Item->Requisition->find('list', limit: 200)->all();
        $this->set(compact('itemEntity', 'categories', 'vendors', 'requisition'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemEntity = $this->Item->get($id, contain: ['Requisition']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $imagePath = $this->uploadImage('item_image', 'items');
            if ($imagePath) {
                $data['item_image'] = $imagePath;
            } else {
                unset($data['item_image']);
            }
            $itemEntity = $this->Item->patchEntity($itemEntity, $data);
            if ($this->Item->save($itemEntity)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $categories = $this->Item->Categories->find('list', limit: 200)->all();
        $vendors = $this->Item->Vendors->find('list', limit: 200)->all();
        $requisition = $this->Item->Requisition->find('list', limit: 200)->all();
        $this->set(compact('itemEntity', 'categories', 'vendors', 'requisition'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemEntity = $this->Item->get($id);
        if ($this->Item->delete($itemEntity)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
