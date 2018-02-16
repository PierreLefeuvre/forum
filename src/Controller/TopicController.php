<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Collection\Collection;

/**
 * Topic Controller
 *
 *
 * @method \App\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicController extends AppController
{
    var $topicsTable;
    var $postsTable;
    var $db;

    function initialize(){
        parent::initialize();
        $this->topicsTable = TableRegistry::get('Topics');
        $this->postsTable = TableRegistry::get('Posts');
        $this->db = ConnectionManager::get('default');
    }

    public function index()
    {
        $results = $this->db->execute('
            SELECT topics.*, nickname , ip
            FROM topics 
            JOIN posts on posts.post_id = (
                SELECT post_id 
                FROM posts 
                WHERE posts.topic_id = topics.topic_id 
                ORDER BY post_id 
                LIMIT 1
            ) 
            ')->fetchAll('obj');

       // $results = $this->topicsTable->find();
        $this->set('topics', $results);
        $this->render('/Forum/index');
    }

    public function view($id = null)
    {
        //Récupération du topic
        $query = "SELECT topic_id, title 
        FROM topics
        WHERE topics.topic_id = '".$id."' ";

        $result = $this->db->execute($query)->fetch('obj');

        $this->set('topic', $result);

        //récupération des posts
        $query = "SELECT posts.nickname, topics.topic_id, message, posts.post_id, posts.created
        FROM topics
        LEFT JOIN posts on posts.topic_id = topics.topic_id
        WHERE topics.topic_id = '".$id."' ";

        $result = $this->db->execute($query)->fetchAll('obj');

        $this->set('posts', $result);
        $this->set('post_id', $id);

        $this->render('/Forum/view');
    }
    public function create()
    {
        $this->render('/Forum/create');
    }
    public function addPost()
    {
        if ($this->request->is('post')) {

           $postData = $this->request->getData();

            $posts = $this->postsTable->newEntity();
            $posts->nickname = $postData['nickname'];
            $posts->topic_id = $postData['topic_id'];
            $posts->message = $postData['message'];
            $posts->ip = $_SERVER['REMOTE_ADDR'];

            $okP = $this->postsTable->save($posts);

            if ($okP) {
                $this->Flash->success('The post has been saved.');

                return $this->redirect(['action' => 'view', $postData['topic_id']]);
            }
            $this->Flash->error('The post could not be saved. Please, try again.');
        }
        //$this->set(compact('topic'));
    }
    public function add()
    {
        if ($this->request->is('post')) {
          
            $postData = $this->request->getData();

            //$collection = new Collection($this->request->getData());
            // $topics = $collection->filter(function($value, $key, $iterator){
            //     return in_array($key, ['title']);
            // });

            $topics = $this->topicsTable->newEntity();
            $topics->title = $postData['title'];
            $okT = $this->topicsTable->save($topics);
            
            $posts = $this->postsTable->newEntity();
            $posts->nickname = $postData['nickname'];
            $posts->topic_id = $topics->topic_id;
            $posts->message = $postData['message'];
            $posts->ip = $_SERVER['REMOTE_ADDR'];

            $okP = $this->postsTable->save($posts);
            
            if ($okP && $okT) {
                $this->Flash->success('The topic has been saved.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('The topic could not be saved. Please, try again.');
        }
        $this->redirect(['action' => 'create']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
 /*   public function edit($id = null)
    {
        $this->set('post_id', $id);
        $post = $this->postsTable->get($id);
        $this->set(compact('post'));
        $this->render('/Forum/edit/');
    }*/

    public function edit($id = null)
    {
        $post = $this->postsTable->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->postsTable->patchEntity($post, $this->request->getData());
            if ($this->postsTable->save($post)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
        $this->render('/Forum/edit/');
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
        $this->request->allowMethod(['GET','post', 'delete']);

        $this->topicsTable->newEntity();

        $topic = $this->topicsTable->get($id);

        if ($this->topicsTable->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
