<?php


namespace Application\Command;


class RegisterCommand
{
    /** @var  string */
    protected $url;

    /**
     * RegisterCommand constructor.
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}