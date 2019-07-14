<?php

namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Employee;
use App\Entity\Services;
use App\Entity\EmployeeRepository;
use App\Entity\ServicesRepository;

class EmployeeServiceController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'EmployeeServiceController',
        ]);
    }

    /**
     * @Route("/employee", name="employee")
     */

    public function view_all(){
        $emp_rep = $this->getDoctrine()->getRepository(Employee::class);
        $all_employees = $emp_rep->findAll();

        return $this->render('employees.html.twig',array('all_emp' => $all_employees)
        );
    }

    /**
     * @Route("/service", name="service")
     */
    public function serv() {
        return $this->render('services.html.twig');
    }

    /**
     * @Route("/employee/add", name="employee_add")
     */
    public function emp_add() {
        return $this->render('add_employee.html.twig');
    }

    /**
     * @Route("/add_employee",name="add_emp")
     * @Route("/show_employee/{id}/edit",name="edit")
     * Method({"GET","POST"})
     */

     public function adding_emp(Employee $employee = null,Request $request){
            if(!$employee){
                $employee = new Employee();
            }

         $form = $this->createFormBuilder($employee)
                    ->add('nom',TextType::class,
                    array('attr'=> 
                        array('class' => 'form-control')))
                    
                    ->add('prenom',TextType::class,
                    array('attr'=> 
                        array('class' => 'form-control')))
                    
                    ->add('ServiceId',EntityType::class,
                    array('class' => Services::class,
                    'choice_label' => 'label'))
                    
                    ->add('RecrutedAt',DateType::class,
                        array('widget' => 'single_text'))
                    
                    ->add('Save',submitType::class,
                    array('attr'=> 
                        array('class' => 'btn btn-succes')))

                    ->getForm(); 

                    $form->handleRequest($request);
                    
                 if($form->isSubmitted() && $form->isValid()){
                     $employee = $form->getData();
                     
                     $Manag = $this->getDoctrine()->getManager();
                     $Manag->persist($employee);
                     $Manag->flush();
                     
                     return $this->redirectToRoute('employee') ;
                }
            return $this->render('add_employee.html.twig',array('form' => $form->createView() ));
        }
                
      /**
     * @Route("/show_employee/{id}", name="emp_show")
     */
    public function show_one_emp($id) {
        $the_emp_rep = $this->getDoctrine()->getRepository(Employee::class);
        $the_emp = $the_emp_rep->find($id);

        return $this->render('show_employee.html.twig',
        array('the_emp' => $the_emp) );
    }

    /**
     * @Route("//show_employee/{id}/delete",name="delete")
     */
    public function delete_emp(Request $request, $id){
        $the_emp_rep = $this->getDoctrine()->getRepository(Employee::class)->find($id);
        $Manag = $this->getDoctrine()->getManager();
        // var_dump($the_emp_rep);

        $Manag->remove($the_emp_rep);
        $Manag->flush();

        // $response = new response('deleted successfully');
        // $response->send() ;
        return $this->redirectToRoute('employee');
    }

}
