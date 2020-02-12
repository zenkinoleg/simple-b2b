<?php

namespace App\Domain\Support;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

/**
 * Class ApiResponse
 * Base application response. Contains basic logic and usable facades:
 * (success,created,notFound,badRequest, ...)
 *
 * @package App\Domain\Support
 */
final class ApiResponse
{
    /** @var \JMS\Serializer\Serializer */
    private $serializer;

    /** @var mixed */
    private $body = '';

    /** @var array */
    private $headers = [];

    /** @var integer */
    private $status = RESPONSE::HTTP_OK;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()
                                             ->build();
        $this->setDefaultHeaders();
    }

    /**
     * @param  array  $headers
     *
     * @return $this
     */
    private function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @param  int  $status
     *
     * @return $this
     */
    private function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Default HTTP Headers
     *
     * @return \App\Domain\Support\ApiResponse
     */
    private function setDefaultHeaders(): self
    {
        return $this->setHeaders([
            'content-type' => 'application/json',
        ]);
    }

    /**
     * @param  mixed  $body
     *
     * @return $this
     */
    private function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return JsonResponse
     */
    private function respond()
    {
        return new JsonResponse(
            $this->serializer->toArray($this->body),
            $this->status,
            $this->headers
        );
    }

    /**
     * Facade
     *
     * @param $data
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function success($data): JsonResponse
    {
        return (new static)
            ->setBody([
                'Status'  => '200 Ok',
                'Message' => 'Successfully fetched',
                'Data'    => $data,
            ])
            ->respond();
    }

    /**
     * Facade
     *
     * @param  mixed  $data
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function created($data): JsonResponse
    {
        return (new static)
            ->setBody([
                'Status'  => '201 Created',
                'Message' => 'Successfully added',
                'Data'    => $data,
            ])
            ->setStatus(RESPONSE::HTTP_CREATED)
            ->respond();
    }

    /**
     * Facade
     *
     * @param  mixed  $data
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function deleted($data): JsonResponse
    {
        return (new static)
            ->setBody([
                'Status'  => '204 No Content',
                'Message' => 'Record deleted',
                'Data'    => $data,
            ])
            ->setStatus(RESPONSE::HTTP_NO_CONTENT)
            ->respond();
    }

    /**
     * Facade
     *
     * @param  string|null  $message
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function notFound(string $message = null): JsonResponse
    {
        return (new static)
            ->setBody([
                'Status'  => '404 Not Found',
                'Message' => $message ?? 'There is nothing to show to you buddy',
            ])
            ->setStatus(RESPONSE::HTTP_NOT_FOUND)
            ->respond();
    }

    /**
     * Facade
     *
     * @param $errors
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function badRequest($errors): JsonResponse
    {
        return (new static)
            ->setBody([
                'Status'  => '400 Bad Request',
                'Message' => 'Incorrect request parameters',
                'Errors'  => $errors,
            ])
            ->setStatus(RESPONSE::HTTP_BAD_REQUEST)
            ->respond();
    }
}
