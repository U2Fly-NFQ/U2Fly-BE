<?php

namespace App\Mapper;

use App\Constant\RoleConstant;
use App\Entity\Account;
use App\Repository\ImageRepository;
use App\Request\AddAccountRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AddAccountRequestMapper
{
    private ImageRepository $imageRepository;
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->imageRepository = $imageRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function mapper(AddAccountRequest $addAccountRequest): Account
    {
        $account = new Account();
        $image = $this->imageRepository->find($addAccountRequest->getImageId());
        $hashPassword = $this->passwordHasher->hashPassword($account, $addAccountRequest->getPassword());
        $account->setImage($image)
            ->setEmail($addAccountRequest->getEmail())
            ->setPassword($hashPassword);
        switch ($addAccountRequest->getRole()){
            case "ROLE_USER":
                $account->setRoles(RoleConstant::USER_ROLE);
                break;
            case "ROLE_ADMIN":
                $account->setRoles(RoleConstant::ADMIN_ROLE);
                break;
        }

        return $account;
    }
}