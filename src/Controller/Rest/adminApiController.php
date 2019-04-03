<?php

namespace App\Controller\Rest;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Users;
use App\Entity\Groups;

class adminApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/user")
     * @param Request $request
     * @return View
     */
    public function addUser(Request $request, EntityManagerInterface $entityManager): View
    {
        $user = new Users();

        $user->setName($request->get('name'));
        $user->setUsername($request->get('username'));

        $entityManager->persist($user);
        $entityManager->flush();

        return View::create($user, Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/user/{id}")
     */
    public function deleteUser(int $id, EntityManagerInterface $entityManager): View
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if($user)
        {
            $entityManager->remove($user);
            $entityManager->flush();

            return View::create([], Response::HTTP_NO_CONTENT);
        }
        else return View::create([], Response::HTTP_NOT_FOUND);


    }

    /**
     * @Rest\Get("/user")
     * @Return View
     */
    public function getUsers(EntityManagerInterface $entityManager): View
    {
        $users = $entityManager->getRepository(Users::class)->findAll();

        return View::create($users, Response::HTTP_OK);
    }


    /**
     * @Rest\Post("/membership/{users_id}/{groups_id}")
     * @return View
     */
    public function assignUserToGroup(int $users_id, int $groups_id,
                                      EntityManagerInterface $entityManager): View
    {
        $user = $entityManager->getRepository(Users::class)->find($users_id);
        $group = $entityManager->getRepository(Groups::class)->find($groups_id);

        if(!$group->checkUser($user))
        {
            $group->addUser($user);

            $entityManager->persist($group);
            $entityManager->flush();

            return View::create($group, Response::HTTP_CREATED);
        }
        else return View::create($group, Response::HTTP_CONFLICT);
    }

    /**
     * @Rest\Delete("/membership/{users_id}/{groups_id}")
     */
    public function removeUserFromGroup(int $users_id, int $groups_id,
                                        EntityManagerInterface $entityManager): View
    {
        $user = $entityManager->getRepository(Users::class)->find($users_id);
        $group = $entityManager->getRepository(Groups::class)->find($groups_id);

        if($group->checkUser($user))
        {
            $group->removeUser($user);

            $entityManager->persist($group);
            $entityManager->flush();

            return View::create([], Response::HTTP_NO_CONTENT);
        }
        else return View::create($group, Response::HTTP_NOT_FOUND);


    }

    /**
     * @Rest\Post("/group")
     * @param Request $request
     * @return View
     */
    public function addGroup(Request $request, EntityManagerInterface $entityManager): View
    {
        $group = new Groups();

        $group->setName($request->get('name'));

        $entityManager->persist($group);
        $entityManager->flush();

        return View::create($group, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/group/{id}")
     */
    public function deleteGroup(int $id, EntityManagerInterface $entityManager): View
    {
        $group = $entityManager->getRepository(Groups::class)->find($id);

        if ($group->noUsers())
        {
            $entityManager->remove($group);
            $entityManager->flush();

            return View::create([], Response::HTTP_NO_CONTENT);
        }
        else return View::create($group, Response::HTTP_CONFLICT);
    }

    /**
     * @Rest\Get("/group")
     * @Return View
     */
    public function getGroups(EntityManagerInterface $entityManager): View
    {
        $groups = $entityManager->getRepository(Groups::class)->findAll();

        return View::create($groups, Response::HTTP_OK);
    }
}