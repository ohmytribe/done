<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Controller;

use Omt\TodoBundle\Model\Auth\Controller\SecuredController;
use Omt\TodoBundle\Model\Response\JsonResponse;
use Omt\TodoBundle\Model\Todo\ArrayEncoder;
use Omt\TodoBundle\Model\Todo\Manager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * To-do controller
 * @Route("/todo")
 */
class TodoController extends SecuredController
{

    const START_PARAMETER_NAME = 'start';
    const LIMIT_PARAMETER_NAME = 'limit';
    const TODOS_PARAMETER_NAME = 'todos';

    /**
     * @Route("/", name="todo_list")
     * @Template("OmtTodoBundle:todo:index.html.twig")
     */
    public function indexAction()
    {
        if (!$this->login()) {
            $response = $this->createRedirectToLoginPageResponse();
        } else {
            $response = array();
        }

        return $response;
    }

    /**
     * @Route("/list")
     */
    public function getListAction()
    {
        if (!$this->login()) {
            $response = $this->createAuthNeededJsonResponse();
        } else {
            $start = $this->getRequest()->get(self::START_PARAMETER_NAME);
            $limit = $this->getRequest()->get(self::LIMIT_PARAMETER_NAME);
            $todos = $this->createTodoListManager()->getList($start, $limit);
            $response = new JsonResponse(array(
                self::TODOS_PARAMETER_NAME => ArrayEncoder::encodeList($todos)
            ));
        }

        return $response;
    }

    /**
     * @param $id
     * @Route("/modify/{id}")
     * @return JsonResponse
     */
    public function modifyAction($id)
    {
        if (!$this->login()) {
            $response = $this->createAuthNeededJsonResponse();
        } else {
            $task = $this->getRequest()->get("task");
            $priority = $this->getRequest()->get("priority");
            $manager = $this->createTodoListManager();
            if ($manager->modify($id, $task, $priority)) {
                $response = JsonResponse::createSuccessResponse();
            } else {
                $response = JsonResponse::createErrorResponse($manager->getError());
            }
        }

        return $response;
    }

    /**
     * @param $id
     * @Route("/remove/{id}")
     * @return JsonResponse
     */
    public function removeAction($id)
    {
        if (!$this->login()) {
            $response = $this->createAuthNeededJsonResponse();
        } else {
            $manager = $this->createTodoListManager();
            if ($manager->remove($id)) {
                $response = JsonResponse::createSuccessResponse();
            } else {
                $response = JsonResponse::createErrorResponse($manager->getError());
            }
        }

        return $response;
    }

    /**
     * @param $id
     * @Route("/done/{id}")
     * @return JsonResponse
     */
    public function markDoneAction($id)
    {
        if (!$this->login()) {
            $response = $this->createAuthNeededJsonResponse();
        } else {
            $manager = $this->createTodoListManager();
            if ($manager->markDone($id)) {
                $response = JsonResponse::createSuccessResponse();
            } else {
                $response = JsonResponse::createErrorResponse($manager->getError());
            }
        }

        return $response;
    }

    /**
     * @Route("/create", name="create_todo")
     */
    public function createAction()
    {
        if (!$this->login()) {
            $response = $this->createAuthNeededJsonResponse();
        } else {
            $task = $this->getRequest()->get("task");
            $priority = $this->getRequest()->get("priority");
            $manager = $this->createTodoListManager();
            if ($manager->create($task, $priority)) {
                $response = JsonResponse::createSuccessResponse();
            } else {
                $response = JsonResponse::createErrorResponse($manager->getError());
            }
        }

        return $response;
    }

    /**
     * @return Manager
     */
    private function createTodoListManager()
    {
        return new Manager($this->getDoctrine()->getManager(), $this->getUser());
    }

} 