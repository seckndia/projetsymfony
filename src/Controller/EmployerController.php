<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\ServiceRepository;
use App\Repository\EmployerRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Entity\Employer;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Service;

class EmployerController extends AbstractController
{
    /**
     * @Route("/employer", name="employer")
     * 
     */
    public function list()
    {
$repo = $this->getDoctrine()->getRepository(Employer::class);
$employers = $repo->findAll();

        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
             'employers' => $employers 
        ]);
    }
/**
 * @Route("/",name="home")
 */

    public function home(){
        return $this->render('employer/home.html.twig');
    }
 /**
  * @Route("/employer/new",name="employer_form")
  * @Route("/employer/{id}edit",name="edit")
  */
    public function froms(Employer $employer = null,Request $request,ObjectManager $manager){
   if(!$employer){
    $employer= new Employer();
   }
      

$form=$this->createFormBuilder($employer)
            ->add('matricule')
            ->add('nomcomplet')
            ->add('date_naiss', DateType::class, [
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ])
            ->add('salaire')
            ->add('id_service', EntityType::class, [
                'class'=> Service::class, 'choice_label'=>'libelle'
            ])

             ->getForm();

$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()){
   $manager->persist($employer);
   $manager->flush();
   return $this->redirectToRoute('employer');
  
}
        return $this->render('employer/form.html.twig',[
         'formemp' => $form->createView(),
         'editMode'=>$employer->getId() !== null
        ]);
    }
    /**
     *  @Route("/employer/{id}delate",name="delt")
     */
public function delete(Employer $employer,ObjectManager $manager){
  
$manager->remove($employer);
$manager->flush();

return $this->redirectToRoute('employer',['employer'=>$employer]);
return $this->addFlash('danger','employer supprimé avec succés');

}

}
