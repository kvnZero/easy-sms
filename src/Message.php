<?php

/*
 * This file is part of the overtrue/easy-sms.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\EasySms;

use Overtrue\EasySms\Contracts\GatewayInterface;
use Overtrue\EasySms\Contracts\MessageInterface;

/**
 * Class Message.
 */
class Message implements MessageInterface
{
    /**
     * @var array
     */
    protected $gateways = [];

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Message constructor.
     *
     * @param string $type
     */
    public function __construct(array $attributes = [], $type = MessageInterface::TEXT_MESSAGE)
    {
        $this->type = $type;

        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Return the message type.
     *
     * @return string
     */
    public function getMessageType()
    {
        return $this->type;
    }

    /**
     * Return message content.
     *
     * @return string
     */
    public function getContent(?GatewayInterface $gateway = null)
    {
        return is_callable($this->content) ? call_user_func($this->content, $gateway) : $this->content;
    }

    /**
     * Return the template id of message.
     *
     * @return string
     */
    public function getTemplate(?GatewayInterface $gateway = null)
    {
        return is_callable($this->template) ? call_user_func($this->template, $gateway) : $this->template;
    }

    /**
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(?GatewayInterface $gateway = null)
    {
        return is_callable($this->data) ? call_user_func($this->data, $gateway) : $this->data;
    }

    /**
     * @param array|callable $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getGateways()
    {
        return $this->gateways;
    }

    /**
     * @return $this
     */
    public function setGateways(array $gateways)
    {
        $this->gateways = $gateways;

        return $this;
    }

    /**
     * @return string
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
