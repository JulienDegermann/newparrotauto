<?php

namespace App\Traits\Pages;

use App\Entity\Message;
use App\Form\ContactType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

trait CreateFormTrait
{

  /**
   * Create a new message
   * @param string $route : target route if the form is valid
   * @param Request $request : request object
   * @param MessageRepository $messageRepository : repository for the message entity
   * @param ContactType $contactType : form type for the message entity
   * @param UserRepository $userRepository : repository for the user entity
   */
  public function newMessage(
    string $route,
    Request $request,
    MessageRepository $messageRepository,
    UserRepository $userRepository
  ) {
    $message = new Message();
    $form = $this->createForm(ContactType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user = $userRepository->findOneBy(['email' => $form->get('author')->get('email')->getData()]);
      if ($user) {
        $author = $user;
      } else {
        $author = $form->get('author')->getData();
      }
      $message = $form->getData();
      $message->setAuthor($author);
      $messageRepository->save($message);
      $this->addFlash(
        'success',
        'Le message est bien envoyé. '
      );
      return $this->redirectToRoute($route);
    }

    if ($form->isSubmitted() && !$form->isValid()) {
      $this->addFlash(
        'error',
        'Le message n\'a pas été envoyé. Veuillez vérifier les champs.'
      );
    }

    return $form;
  }
}
