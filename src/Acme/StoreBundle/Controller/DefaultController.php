<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	public function indexAction($name) {
		$translator = $this->get('translator');
		//$translated = $this->get('translator')->trans('Symfony is great');

		/*$translated = $this->get('translator')->trans(
			'Hello %name%',
			array('%name%' => $name)
			);*/

		//$translated .= "<br>";
		$request = $this->getRequest();
		$locale = $request->getLocale();

		$translated = $translator->trans('Symfony2 is great');
		$translated .= "<br>";
		$translated .= $translator->trans('symfony2.great');

		/* Plural */
		$count = 25;

		/*$translated = $translator->transChoice(
			'There is one apple|There are %count% apples',
			$count,
			array('%count%' => $count)
			);*/
		$translated = $translator->transChoice(
			'{0} There are no apples|{1} There is one apple|]1,19] There are %count% apples|[20,Inf] There are many apples',
			$count,
			array('%count%' => $count)
			);
		

		//return new Response($translated);
		return $this->render('AcmeStoreBundle:Default:index.html.twig',
			array('name' => $name,
				'count' => $count));
	}

	public function createAction()
	{
		//$category = new Category();
		//$category->setName('Secondary category');

		
		$product = new Product();
		
		/*$product
		/		->setPrice(9.99)
				->setDescription('Lorem ipsum dolor');
				->setCategory($category);*/

		$validator = $this->get('validator');
		$errors = $validator->validate($product);

		if (count($errors) > 0)
			return new Response(print_r($errors, true));
		else
			return new Response("Name is correct");
		/*
		$em = $this->getDoctrine()->getManager();
		$em->persist($product);	
		$em->persist($category);
		$em->flush();*/
		
		return new Response('Created product id '.$product->getId().' and category '. $category->getId());
	}
	
	public function showAction($id)
	{/*
		$product = $this->getDoctrine()
						->getRepository('AcmeStoreBundle:Product')
						->find($id);
		if (!$product):
			throw $this->createNotFoundException('No product found for id '.$id);
		endif;
		*/
		$product = $this->getDoctrine()
						->getRepository('AcmeStoreBundle:Product')
						->findByIdJoinedToCategory($id);
		$categoryName = $product->getCategory()->getName();
		
		return $this->render('AcmeStoreBundle:Default:show.html.twig',
				array('producto' => $product));
	}
	
	public function showCategoryAction($id)
	{
		$category = $this->getDoctrine()
						 ->getRepository('AcmeStoreBundle:Category')
						 ->find($id);
		if(!$category)
			throw $this->createNotFoundException('No category found for id '.$id);
		
		return $this->render('AcmeStoreBundle:Default:show-category.html.twig',
				array('category'=>$category));
	}
	
	public function updateAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
		
		if(!$product) {
			throw $this->createNotFoundException('No product found for id '.$id);
		}
		
		$product->setDescription('New product name!');
		$em->flush();
		
		return $this->redirect($this->generateUrl('homepage'));
	}
	
	public function deleteAction($id)
	{
		$em-> $this->getDoctrine()->getManager();
		$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
		
		if(!$product)
			throw $this->createNotFoundException('No product found for id '. $id);
		
		$em->remove($product);
		$em->flush();
	}
	
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('AcmeStoreBundle:Product')->findAllOrderedByName();
		return $this->render('AcmeStoreBundle:Default:list.html.twig', array("products"=>$products));
	}
	
}
