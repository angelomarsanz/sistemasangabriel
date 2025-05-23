<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

		$this->loadComponent('RequestHandler', [
            			'viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel']
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'finder' => 'auth'
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authError' => 'Ingrese sus datos, nuevamente',
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'home'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
    }
    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    
    public function beforeFilter(Event $event)
    {
        $this->set('current_user', $this->Auth->user());
    }

    /*
    Inicio cambios Seniat
    Roles:
    - Administrador: Juan Carlos y Ángel
    - Alumno : Alumnos
    - Propietario: Prof. Ana Pérez
    - Representante : Representantes
    - Ventas generales: Lorelys y Daniela
    - Ventas fiscales: Lorelys y Daniela
    - Contabilidad general: Emi
    - Contabilidad fiscal: Emi
    - Control de estudios: Directora 
    - Seniat : Fiscal Seniat
    Fin cambios Seniat
    */

    public function isAuthorized($user)
    {
        // Inicios cambios Seniat
        $rolesAccesoGeneral = 
        [
            'Administrador',
            'Contabilidad fiscal',
            'Contabilidad general',
            'Propietario',
            'Ventas fiscales',
            'Ventas generales'
        ];
        // Fin cambios Seniat

        if (isset($user['role']))
        {
            foreach ($rolesAccesoGeneral as $rol)
            {
                if ($rol == $user['role'])
                {
                    return true;
                }
            }
        }
        return false;
    }
}