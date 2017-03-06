<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Appel;
use AppBundle\Form\AppelType;

class AppelController extends Controller {

    /**
     * @Route("/appel/read", name="read_appel")
     * @Method("GET")
     */
    public function read_appelAction(Request $request) {
        // replace this example code with whatever you need

        $exercice= $this->getDoctrine()
            ->getManager()->getRepository('AppBundle:Exercice')
            ->findOneBy(Array('estActif'=>true));

        $appels= $this->getDoctrine()
            ->getManager()->getRepository('AppBundle:Appel')
            ->findBy(Array('exercice'=>$exercice->getId()),Array('id'=>'ASC'));

        $solde=($this->getDoctrine()->getManager()->getRepository('AppBundle:Appel')->getSommeajouter($exercice->getId()))-($this->getDoctrine()->getManager()->getRepository('AppBundle:Appel')->getSommeannuler($exercice->getId()));

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $users = $this->getDoctrine()->getManager()
            ->getRepository('Jac\UserBundle\Entity\User');
        $menus = $users->getMenus($user->getId());
        $sousMenus = $users->getSousMenus($user->getId());

        return $this->render('appel/appel/read_appel.html.twig', [
            'appels' => $appels, 'exercice'=>$exercice, 'solde'=> $solde,
            'sousMenus' => $sousMenus,
            'menus' => $menus,
        ]);

    }

    /**
     * Creates a new demand entity.
     *
     * @Route("/appel/create", name="create_appel")
     * @Method({"GET", "POST"})
     */
    public function create_appelAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $users = $this->getDoctrine()->getManager()
            ->getRepository('Jac\UserBundle\Entity\User');
        $menus = $users->getMenus($user->getId());
        $sousMenus = $users->getSousMenus($user->getId());
        $appel = new Appel();
        $form = $this->createForm('AppBundle\Form\AppelType', $appel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercice= $this->getDoctrine()
                ->getManager()->getRepository('AppBundle:Exercice')
                ->findOneBy(Array('estActif'=>true));
            $em = $this->getDoctrine()->getManager();
            $appel->setUserCreate($this->getUser()->getUsername());
            $appel->setDateCreate(new \ Datetime());
            $appel->setEstAnnuler(false);
            $appel->setEstParentannuler(false);
            $appel->setEstEncaisser(false);
            $appel->setExercice($exercice);
            $em->persist($appel);
            $em->flush();
            $this->addFlash(
                'success', "Enregistrement effectué avec succès !"
            );

            return $this->redirectToRoute('create_appel');
        }

        return $this->render('appel/appel/create_appel.html.twig', [
             'form'   => $form->createView(),
            'sousMenus' => $sousMenus,
            'menus' => $menus,
        ]);
    }

    /**
     * Creates a new demand entity.
     *
     * @Route("/appel/cancel", name="cancel_appel")
     * @Method({"GET", "POST"})
     */
    public function cancel_appelAction(Request $request)
    {

        $newappel = new Appel();
        $appel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Appel')
            ->find($request->get('id'));

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();

            $newappel->setUserCreate($this->getUser()->getUsername());
            $newappel->setDateCreate(new \ Datetime());
            $newappel->setEstAnnuler(true);
            $newappel->setEstParentannuler(false);
            $newappel->setEstEncaisser(false);
            $newappel->setExercice($appel->getExercice());
            $newappel->setBeneficiaire($appel->getBeneficiaire());
            $newappel->setDateAppel($appel->getDateAppel());
            $newappel->setDateBordereau($appel->getDateBordereau());
            $newappel->setDateEngagement($appel->getDateEngagement());
           // $newappel->setMonant($appel->getMonant());
            $newappel->setMontantTtc($appel->getMontantTtc());
            $newappel->setObjetappel($appel->getObjetappel());
            $newappel->setObservation($appel->getObservation());
            $newappel->setRefBordereau($appel->getRefBordereau());
            $newappel->setRefEngagement($appel->getRefEngagement());
            $newappel->setReferenceAppel($appel->getReferenceAppel());

            $newappel->setNumcomptetresor($appel->getNumcomptetresor());
            $newappel->setIntitulecomptetresor($appel->getIntitulecomptetresor());
            $em->persist($newappel);
            $appel->setEstParentannuler(true);
            $em->flush();
            $this->addFlash(
                'warning', "Modification effectué avec succès !"
            );

            return $this->redirectToRoute('read_appel', array('exercice' => $appel->getExercice()->getId()));
        }

    }

    /**
     * Creates a new demand entity.
     *
     * @Route("/appel/update", name="update_appel")
     * @Method({"GET", "POST"})
     */
    public function update_appelAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $users = $this->getDoctrine()->getManager()
            ->getRepository('Jac\UserBundle\Entity\User');
        $menus = $users->getMenus($user->getId());
        $sousMenus = $users->getSousMenus($user->getId());
        $appel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Appel')
            ->find($request->get('id'));
        $form = $this->createForm('AppBundle\Form\AppelType', $appel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $appel->setUserModif($this->getUser()->getUsername());
            $appel->setDateModif(new \ Datetime());
            $em->flush();
            $this->addFlash(
                'warning', "Modification effectué avec succès !"
            );

            return $this->redirectToRoute('read_appel');
        }
        return $this->render('appel/appel/update_appel.html.twig', [
            'form'   => $form->createView(), 'id'   => $request->get('id'), 'appel'   => $appel,
            'sousMenus' => $sousMenus,
            'menus' => $menus
        ]);
    }

    /**
     * Creates a new demand entity.
     *
     * @Route("/appel/delete", name="delete_appel")
     * @Method({"GET", "POST"})
     */
    public function delete_appelAction(Request $request)
    {
        $appel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Appel')
            ->find($request->get('id'));
        if ($request->getMethod() == 'POST'){
            $em = $this->getDoctrine()->getManager();
            $em->remove($appel);
            $em->flush();
            $this->addFlash(
                'danger', "Suppression effectué avec succès !"
            );

            return $this->redirectToRoute('read_appel');
        }
        return $this->render('appel/appel/delete_appel.html.twig', [
           'id'   => $request->get('id'), 'appel'   => $appel
        ]);
    }

}
