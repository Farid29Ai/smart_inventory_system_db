<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;

/**
 * StockTransaction Controller
 *
 * @property \App\Model\Table\StockTransactionTable $StockTransaction
 */
class StockTransactionController extends AppController
{
    /**
     * Normalize stock transaction type labels used by forms and existing data.
     *
     * @param string|null $type Transaction type.
     * @return string
     */
    private function normalizeTransactionType(?string $type): string
    {
        $normalized = strtolower(trim((string)$type));
        $normalized = str_replace(['_', '-'], ' ', $normalized);

        return match ($normalized) {
            'in', 'stock in' => 'Stock In',
            'out', 'stock out' => 'Stock Out',
            'adjustment', 'adjust' => 'Adjustment',
            default => trim((string)$type),
        };
    }

    /**
     * Apply stock movement for a newly created transaction.
     *
     * @param int $itemId Item id.
     * @param string $type Transaction type.
     * @param int $quantity Quantity.
     * @return bool
     */
    private function applyStockMovement(int $itemId, string $type, int $quantity): bool
    {
        $item = $this->StockTransaction->Items->get($itemId);
        $currentQuantity = (int)($item->quantity_available ?? 0);
        $type = $this->normalizeTransactionType($type);

        if ($quantity < 1) {
            throw new \RuntimeException(__('Quantity must be at least 1.'));
        }

        if ($type === 'Stock In') {
            $item->quantity_available = $currentQuantity + $quantity;
        } elseif ($type === 'Stock Out') {
            if ($quantity > $currentQuantity) {
                throw new \RuntimeException(__('Insufficient stock quantity.'));
            }
            $item->quantity_available = $currentQuantity - $quantity;
        } elseif ($type === 'Adjustment') {
            $item->quantity_available = $quantity;
        }

        if (!$this->StockTransaction->Items->save($item)) {
            throw new \RuntimeException(__('Unable to update item stock quantity.'));
        }

        return true;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->StockTransaction->find()
            ->contain(['Items', 'Admins']);
        $stockTransaction = $this->paginate($query);

        $this->set(compact('stockTransaction'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockTransactionEntity = $this->StockTransaction->get($id, contain: ['Items', 'Admins']);
        $this->set(compact('stockTransactionEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stockTransactionEntity = $this->StockTransaction->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['admin_id'] = $this->request->getSession()->read('Auth.User.id');
            $data['transaction_type'] = $this->normalizeTransactionType($data['transaction_type'] ?? '');
            if (empty($data['transaction_date'])) {
                $data['transaction_date'] = DateTime::now();
            }
            $quantity = (int)($data['quantity'] ?? 0);
            $itemId = (int)($data['item_id'] ?? 0);
            $specificError = false;

            try {
                $connection = $this->StockTransaction->getConnection();
                $saved = $connection->transactional(function () use (&$stockTransactionEntity, $data, $itemId, $quantity): bool {
                    $this->applyStockMovement($itemId, (string)$data['transaction_type'], $quantity);

                $stockTransactionEntity = $this->StockTransaction->patchEntity($stockTransactionEntity, $data);

                    if (!$this->StockTransaction->save($stockTransactionEntity)) {
                        throw new \RuntimeException(__('The stock transaction could not be saved. Please, try again.'));
                    }

                    return true;
                });
            } catch (\RuntimeException $exception) {
                $saved = false;
                $specificError = true;
                $this->Flash->error($exception->getMessage());
            }

            if ($saved) {
                $this->Flash->success(__('Stock transaction saved successfully.'));

                return $this->redirect(['action' => 'index']);
            }
            if (!$specificError) {
                $this->Flash->error(__('The stock transaction could not be saved. Please, try again.'));
            }
        }
        $items = $this->StockTransaction->Items->find('list', limit: 200)->all();
        $admins = $this->StockTransaction->Admins->find('list', limit: 200)->all();
        $transactionTypes = [
            'Stock In' => __('Stock In'),
            'Stock Out' => __('Stock Out'),
            'Adjustment' => __('Adjustment'),
        ];
        $this->set(compact('stockTransactionEntity', 'items', 'admins', 'transactionTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockTransactionEntity = $this->StockTransaction->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['transaction_type'] = $this->normalizeTransactionType($data['transaction_type'] ?? '');
            $data['admin_id'] = $stockTransactionEntity->admin_id ?: $this->request->getSession()->read('Auth.User.id');
            $stockTransactionEntity = $this->StockTransaction->patchEntity($stockTransactionEntity, $data);
            if ($this->StockTransaction->save($stockTransactionEntity)) {
                $this->Flash->success(__('The stock transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transaction could not be saved. Please, try again.'));
        }
        $items = $this->StockTransaction->Items->find('list', limit: 200)->all();
        $admins = $this->StockTransaction->Admins->find('list', limit: 200)->all();
        $transactionTypes = [
            'Stock In' => __('Stock In'),
            'Stock Out' => __('Stock Out'),
            'Adjustment' => __('Adjustment'),
        ];
        $this->set(compact('stockTransactionEntity', 'items', 'admins', 'transactionTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stockTransactionEntity = $this->StockTransaction->get($id);
        if ($this->StockTransaction->delete($stockTransactionEntity)) {
            $this->Flash->success(__('The stock transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The stock transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
