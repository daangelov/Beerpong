<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class IndexController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'index.twig');
    }

    public function login(Request $request, Response $response)
    {
        return $this->view->render($response, 'login.twig');
    }

    public function queue(Request $request, Response $response)
    {
        return $this->view->render($response, 'queue.twig');
    }

//    /**
//     * @param Request $request
//     * @param Response $response
//     * @return \Psr\Http\Message\ResponseInterface
//     */
//    public function index(Request $request, Response $response)
//    {
//        $projects = $this->db
//            ->query("SELECT * FROM projects")
//            ->fetchAll(PDO::FETCH_ASSOC);
//
//        return $this->view->render($response, 'home.twig', compact("projects"));
//    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response, array $args)
    {
        $project = $this->db->prepare("SELECT * FROM projects WHERE id = :id");

        $project->execute(['id' => $args['id']]);

        $project = $project->fetch(PDO::FETCH_OBJ);

        if (!$project) {
            return $this->view->render($response->withStatus(StatusCode::HTTP_NOT_FOUND), 'errors/404.twig');
        }

        return $this->view->render($response, 'home.twig', compact("project"));
    }

    public function showWithJson(Request $request, Response $response, array $args)
    {
        $project = $this->db->prepare("SELECT * FROM projects WHERE id = :id");
        $project->execute(['id' => $args['id']]);

        $project = $project->fetch(PDO::FETCH_OBJ);

        if (!$project) {
            return $response->withJson(['message' => 'This record does not exist!'], StatusCode::HTTP_NOT_FOUND);
        }

        return $response->withJson($project, StatusCode::HTTP_OK);
    }

    // Basic methods

    // index -> get all resources
    // show  -> get one resource

    // create -> get create page for resource
    // store  -> create resource

    // edit  -> get edit page for resource
    // update -> update resource

    // destroy -> delete resource
}
