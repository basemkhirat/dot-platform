<?php

namespace Dot;

use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Class ApiController
 * @package Dot
 */
class ApiController extends LaravelController
{

    /**
     * @var Request
     */
    public $request;

    /**
     * @var \DotResponse
     */
    public $response;

    /**
     * The current user
     * @var
     */
    public $user;

    /**
     * ApiController constructor.
     */
    function __construct(Request $request)
    {

        $this->request = $request;
        $this->response = new \DotResponse();

        if (!defined("LANG")) {
            if (Auth::guard("api")->check()) {
                $this->user = Auth::guard(GUARD)->user();
                define("LANG", $request->get("lang", $this->user->lang));
            } else {
                define("LANG", $request->get("lang", app()->getLocale()));
            }
        }

    }

    /**
     * @param array $data
     * @param null $error
     * @return \Illuminate\Http\JsonResponse
     */
    function response($data = [], $error = NULL, $code = 200)
    {
        return $this->response->json($data, $error, $code);
    }

    /**
     * @param null $error
     * @return \Illuminate\Http\JsonResponse
     */
    function error($error = NULL, $code = 500)
    {
        return $this->response([], $error, $code);
    }

    /**
     * Call internal API
     * @param $path
     * @param string $method
     * @param array $params
     * @return mixed
     */
    function call($path, $method = "GET", $params = [])
    {

        $request = Request::create(API . '/' . $path, $method, $params);

        $originalInput = $this->request->input();

        $this->request->replace($request->input());

        $response = Route::dispatch($request);

        $this->request->replace($originalInput);

        return json_decode($response->content());

    }

    /**
     * Call internal API using GET
     * @param null $path
     * @param array $params
     * @return mixed
     */
    function get($path, $params = [])
    {
        return $this->call($path, "GET", $params);
    }

    /**
     * Call internal API using POST
     * @param null $path
     * @param array $params
     * @return mixed
     */
    function post($path, $params = [])
    {
        return $this->call($path, "POST", $params);
    }

}
