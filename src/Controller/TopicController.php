<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Topic Controller
 *
 *
 * @method \App\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicController extends AppController
{
    var $topics;
    var $db;

    function initialize(){
        $this->topics = TableRegistry::get('Topics');
        $this->db = ConnectionManager::get('default');
    }

    public function index()
    {
        $results = $this->db->execute('SELECT * FROM topics JOIN users on users.user_id = topics.user_id')->fetchAll('obj');

       // $results = $this->topics->find();
        $this->set('topics', $results);
        $this->render('/Forum/index');
    }

    public function view($id = null)
    {
        $query = "SELECT * FROM topics
        JOIN users on users.user_id = topics.user_id
        JOIN posts on posts.topic_id = topics.topic_id
        WHERE topics.topic_id = '".$id."' ";

        $this->db->execute($query);
        //$query = $this->topics->get($id);
        $this->set('data', $query);
        $this->render('/Forum/view');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $topic = $this->Topic->newEntity();
        if ($this->request->is('post')) {
            $topic = $this->Topic->patchEntity($topic, $this->request->getData());
            if ($this->Topic->save($topic)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $this->set(compact('topic'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $topic = $this->Topic->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $topic = $this->Topic->patchEntity($topic, $this->request->getData());
            if ($this->Topic->save($topic)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $this->set(compact('topic'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $topic = $this->Topic->get($id);
        if ($this->Topic->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
