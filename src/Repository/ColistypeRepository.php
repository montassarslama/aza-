<?php

namespace App\Repository;

use App\Entity\Colistype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Colistype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Colistype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Colistype[]    findAll()
 * @method Colistype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColistypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Colistype::class);
    }

    // /**
    //  * @return Colistype[] Returns an array of Colistype objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Colistype
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }->add('departure',ChoiceType::class,[
                'choices'=> array (
                    'Tunis'=>'Tunis',
                    'Sfax'=>'Sfax',
                    'Sousse'=>'Sousse',
                    'Kairouan'=>'Kairouan',
                    'Bizerte'=>'Bizerte',
                    'Gabès'=>'Gabès',
                    'Ariana'=>'Ariana',
                    'Gafsa'=>'Gafsa',
                    'Siliana'=>'Sliana',
                    'Monastir'=>'Monastir',
                    'Ben Arous'=>'Ben Arous',
                    'Kasserine'=>'Kasserine',
                    'Médenine'=>'Médenine',
                    'Nabeul'=>'Nabeul',
                    'Tataouine'=>'Tataouine',
                    'Béja'=>'Béja',
                    'Le Kef'=>'Le Kef',
                    'Mahdia'=>'Mahdia',
                    'Sidi Bouzid'=>'Sidi Bouzid',
                    'Jendouba'=>'Jendouba',
                    'Tozeur'=>'Tozeur',
                    'La Manouba'=>'La Manouba',
                    'Zaghouan'=>'Zaghouan',
                    'Kébili'=>'Kébili',  )
            ])

            ->add('destination',ChoiceType::class,[
                'choices'=> array(
                    'Tunis'=>'Tunis',
                    'Sfax'=>'Sfax',
                    'Sousse'=>'Sousse',
                    'Kairouan'=>'Kairouan',
                    'Bizerte'=>'Bizerte',
                    'Gabès'=>'Gabès',
                    'Ariana'=>'Ariana',
                    'Gafsa'=>'Gafsa',
                    'Siliana'=>'Sliana',
                    'Monastir'=>'Monastir',
                    'Ben Arous'=>'Ben Arous',
                    'Kasserine'=>'Kasserine',
                    'Médenine'=>'Médenine',
                    'Nabeul'=>'Nabeul',
                    'Tataouine'=>'Tataouine',
                    'Béja'=>'Béja',
                    'Le Kef'=>'Le Kef',
                    'Mahdia'=>'Mahdia',
                    'Sidi Bouzid'=>'Sidi Bouzid',
                    'Jendouba'=>'Jendouba',
                    'Tozeur'=>'Tozeur',
                    'La Manouba'=>'La Manouba',
                    'Zaghouan'=>'Zaghouan',
                    'Kébili'=>'Kébili',  )
            ])
    */
}
