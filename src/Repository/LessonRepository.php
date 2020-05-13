<?php

namespace App\Repository;

use App\Entity\Grade;
use App\Entity\Lesson;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function findLessonsByGrade(Grade $grade): array
    {
        $queryBuilder = $this->createQueryBuilder('lesson')
                             ->where('lesson.grade = :grade')
                             ->setParameter('grade', $grade)
                             ->orderBy('lesson.start_date', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }

    public function findLessonsByGradeFromDate(Grade $grade, \DateTime $date): array
    {
        $queryBuilder = $this->createQueryBuilder('lesson')
                             ->where('lesson.grade = :grade')
                             ->andWhere('lesson.end_date > :date')
                             ->setParameter('grade', $grade)
                             ->setParameter('date', $date)
                             ->orderBy('lesson.start_date', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }

    public function findLessonsByTeacherFromDate(User $teacher, \DateTime $date): array
    {
        $queryBuilder = $this->createQueryBuilder('lesson')
                             ->where('lesson.teacher = :teacher')
                             ->andWhere('lesson.end_date > :date')
                             ->setParameter('teacher', $teacher)
                             ->setParameter('date', $date)
                             ->orderBy('lesson.start_date', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return Lesson[] Returns an array of Lesson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lesson
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
