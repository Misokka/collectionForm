<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function new(Request $request): Response
    {
        $task = new Task();
        $task->setDescription("bonjour");
        // dummy code - add some example tags to the task
        // (otherwise, the template will render an empty list of tags)
        $tag1 = new Tag();
        $tag1->setName('tag1');
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag2');
        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($task);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute(route: "default");
        }   

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    // public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     if (null === $task = $entityManager->getRepository(Task::class)->find($id)) {
    //         throw $this->createNotFoundException('No task found for id '.$id);
    //     }

    //     $originalTags = new ArrayCollection();

    //     // Create an ArrayCollection of the current Tag objects in the database
    //     foreach ($task->getTags() as $tag) {
    //         $originalTags->add($tag);
    //     }

    //     $editForm = $this->createForm(TaskType::class, $task);

    //     $editForm->handleRequest($request);

    //     if ($editForm->isSubmitted() && $editForm->isValid()) {
    //         // remove the relationship between the tag and the Task
    //         foreach ($originalTags as $tag) {
    //             if (false === $task->getTags()->contains($tag)) {
    //                 // remove the Task from the Tag
    //                 $tag->getTasks()->removeElement($task);

    //                 // if it was a many-to-one relationship, remove the relationship like this
    //                 // $tag->setTask(null);

    //                 $entityManager->persist($tag);

    //                 // if you wanted to delete the Tag entirely, you can also do that
    //                 // $entityManager->remove($tag);
    //             }
    //         }

    //         $entityManager->persist($task);
    //         $entityManager->flush();

    //         // redirect back to some edit page
    //         return $this->redirectToRoute('task_edit', ['id' => $id]);
    //     }

    //     // ... render some form template
    // }
}






