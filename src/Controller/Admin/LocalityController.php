<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Locality;
use App\Form\LocalityType;

final class LocalityController extends AbstractController
{
    /**
     * @Route("/admin/locality", name="admin_locality")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Locality::class);

        $localities = $repository->findAll();

        return $this->render('admin/locality/index.html.twig', [
            'localities' => $localities
        ]);
    }

    /**
     * @Route("/admin/locality/new", name="admin_locality_new")
     */
    public function new(Request $request)
    {
        $locality = new Locality();

        $form = $this->createForm(LocalityType::class, $locality)
            ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $locality->getName();
            $em = $this->getDoctrine()->getManager();
            $em->persist($locality);
            $em->flush();

            $this->addFlash('success', 'message.created');
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_locality_new');
            }
            return $this->redirectToRoute('admin_locality');
        }
        return $this->render('admin/locality/new.html.twig', [
            'locality' => $locality,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Locality entity.
     *
     * @Route("/admin/locality/{id<\d+>}/edit",methods={"GET", "POST"}, name="admin_locality_edit")
     */
    public function edit(Request $request, Locality $locality): Response
    {
        $form = $this->createForm(LocalityType::class, $locality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'message.updated');
            return $this->redirectToRoute('admin_locality');
        }
        return $this->render('admin/locality/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Locality entity.
     *
     * @Route("/locality/{id<\d+>}/delete", methods={"POST"}, name="admin_locality_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(Request $request, Locality $locality): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_locality');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($locality);
        $em->flush();
        $this->addFlash('success', 'message.deleted');
        return $this->redirectToRoute('admin_locality');
    }
}
