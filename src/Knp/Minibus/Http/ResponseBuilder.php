<?php

namespace Knp\Minibus\Http;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\Response;

/**
 * Build a response with a Minibus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ResponseBuilder
{
    /**
     * @var array $options
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [], OptionsResolverInterface $resolver = null)
    {
        $resolver = $resolver ?: new OptionsResolver;
        $this->setOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @param Minibus $minibus
     *
     * @return Response
     */
    public function build(Minibus $minibus)
    {
        $response   = new Response;
        $statusCode = $minibus->getPassenger($this->options['http_status_code_passenger'], null);
        $headers    = $minibus->getPassenger($this->options['http_headers_passenger'], null);

        if (null !== $statusCode) {
            $response->setStatusCode($statusCode);
        }

        if (null !== $headers) {
            $response->headers->add($headers);
        }

        return $response;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    private function setOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'http_status_code_passenger' => '_http_status_code',
                'http_headers_passenger'     => '_http_headers',
            ])
            ->setAllowedTypes([
                'http_status_code_passenger' => 'string',
                'http_headers_passenger'     => 'string',
            ])
        ;
    }
}
