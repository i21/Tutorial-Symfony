<?php
//src/Acme/TaskBundle/Form/Type/TaskType.php

namespace Acme\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('task');
		$builder->add('dueDate', 'date', array('widget' => 'single_text'));
		$builder->add('category', new CategoryType());
	}

	public function getName()
	{
		return 'task';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Acme\TaskBundle\Entity\Task',
			'cascade_validation' => true,
			));
	}
}