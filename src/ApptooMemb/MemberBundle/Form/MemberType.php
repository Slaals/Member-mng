<?php

namespace ApptooMemb\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

use ApptooMemb\MemberBundle\Form\UserType;

class MemberType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', 'text')
      ->add('user', new UserType())
      ->add('address', 'text', array('required' => false))
      ->add('tel', 'text', array('required' => false))
      ->add('site', 'text', array('required' => false))
      ->add('save', 'submit')
    ;
  }

  public function getName()
  {
    return 'apptoo_memb_memberform';
  }
}