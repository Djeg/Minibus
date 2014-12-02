<?php

namespace Knp\Minibus\Minibus;

use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Minibus\Minibus as DefaultMinibus;

/**
 * A specialisation of a minibus in an http environment.
 */
class HttpMinibus implements Minibus
{
    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var Response $response
     */
    private $response;

    /**
     * @var Minibus $wrappedBus
     */
    private $wrappedBus;

    /**
     * @param Request  $request
     * @param Response $response
     * @param Minibus  $wrappedBus
     */
    public function __construct(
        Request  $request,
        Response $response = null,
        Minibus  $wrappedBus = null
    ) {
        $this->request    = $request;
        $this->response   = $response ?: new Response;
        $this->wrappedBus = $wrappedBus ?: new DefaultMinibus;
    }

    /**
     * {@inheritdoc}
     */
    public function addPassenger($name, $passenger)
    {
        $this->wrappedBus->addPassenger($name, $passenger);
    }

    /**
     * {@inheritdoc}
     */
    public function getPassenger($name, $defaultPassenger = null)
    {
        return $this->wrappedBus->getPassenger($name, $defaultPassenger);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPassenger($name)
    {
        return $this->wrappedBus->hasPassenger($name);
    }

    /**
     * {@inheritdoc}
     */
    public function removePassenger($name)
    {
        $this->wrappedBus->removePassenger($name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassengers(array $passengers)
    {
        $this->wrappedBus->setPassengers($passengers);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassengers()
    {
        return $this->wrappedBus->getPassengers();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return HttpMinibus
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }
}
