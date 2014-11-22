<?php

namespace AK\Bundle\WordLearnerBundle\Filter;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class Configurator
{
    const FILTER_BOOK_FILTER = 'book_filter';

    /** @var  EntityManager */
    protected $em;
    /** @var  SecurityContextInterface */
    protected $securityContext;

    public function __construct(EntityManager $em, SecurityContextInterface $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function onKernelRequest()
    {
        $user = $this->getUser();
        $em = $this->em;
        $filter = $em->getFilters()->enable(self::FILTER_BOOK_FILTER);
        if ($user instanceof UserInterface) {
            if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN') === true) {
                // super admin does not need filters
                $em->getFilters()->disable(self::FILTER_BOOK_FILTER);
            } else {
                $filter->setParameter('user_id', $user->getId());
            }
        } else {
            $filter->setParameter('user_id', 0);
        }
    }

    /**
     * @return UserInterface|null
     */
    private function getUser()
    {
        $user = null;

        $token = $this->securityContext->getToken();
        if ($token) {
            $user = $token->getUser();
            if (($user instanceof UserInterface) === false) {
                $user = null;
            }
        }

        return $user;
    }
}
