<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Album Controller
 *
 * @property \App\Model\Table\AlbumTable $Album
 */
class AlbumController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
            // $id = $this->Authentication->getIdentity()->get('id');
            // // if($id){
            // //     $query = $this->Album->find()->where(['Album.user_id'=>$id])->contain(['User']);
            // // }else{
            // //     $query = $this->Album->find()->contain(['User']);
                
            // // }
            // // $album = $this->paginate($query);
        $query = $this->Album->find()
            ->contain(['User']);
        $album = $this->paginate($query);

        $this->set(compact('album'));
    }

    /**
     * View method
     *
     * @param string|null $id Album id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $album = $this->Album->get($id, contain: ['User', 'Foto']);
        $this->set(compact('album'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $album = $this->Album->newEmptyEntity();
        if ($this->request->is('post')) {
            $album = $this->Album->patchEntity($album, $this->request->getData());
            if ($this->Album->save($album)) {
                $this->Flash->success(__('The album has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The album could not be saved. Please, try again.'));
        }
        $user = $this->Album->User->find('list', limit: 200)->all();
        $this->set(compact('album', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Album id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $album = $this->Album->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $album = $this->Album->patchEntity($album, $this->request->getData());
            if ($this->Album->save($album)) {
                $this->Flash->success(__('The album has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The album could not be saved. Please, try again.'));
        }
        $user = $this->Album->User->find('list', limit: 200)->all();
        $this->set(compact('album', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Album id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $album = $this->Album->get($id);
        if ($this->Album->delete($album)) {
            $this->Flash->success(__('The album has been deleted.'));
        } else {
            $this->Flash->error(__('The album could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
