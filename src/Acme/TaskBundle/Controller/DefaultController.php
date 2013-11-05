<?php

namespace Acme\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\TaskBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Acme\TaskBundle\Form\Type\TaskType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeTaskBundle:Default:index.html.twig', array('name' => $name));
    }

    public function newAction(Request $request)
    {
    	// Crea una task y le asigna algunos datos ficticios para este ejemplo
    	$task = new Task();
    	$task->setTask('Write a blog post');
    	$task->setDueDate(new \Datetime('tomorrow'));

    	$form = $this->createFormBuilder($task)
                     //->setAction($this->generateUrl('acme_task_new_task'))
                     //->setMethod('GET')
    				 ->add('task','text', array('max_length' => 4))
                     ->add('dueDate','date', array (
                            'widget' => 'single_text',
                            'label' => 'Due Date'))
    				 ->add('save','submit')
                     ->add('saveAndAdd','submit')
    				 ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'task_new' : 'task_success';
            // Guardar a la BD

            return $this->redirect($this->generateUrl('$nextAction'));
        }

    	return $this->render('AcmeTaskBundle:Default:new.html.twig', 
    						  array('form' => $form->createView(),)
    						);
    }

    public function new2Action(Request $request)
    {
        $task = new Task();
        $task->setTask("Write a blog pozt");
        $task->setDueDate(new \Datetime('tomorrow'));

        $form = $this->createForm(new TaskType(), $task);

        return $this->render('AcmeTaskBundle:Default:new.html.twig',
            array('form' => $form->createView()));
    }

    public function contactAction(Request $request)
    {
        //$defaultData = array('message' => 'Type your message here');

        $defaultData['message'] = 'typo mensajo';
        $form = $this->createFormBuilder($defaultData)
                     ->add('name', 'text', array(
                        'constraints' => new Length(array('min' => 3))))
                     ->add('email', 'email', array(
                        'constraints' => array(
                            new NotBlank())))
                     ->add('message', 'textarea')
                     ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
        }

        return $this->render('AcmeTaskBundle:Default:contact.html.twig',
                            array('form' => $form->createView()));
    }
}

