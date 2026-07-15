<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Category Controller
 *
 * @property \App\Model\Table\CategoryTable $Category
 */
class CategoryController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Category->find();
        $category = $this->paginate($query);

        $this->set(compact('category'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoryEntity = $this->Category->get($id, contain: []);
        $this->set(compact('categoryEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoryEntity = $this->Category->newEmptyEntity();
        if ($this->request->is('post')) {
            $categoryEntity = $this->Category->patchEntity($categoryEntity, $this->request->getData());
            if ($this->Category->save($categoryEntity)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('categoryEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoryEntity = $this->Category->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoryEntity = $this->Category->patchEntity($categoryEntity, $this->request->getData());
            if ($this->Category->save($categoryEntity)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('categoryEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoryEntity = $this->Category->get($id);
        if ($this->Category->delete($categoryEntity)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
