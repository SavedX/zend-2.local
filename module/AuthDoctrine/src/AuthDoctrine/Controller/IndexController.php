<?php
namespace AuthDoctrine\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use AuthDoctrine\Entity\User;
use AuthDoctrine\Form\LoginForm;
use AuthDoctrine\Form\LoginFilter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
		$em = $this->getEntityManager();

		$users = $em->getRepository('AuthDoctrine\Entity\User')->findAll();
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array(
			'message' => $message,
			'users'	=> $users,
//			'myUsers' => $myUsers
		));
    }
	
    public function loginAction()
    {
		$form = new LoginForm();
		$form->get('submit')->setValue('Login');
		$messages = null;

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
				$data = $form->getData();
				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['username']); //$data['usr_name']
				$adapter->setCredentialValue($data['password']); // $data['usr_password']
				$authResult = $authService->authenticate();
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//-					if ($data['rememberme']) $authService->getStorage()->session->getManager()->rememberMe($time); // no way to get the session
					if ($data['rememberme']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}
                    foreach ($authResult->getMessages() as $message) {
                        $messages .= "$message\n";
//                        $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'index'));
                    }
//                    $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'index'));
                    $this->redirect()->toRoute('car', array('controller' => 'index', 'action' => 'index'));

//                    $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'index'));
					//- return $this->redirect()->toRoute('home');
				}
				foreach ($authResult->getMessages() as $message) {
					$messages .= "$message\n";
				}
			}
		}
		return new ViewModel(array(
			'error' => 'Your authentication credentials are not valid',
			'form'	=> $form,
			'messages' => $messages,
		));
    }
	
	public function logoutAction()
	{
		$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}
		$auth->clearIdentity();
//-		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get to the sessionManager from the storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();

		return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
		
	}	
	public function authTestAction()
	{
		if ($user = $this->identity()) {
			// someone is logged !
		} else {
			// not logged in
		}
	}
	
	/**             
	 * @var Doctrine\ORM\EntityManager
	 */                
	protected $em;
	 
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
}