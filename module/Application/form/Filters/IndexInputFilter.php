<?php
declare(strict_types=1);
/**
 * IndexInputFilter.php
 *
 * @copyright   Copyright (c) 2023 CHECK24 Vergleichsportal Reise GmbH München
 * @author      Naseem Toumeh <Naseem.Toumeh@check24.de>
 * @since       13.04.2023
 */

namespace Form\Filters;

use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;
use Laminas\InputFilter\Factory;
use Laminas\Validator\StringLength;


class IndexInputFilter extends InputFilter
{


    public function getInputFilter(): InputFilter
    {
        if (!isset($this->inputFilter)) {
            $factory = new Factory();
            $inputFilter = new InputFilter();

            $inputFilter->add($factory->createInput([
                'name' => 'name',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 6,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Username must have at least 6 characters!',
                                StringLength::TOO_LONG => 'Username must have at most 128 characters!',
                            ],
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'jiraPassword',
                'required' => true,
                'filters' => [
                  //  ['name' => StripTags::class],
                 //   ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 8,
                            'max' => 25,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Password must have at least 8 characters!',
                                StringLength::TOO_LONG => 'Password must have at most 25 characters!',
                            ],
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'hawkID',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToLower::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 24,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => 'hawkID must have at least 6 characters!',
                                StringLength::TOO_LONG => 'hawkID must have at most 128 characters!',
                            ],
                        ],
                    ],
                ],
            ]));
            $inputFilter->add($factory->createInput([
                'name' => 'hawkAuthKey',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToLower::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 64,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => 'HawkAuthKey must have at least 64 characters!',
                                StringLength::TOO_LONG => 'HawkAuthKey must have at most 128 characters!',
                            ],
                        ],
                    ],
                ],
            ]));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
