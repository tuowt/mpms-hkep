<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep\Auth\Kernel;

use Hkep\Kernel\Support;
use Hkep\Auth\Application;
use Hkep\Kernel\Http\Response;
use Hkep\Kernel\Traits\HasHttpRequests;
use GuzzleHttp\Client;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseClient.
 */
class BaseClient {
    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var \Hkep\Auth\Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param \Hkep\Auth\Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Extra request params.
     *
     * @return array
     */
    protected function prepends() {
        return [];
    }

    /**
     * Make a API request.
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @param array $options
     * @param bool $returnResponse
     *
     * @return \Psr\Http\Message\ResponseInterface|\Hkep\Kernel\Support\Collection|array|object|string
     *
     * @throws \Hkep\Kernel\Exceptions\InvalidConfigException
     */
    protected function request($endpoint, $params = [], $method = 'get', $options = [], $returnResponse = false) {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }
        $base = [];
        $params = array_merge($base, $this->prepends(), $params);
        
        if (strtoupper($method) == 'GET') {
            $params = ['query' => $params];
        } else {
            $params = ['form_params' => $params];
        }

        $response = $this->performRequest($endpoint, $method, $params);

        return $returnResponse ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    /**
     * Make a request and return raw response.
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @param array $options
     *
     * @return ResponseInterface
     *
     * @throws \Hkep\Kernel\Exceptions\InvalidConfigException
     */
    protected function requestRaw($endpoint, $params = [], $method = 'post', $options = []) {
        return $this->request($endpoint, $params, $method, $options, true);
    }

    /**
     * Request with SSL.
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface|\Hkep\Kernel\Support\Collection|array|object|string
     *
     * @throws \Hkep\Kernel\Exceptions\InvalidConfigException
     */
    protected function safeRequest($endpoint, $params, $method = 'post', $options = []) {
        $options = array_merge([
            'cert'    => $this->app['config']->get('cert_path'),
            'ssl_key' => $this->app['config']->get('key_path'),
        ], $options);

        return $this->request($endpoint, $params, $method, $options);
    }

    /**
     * Return GuzzleHttp\Client instance.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient() {
        if (!($this->httpClient instanceof Client)) {
            $this->httpClient = $this->app['http_client'] ? $this->app['http_client'] : new Client();
        }

        return $this->httpClient;
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares() {
        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
    }

    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware() {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ? $this->app['config']['http.log_template'] : MessageFormatter::DEBUG);

        return Middleware::log($this->app['logger'], $formatter);
    }

    /**
     * Wrapping an API endpoint.
     *
     * @param string $endpoint
     *
     * @return string
     */
    protected function wrap($endpoint) {
        return $endpoint;
    }
}
