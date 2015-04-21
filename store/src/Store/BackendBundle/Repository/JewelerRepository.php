<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

class JewelerRepository extends EntityRepository implements UserProviderInterface
{

    /**
     * Methode qui permet de retrouver un jeweler par son id
     * @param null $user
     * @return mixed
     */
    public function getJewelerByUser($user = null)
    {
        {
            $query = $this->getEntityManager()
                ->createQuery(
                "
                 SELECT j
                 FROM StoreBackendBundle:Jeweler AS j
                 WHERE j.id = :user
                "
                )
                ->setParameter(':user', $user);
            return $query->getOneOrNullResult();
        }
    }

    /**
     * Permet de loader un user par son email ou son username
     * @param string $username
     * @return mixed|null|UserInterface
     */
    public function loadUserByUsername($username)
    {
        $query = $this->createQueryBuilder('j')
            ->select('j, g')
            ->leftJoin('j.groups','g')
            ->where('j.username = :username OR j.email = :email')
            ->setParameters([':username' => $username, ':email' => $username])
            ->getQuery();

        try{
            // La méthode Query::getsingleResult() lance une exception NoResultException
            // s'il n'y'a pas d'entrée correspondante aux critères

            // Me retourner qu'un seul résultat avec la méthode getSingleResult()
            $user = $query->getSingleResult();
        }
        catch(NoResultException $e){
            // Si il n'y a aucun resultat, alors on retourne aucun utilisateur
            return null;
        }

        return $user;
    }

    /**
     * Rafraichi l'utilisateur par son token
     * Appeler pour rafraichir l'utilisateur en session par son token à chaque requete
     * A chaque requete, le rafrachisement de la session se fait par le token
     * @param UserInterface $user
     * @throws \Symfony\Component\Serializer\Exception\UnsupportedException
     * @return null|object|UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        return $this->find($user->getId());
    }

    /**
     * Get User class for recognize Authentification Class
     * Methode qui permet de déclarer cette classe repository
     * comme un Providers au mécanisme de sécurité de faire reconnaitre cette classe
     * comme EntityProvider
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }

}