<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
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
	
    public function indexAction($name)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
