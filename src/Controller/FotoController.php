<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Foto Controller
 *
 * @property \App\Model\Table\FotoTable $Foto
 */
class FotoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Foto->find()
            ->contain(['Album', 'User']);
        $foto = $this->paginate($query);

        $this->set(compact('foto'));
    }

    /**
     * View method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $foto = $this->Foto->get($id, contain: ['Album', 'User', 'Komentarfoto', 'Likefoto']);
        $data = $this->Foto->User->find('list')->all();
        $user = $data->toArray();
        $this->set(compact('foto','user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $foto = $this->Foto->newEmptyEntity();
        if ($this->request->is('post')) {
            $foto = $this->Foto->patchEntity($foto, $this->request->getData());
            $file = $this->request->getUploadedFiles();

            $foto->lokasi_foto = $file['img']->getClientFilename();
            $file['img']->moveTo(WWW_ROOT . 'img' . DS .'img' . DS . $foto->lokasi_foto);
            if ($this->Foto->save($foto)) {
                $this->Flash->success(__('The foto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The foto could not be saved. Please, try again.'));
        }
        $album = $this->Foto->Album->find('list', limit: 200)->all();
        $user = $this->Foto->User->find('list', limit: 200)->all();
        $this->set(compact('foto', 'album', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $foto = $this->Foto->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $foto = $this->Foto->patchEntity($foto, $this->request->getData());
            $file = $this->request->getUploadedFiles();

            if (!empty($file['img']->getClientFileName())) {
                // Jika gambar baru diunggah, hapus gambar lama
                $oldImagePath = WWW_ROOT . 'img' . DS.'img'.DS . $foto->lokasi_foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Simpan gambar baru
                $foto->lokasi_foto = $file['img']->getClientFilename();
                $file['img']->moveTo(WWW_ROOT . 'img' . DS .'img'.DS. $foto->lokasi_foto);
            }

            if ($this->Foto->save($foto)) {
                $this->Flash->success(__('The foto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The foto could not be saved. Please, try again.'));
        }
        $album = $this->Foto->Album->find('list', limit: 200)->all();
        $user = $this->Foto->User->find('list', limit: 200)->all();
        $this->set(compact('foto', 'album', 'user'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Foto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $foto = $this->Foto->get($id);
        // $cekTanggapan = $this->Foto->Komentarfoto->find()->where(['foto_id'=>$id])->count();
        $filePath = WWW_ROOT . 'img' . DS .'img' . DS . $foto->lokasi_foto;

        // Hapus file foto jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        if ($this->Foto->delete($foto)) {
            $this->Flash->success(__('The Foto has been deleted.'));
        } else {
            $this->Flash->error(__('The Foto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
