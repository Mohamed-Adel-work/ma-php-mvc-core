<?php

/** User: MoAdel ...*/

namespace app\core;

use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\core\Controller;
use app\core\Router;
use app\core\db\Database;
use app\core\View;
use app\core\db\DbModel;
use app\models\User;

/**
 * Class Application
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core
 */


class Application
{
    public static $ROOT_DIR;

    public string $layout = 'main';
    public $userClass;
    public $router;
    public $request;
    public $response;
    public $session;
    public $db;
    public ?UserModel $user;
    public View $view;

    public static $app;
    public $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode(404);
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return \app\core\Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param \app\core\Controller $controller
     */
    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
