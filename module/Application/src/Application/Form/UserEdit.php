<?php

namespace Application\Form;

use ZfcUser\Form\Base;
use ZfcUser\Options\RegistrationOptionsInterface;

class UserEdit extends Base {

    /**
     * @var RegistrationOptionsInterface
     */
    protected $registrationOptions;

    public function __construct($name, RegistrationOptionsInterface $options)
    {
        $this->setRegistrationOptions($options);

        parent::__construct();

        $this->add(
            array(
                'name'       => 'bio',
                'required'   => false,
                'allowEmpty' => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'type'       => 'Zend\Form\Element\Textarea',
                'attributes' => array(
                    'cols' => 40,
                    'rows' => 10
                ),
                'options'    => array(
                    'label'  => 'Bio'
                )
            )
        );

        $this->get('submit')->setLabel('Save');
        $this->getEventManager()->trigger('init', $this);
    }

    public function setCaptchaElement(Captcha $captchaElement)
    {
        $this->captchaElement= $captchaElement;
    }

    /**
     * Set Registration Options
     *
     * @param RegistrationOptionsInterface $registrationOptions
     * @return Register
     */
    public function setRegistrationOptions(RegistrationOptionsInterface $registrationOptions)
    {
        $this->registrationOptions = $registrationOptions;
        return $this;
    }

    /**
     * Get Registration Options
     *
     * @return RegistrationOptionsInterface
     */
    public function getRegistrationOptions()
    {
        return $this->registrationOptions;
    }

}