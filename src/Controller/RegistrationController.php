<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $photoFile
             */
            $photoFile = $form->get('photoName')->getData();
            if ($photoFile) {
                $newFilename = 'img'.'-'.uniqid().'.'.$photoFile->guessExtension();
                    $photoFile->move(
                      $this->getParameter('user_photo_dir'),
                        $newFilename
                    );
                $user->setPhotoName($newFilename);
            }

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', "Vous êtes maintenant inscrit :)");
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'h1' => 'Inscription',
        ]);
    }
    /**
     * @Route("/gestion_compte", name="update_user")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppAuthenticator $authenticator
     * @return Response
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $photoFile
             */
            $photoFile = $form->get('photoName')->getData();
            if ($photoFile) {
                $newFilename = 'img'.'-'.uniqid().'.'.$photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('user_photo_dir'),
                    $newFilename
                );
                $user->setPhotoName($newFilename);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', "Le profil a bien été modifié");
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        return $this->render('registration/register.html.twig',[
            'registrationForm' => $form->createView(),
            'h1' => 'Modification',
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @Route ("/admin/user/{id}/delete", name="delete_user")
     */
    public function deleteUser($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository(Utilisateur::class);
        $user = $userRepo->find($id);
        $pseudo = $user->getPseudo();
        $em->remove($user);
        $em->flush();


        $this->addFlash('success', "L'utilisateur « ".$pseudo." » a bien été supprimé");

        return $this->redirectToRoute('admin');
    }
}
