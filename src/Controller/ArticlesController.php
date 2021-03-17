<?php
namespace App\Controller;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

    public function view($slug=null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ( $this->request->is('post') ) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->user_id = 1;
            // TODO: user_id from login user

            if ( $this->Articles->save($article) ) {
                $this->Flash->success('記事を保存しました。');
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error('記事の保存に失敗しました');
        }
        $this->set(compact('article'));
    }
}

