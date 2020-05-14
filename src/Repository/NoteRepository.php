<?php

namespace App\Repository;

use App\Entity\Note;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * Find notes for a specific user, with or without a limit for the results.
     *
     * @param User $user
     * @param null $limit
     * @return array
     */
    public function findNotesByUser(User $user, $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('note')
                             ->where('note.student = :user')
                             ->setParameter('user', $user)
                             ->orderBy('note.date', 'DESC') ;

        if (is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }
}
