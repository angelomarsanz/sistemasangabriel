{"changed":false,"filter":false,"title":"TeachingareasController.php","tooltip":"/src/Controller/TeachingareasController.php","value":"<?php\nnamespace App\\Controller;\n\nuse App\\Controller\\AppController;\n\n/**\n * Teachingareas Controller\n *\n * @property \\App\\Model\\Table\\TeachingareasTable $Teachingareas\n */\nclass TeachingareasController extends AppController\n{\n    public function beforeFilter(\\Cake\\Event\\Event $event)\n    {\n        parent::beforeFilter($event);\n\n        $this->Auth->allow(['testComunicationSend', 'testComunicationReceives']);\n    }\n\n    public function testComunicationSend()\n    {\n        \n    }\n    \n    public function testComunicationReceives()\n    {\n        $this->autoRender = false;\n\n        if ($this->request->is('post')) \n        {\n            $jsondata = [];\n\n            $teachingarea = $this->Teachingareas->newEntity();\n        \n            $teachingarea->description_teaching_area = $_POST['descriptionTeachingArea'];\n\n            if ($this->Teachingareas->save($teachingarea)) \n            {\n                $jsondata[\"success\"] = true;\n                $jsondata[\"data\"] = 'El área de enseñanza se creó el usuario';\n            }\n            else\n            {\n                $jsondata[\"success\"] = false;\n                $jsondata[\"data\"] = 'No se pudo crear el área de enseñanza';\n            }\n\n            exit(json_encode($jsondata, JSON_FORCE_OBJECT));\n        }        \n    }\n\n    /**\n     * Index method\n     *\n     * @return \\Cake\\Network\\Response|null\n     */\n    public function index()\n    {\n        $teachingareas = $this->paginate($this->Teachingareas);\n\n        $this->set(compact('teachingareas'));\n        $this->set('_serialize', ['teachingareas']);\n    }\n\n    /**\n     * View method\n     *\n     * @param string|null $id Teachingarea id.\n     * @return \\Cake\\Network\\Response|null\n     * @throws \\Cake\\Datasource\\Exception\\RecordNotFoundException When record not found.\n     */\n    public function view($id = null)\n    {\n        $teachingarea = $this->Teachingareas->get($id, [\n            'contain' => ['Employees']\n        ]);\n\n        $this->set('teachingarea', $teachingarea);\n        $this->set('_serialize', ['teachingarea']);\n    }\n\n    /**\n     * Add method\n     *\n     * @return \\Cake\\Network\\Response|void Redirects on successful add, renders view otherwise.\n     */\n    public function add()\n    {\n        $teachingarea = $this->Teachingareas->newEntity();\n        if ($this->request->is('post')) {\n            $teachingarea = $this->Teachingareas->patchEntity($teachingarea, $this->request->data);\n            if ($this->Teachingareas->save($teachingarea)) {\n                $this->Flash->success(__('The teachingarea has been saved.'));\n\n                return $this->redirect(['action' => 'index']);\n            } else {\n                $this->Flash->error(__('The teachingarea could not be saved. Please, try again.'));\n            }\n        }\n        $employees = $this->Teachingareas->Employees->find('list', ['limit' => 200])->order(['Employees.surname' => 'ASC',\n            'Employees.second_surname' => 'ASC', 'Employees.first_name' => 'ASC', 'Employees.second_surname' => 'ASC']);\n        \n        $this->set(compact('teachingarea', 'employees'));\n        $this->set('_serialize', ['teachingarea']);\n    }\n\n    /**\n     * Edit method\n     *\n     * @param string|null $id Teachingarea id.\n     * @return \\Cake\\Network\\Response|void Redirects on successful edit, renders view otherwise.\n     * @throws \\Cake\\Network\\Exception\\NotFoundException When record not found.\n     */\n    public function edit($id = null)\n    {\n        $teachingarea = $this->Teachingareas->get($id, [\n            'contain' => []\n        ]);\n        if ($this->request->is(['patch', 'post', 'put'])) {\n            $teachingarea = $this->Teachingareas->patchEntity($teachingarea, $this->request->data);\n            if ($this->Teachingareas->save($teachingarea)) {\n                $this->Flash->success(__('The teachingarea has been saved.'));\n\n                return $this->redirect(['action' => 'index']);\n            } else {\n                $this->Flash->error(__('The teachingarea could not be saved. Please, try again.'));\n            }\n        }\n        $employees = $this->Teachingareas->Employees->find('list', ['limit' => 200])->order(['Employees.surname' => 'ASC',\n            'Employees.second_surname' => 'ASC', 'Employees.first_name' => 'ASC', 'Employees.second_surname' => 'ASC']);\n        \n        $this->set(compact('teachingarea', 'employees'));\n        $this->set('_serialize', ['teachingarea']);\n    }\n\n    /**\n     * Delete method\n     *\n     * @param string|null $id Teachingarea id.\n     * @return \\Cake\\Network\\Response|null Redirects to index.\n     * @throws \\Cake\\Datasource\\Exception\\RecordNotFoundException When record not found.\n     */\n    public function delete($id = null)\n    {\n        $this->request->allowMethod(['post', 'delete']);\n        $teachingarea = $this->Teachingareas->get($id);\n        if ($this->Teachingareas->delete($teachingarea)) {\n            $this->Flash->success(__('The teachingarea has been deleted.'));\n        } else {\n            $this->Flash->error(__('The teachingarea could not be deleted. Please, try again.'));\n        }\n\n        return $this->redirect(['action' => 'index']);\n    }\n}","undoManager":{"mark":-1,"position":-1,"stack":[]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":16,"column":18},"end":{"row":16,"column":18},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1508387796269}